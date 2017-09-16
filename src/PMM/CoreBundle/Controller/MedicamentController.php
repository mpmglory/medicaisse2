<?php

namespace PMM\CoreBundle\Controller;

use PMM\CoreBundle\Entity\Medicament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Medicament controller.
 *
 */
class MedicamentController extends Controller
{
    /**
     * Lists all medicament entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $medicaments = $em->getRepository('PMMCoreBundle:Medicament')->findAll();

        return $this->render('medicament/index.html.twig', array(
            'medicaments' => $medicaments,
        ));
    }

    /**
     * Creates a new medicament entity.
     *
     */
    public function newAction(Request $request)
    {
        $medicament = new Medicament();
        $form = $this->createForm('PMM\CoreBundle\Form\MedicamentType', $medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($medicament);
            $em->flush();

            return $this->redirectToRoute('medicament_show', array('id' => $medicament->getId()));
        }

        return $this->render('medicament/new.html.twig', array(
            'medicament' => $medicament,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a medicament entity.
     *
     */
    public function showAction(Medicament $medicament)
    {
        $deleteForm = $this->createDeleteForm($medicament);

        return $this->render('medicament/show.html.twig', array(
            'medicament' => $medicament,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medicament entity.
     *
     */
    public function editAction(Request $request, Medicament $medicament)
    {
        $deleteForm = $this->createDeleteForm($medicament);
        $editForm = $this->createForm('PMM\CoreBundle\Form\MedicamentType', $medicament);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medicament_edit', array('id' => $medicament->getId()));
        }

        return $this->render('medicament/edit.html.twig', array(
            'medicament' => $medicament,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medicament entity.
     *
     */
    public function deleteAction(Request $request, Medicament $medicament)
    {
        $form = $this->createDeleteForm($medicament);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medicament);
            $em->flush();
        }

        return $this->redirectToRoute('medicament_index');
    }

    /**
     * Creates a form to delete a medicament entity.
     *
     * @param Medicament $medicament The medicament entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medicament $medicament)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medicament_delete', array('id' => $medicament->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
