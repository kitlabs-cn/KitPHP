<?php

namespace KitAdminBundle\Controller;

use KitAdminBundle\Entity\BasicSetting;
use KitBaseBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Basicsetting controller.
 *
 */
class BasicSettingController extends BaseController
{
    /**
     * Lists all basicSetting entities.
     *
     */
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $basicSettings = $em->getRepository('KitAdminBundle:BasicSetting')->findAll();
        if($page < 1) $page = 1;
        $pagesize = 10;
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $basicSettings,
            $page,
            $pagesize
        );
        return $this->render('KitAdminBundle:BasicSetting:index.html.twig', array(
            'pagination' => $pagination,
        ));
    }

    /**
     * Creates a new basicSetting entity.
     *
     */
    public function newAction(Request $request)
    {
        $errors = [];
        $basicSetting = new BasicSetting();
        $form = $this->createForm('KitAdminBundle\Form\BasicSettingType', $basicSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basicSetting = $form->getData();
            $img = $basicSetting->getLogo();
            $filename = $this->get('kit.file_uploader')->upload($img,'image');
            $path = "/uploads".$filename;
            $basicSetting->setLogo($path);
            $em = $this->getDoctrine()->getManager();
            $em->persist($basicSetting);
            $em->flush($basicSetting);

            return $this->msgResponse(0,'完成','添加成功','kit_admin_basicsetting');
        }else{
            $errors = $this->serializeFormErrors($form);
        }

        return $this->render('KitAdminBundle:BasicSetting:new.html.twig', array(
            'errors' => $errors,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a basicSetting entity.
     *
     */
    public function showAction(BasicSetting $basicSetting)
    {
        $deleteForm = $this->createDeleteForm($basicSetting);

        return $this->render('basicsetting/show.html.twig', array(
            'basicSetting' => $basicSetting,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing basicSetting entity.
     *
     */
    public function editAction(Request $request)
    {
        $errors = [];
        $id = $request->query->getInt('id');
        /**
         * @var $basicSetting \KitAdminBundle\Entity\BasicSetting
         **/
        $basicSetting = $this->getDoctrine()->getRepository('KitAdminBundle:BasicSetting')->find($id);
        $oldfile = $basicSetting->getLogo();
        
        $basicSetting->setLogo('');
        $editForm = $this->createForm('KitAdminBundle\Form\BasicSettingType', $basicSetting);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $basicSetting = $editForm->getData();
            $img = $basicSetting->getLogo();
            if(!empty($img)){
                $filename = $this->get('kit.file_uploader')->upload($img,'image');
                $path = "/uploads".$filename;
                $basicSetting->setLogo($path);
                if(is_file($oldfile)){
                    unlink($oldfile);
                }
            }else{
                $basicSetting->setLogo($oldfile);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($basicSetting);
            $em->flush();

            return $this->msgResponse(0,'成功','修改成功','kit_admin_basicsetting_index');
         }else{
            $errors = $this->serializeFormErrors($editForm);
        }

        return $this->render('KitAdminBundle:BasicSetting:edit.html.twig', array(
            'errors' => $errors,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a basicSetting entity.
     *
     */
    public function deleteAction(Request $request, BasicSetting $basicSetting)
    {
        $form = $this->createDeleteForm($basicSetting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($basicSetting);
            $em->flush($basicSetting);
        }

        return $this->redirectToRoute('basicsetting_index');
    }

    /**
     * Creates a form to delete a basicSetting entity.
     *
     * @param BasicSetting $basicSetting The basicSetting entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BasicSetting $basicSetting)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('basicsetting_delete', array('id' => $basicSetting->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
