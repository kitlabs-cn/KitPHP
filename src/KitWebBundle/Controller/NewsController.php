<?php
namespace KitWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{

    public function indexAction()
    {
        // $dataUri = $this->generateUrl('kit_web_news_data');
        return $this->render('KitWebBundle:News:index.html.twig', [])
        // 'data_uri' => $dataUri
        ;
    }

    public function listAction(Request $request, $id, $page)
    {
        $cid = intval($request->query->get('cid', 0));
        if ($page < 1)
            $page = 1;
        $pagesize = 15;
        $repository = $this->getDoctrine()->getRepository('KitNewsBundle:News');
        $latest = $repository->findBy([
            'status' => 1
        ], [
            'id' => 'DESC'
        ], 10, 0);
        $category = $this->getDoctrine()
            ->getRepository('KitNewsBundle:Category')
            ->find($id);
        if (empty($category)) {
            throw new NotFoundHttpException();
        }
        $qid = $cid > 0 ? $cid : $id;
        $list = $repository->getListByCategory($qid);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($list, $page, $pagesize);
        $subclass = $this->getDoctrine()
            ->getRepository('KitNewsBundle:Category')
            ->getSubCategory($id);
        return $this->render('KitWebBundle:News:list.html.twig', [
            'nav' => $id,
            'pagination' => $pagination,
            'subclass' => $subclass,
            'latest' => $latest,
            'catename' => $category->getName()
        ]);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        /**
         *
         * @var $repository \KitNewsBundle\Repository\NewsRepository
         */
        $repository = $em->getRepository('KitNewsBundle:News');
        /**
         *
         * @var $news \KitNewsBundle\Entity\News
         */
        $news = $repository->find($id);
        $latest = $repository->findBy([
            'status' => 1
        ], [
            'id' => 'DESC'
        ], 10, 0);
        $catename = $news->getCategory()->getName();
        if (empty($news)) {
            throw new NotFoundHttpException();
        }else{
            $em = $this->getDoctrine()->getManager();
            $news->setHits($news->getHits() + 1);
            $em->persist($news);
            $em->flush();
        }
        /**
         *
         * @var $news \KitNewsBundle\Entity\News
         */
        $categoryId = $news->getCategory()
            ->getParent()
            ->getId();
        if (1 == $categoryId) {
            $categoryId = $news->getCategory()->getId();
        }
        $category = $this->getDoctrine()
        ->getRepository('KitNewsBundle:Category')
        ->find($categoryId);
        $subclass = $this->getDoctrine()
            ->getRepository('KitNewsBundle:Category')
            ->getSubCategory($categoryId);
        $result = $repository->getPrevAndNext($id);
        return $this->render('KitWebBundle:News:show.html.twig', [
            'nav' => $categoryId,
            'news' => $news,
            'subclass' => $subclass,
            'latest' => $latest,
            'catename' => $category->getName(),
            'prev' => $result['prev'],
            'next' => $result['next'],
        ]);
    }

}