<?php

namespace KitNewsBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitNewsBundle\Entity\News;
use KitNewsBundle\Form\Type\NewsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DefaultController extends BaseController
{
    public function indexAction($page)
    {
        if($page < 1) $page = 1;
        $pagesize = 15;
        $repository = $this->getDoctrine()->getRepository('KitNewsBundle:News');
        $list = $repository->getList();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $list,
            $page,
            $pagesize
        );
        return $this->render('KitNewsBundle:Default:index.html.twig', [
            'pagination' => $pagination
        ]);
    }
    
    public function addAction(Request $request)
    {
        $errors = [];
        $em = $this->getEntityManager();
        $news = new News();
        $form = $this->createForm(NewsType::class, $news);
        
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()){
                /**
                 */
                $news = $form->getData();
                $news->setHits(0);
                $image = $news->getThumb();
                $fileName = $this->get('kit.file_uploader')->upload($image, 'image/' . date('Y/m'));
                $news->setThumb($fileName);
                $em->persist($news);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'kit_news_list');
            }else{
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitNewsBundle:Default:add.html.twig',[
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
    
    public function updateAction($id, Request $request)
    {
        $errors = [];
        /**
         *
         * @var $repo \KitNewsBundle\Repository\NewsRepository
        */
        $repo = $this->getDoctrine()->getRepository('KitNewsBundle:News');
        /**
         * @var $news \KitNewsBundle\Entity\News
         */
        $news = $repo->find($id);
        $fileName = $news->getThumb();
        if(!$news){
            return $this->msgResponse(2, '警告', '该记录不存在', 'kit_news_category');
        }
        $form = $this->createForm(NewsType::class, $news);
    
        $form->handleRequest($request);
    
        $em = $this->getEntityManager();
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 */
                $news = $form->getData();
                $file = $news->getThumb();
                if ($file instanceof UploadedFile) {
                    $fileName = $this->get('kit.file_uploader')->upload($file, 'video');
                }
                $news->setThumb($fileName);
                $em->persist($news);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '修改成功', 'kit_news_list');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitNewsBundle:Default:edit.html.twig', [
            'form' => $form->createView(),
            'content' => $news->getContent(),
            'errors' => $errors
        ]);
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $item = $this->getDoctrine()
        ->getRepository('KitNewsBundle:News')
        ->find($id);
        if(!$item){
            return new JsonResponse([
                'status' => 0,
                'msg' => '记录不存在'
            ]);
        }else{
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($item);
            $em->flush();
            return new JsonResponse([
                'status' => 1,
                'msg' => '删除成功'
            ]);
        }
    }
}
