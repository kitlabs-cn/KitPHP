<?php
namespace KitNewsBundle\Controller;

use KitBaseBundle\Controller\BaseController;
use KitNewsBundle\Entity\Category;
use KitNewsBundle\Form\Type\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoryController extends BaseController
{

    public function indexAction($page)
    {
        if ($page < 1)
            $page = 1;
        $pagesize = 5;
        /**
         *
         * @var $repo \KitNewsBundle\Repository\CategoryRepository
         */
        $repo = $this->getDoctrine()->getRepository('KitNewsBundle:Category');
        $list = $repo->getList();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, $pagesize);
        return $this->render('KitNewsBundle:Category:index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    public function addAction(Request $request)
    {
        $errors = [];
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        
        $form->handleRequest($request);
        
        $em = $this->getEntityManager();
        
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 */
                $category = $form->getData();
                $em->persist($category);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '添加成功', 'kit_news_category');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitNewsBundle:Category:add.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }
    
    public function updateAction($id, Request $request)
    {
        $errors = [];
        /**
         *
         * @var $repo \KitNewsBundle\Repository\CategoryRepository
         */
        $repo = $this->getDoctrine()->getRepository('KitNewsBundle:Category');
        $category = $repo->find($id);
        if(!$category){
            return $this->msgResponse(2, '警告', '该记录不存在', 'kit_news_category');
        }
        $form = $this->createForm(CategoryType::class, $category);
    
        $form->handleRequest($request);
    
        $em = $this->getEntityManager();
    
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                /**
                 */
                $category = $form->getData();
                $em->persist($category);
                $em->flush();
                return $this->msgResponse(0, '恭喜', '修改成功', 'kit_news_category');
            } else {
                $errors = $this->serializeFormErrors($form);
            }
        }
        return $this->render('KitNewsBundle:Category:update.html.twig', [
            'update_form' => $form->createView(),
            'errors' => $errors
        ]);
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->request->get('id');
        $category = $this->getDoctrine()
            ->getRepository('KitNewsBundle:Category')
            ->find($id);
        if(!$category){
            return new JsonResponse([
                'code' => 0,
                'msg' => '该分类不存在'
            ]);
        }else{
            $em = $this->getEntityManager();
            $em->remove($category);
            $em->flush();
            return new JsonResponse([
                'code' => 1,
                'msg' => '删除成功'
            ]);
        }
    }
}