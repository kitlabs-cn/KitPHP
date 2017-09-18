<?php

namespace KitAdminBundle\Controller;

use KitAdminBundle\Entity\ConfigCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Configcategory controller.
 *
 */
class ConfigCategoryController extends Controller
{
    /**
     * Lists all configCategory entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $configCategories = $em->getRepository('KitAdminBundle:ConfigCategory')->findAll();

        return $this->render('configcategory/index.html.twig', array(
            'configCategories' => $configCategories,
        ));
    }

    /**
     * Creates a new configCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $configCategory = new Configcategory();
        $form = $this->createForm('KitAdminBundle\Form\ConfigCategoryType', $configCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($configCategory);
            $em->flush();

            return $this->redirectToRoute('configcategory_show', array('id' => $configCategory->getId()));
        }

        return $this->render('configcategory/new.html.twig', array(
            'configCategory' => $configCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a configCategory entity.
     *
     */
    public function showAction(ConfigCategory $configCategory)
    {
        $deleteForm = $this->createDeleteForm($configCategory);

        return $this->render('configcategory/show.html.twig', array(
            'configCategory' => $configCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing configCategory entity.
     *
     */
    public function editAction(Request $request, ConfigCategory $configCategory)
    {
        $deleteForm = $this->createDeleteForm($configCategory);
        $editForm = $this->createForm('KitAdminBundle\Form\ConfigCategoryType', $configCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('configcategory_edit', array('id' => $configCategory->getId()));
        }

        return $this->render('configcategory/edit.html.twig', array(
            'configCategory' => $configCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a configCategory entity.
     *
     */
    public function deleteAction(Request $request, ConfigCategory $configCategory)
    {
        $form = $this->createDeleteForm($configCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($configCategory);
            $em->flush();
        }

        return $this->redirectToRoute('configcategory_index');
    }

    /**
     * Creates a form to delete a configCategory entity.
     *
     * @param ConfigCategory $configCategory The configCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ConfigCategory $configCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('configcategory_delete', array('id' => $configCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
