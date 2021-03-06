<?php

namespace PatrimoineBundle\Controller;

use PatrimoineBundle\Entity\Accueil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Accueil controller.
 *
 */
class AccueilController extends Controller
{
    /**
     * Lists all accueil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('PatrimoineBundle:Accueil')->findAll();

        return $this->render('PatrimoineBundle:accueil:index.html.twig', array(
            'accueils' => $accueils,
        ));
    }

    /**
     * Creates a new accueil entity.
     *
     */
    public function newAction(Request $request)
    {
        $accueil = new Accueil();
        $form = $this->createForm('PatrimoineBundle\Form\AccueilType', $accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil);
            $em->flush($accueil);

            return $this->redirectToRoute('accueil_edit', array('id' => $accueil->getId()));
        }

        return $this->render('PatrimoineBundle:accueil:new.html.twig', array(
            'accueil' => $accueil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing accueil entity.
     *
     */
    public function editAction(Request $request, Accueil $accueil)
    {
        $deleteForm = $this->createDeleteForm($accueil);
        $editForm = $this->createForm('PatrimoineBundle\Form\AccueilType', $accueil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('accueil_edit', array('id' => $accueil->getId()));
        }

        return $this->render('PatrimoineBundle:accueil:edit.html.twig', array(
            'accueil' => $accueil,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a accueil entity.
     *
     */
    public function deleteAction(Request $request, Accueil $accueil)
    {
        $form = $this->createDeleteForm($accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accueil);
            $em->flush($accueil);
        }

        return $this->redirectToRoute('accueil_index');
    }

    /**
     * Creates a form to delete a accueil entity.
     *
     * @param Accueil $accueil The accueil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Accueil $accueil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('accueil_delete', array('id' => $accueil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
