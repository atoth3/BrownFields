<?php

namespace Bfvt\AreaBundle\Controller;

use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Bfvt\AreaBundle\Entity\Area;
use Bfvt\AreaBundle\Form\AreaType;

/**
 * Area controller.
 *
 */
class AreaController extends Controller
{
    /**
     * @Route("/", name="area")
     * @Template
     * Lists all Area entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AreaBundle:Area')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * @Route("/create", name="area_create")
     * @Method({"POST"})
     * @Template
     * Creates a new Area entity.
     *
     */
    public function createAction(Request $request)
    {
        $this->enforceUserSecurity();

        $entity = new Area();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->getUser();
            $entity->setOwner($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('area_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Area entity.
     *
     * @param Area $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Area $entity)
    {
        $form = $this->createForm(new AreaType(), $entity, array(
            'action' => $this->generateUrl('area_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * @Route("/new", name="area_new")
     * @Template
     * Displays a form to create a new Area entity.
     *
     */
    public function newAction()
    {
        $this->enforceUserSecurity();

        $entity = new Area();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/{id}/show", name="area_show")
     * @Template
     * Finds and displays a Area entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AreaBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/{id}/edit", name="area_edit")
     * @Template
     * Displays a form to edit an existing Area entity.
     *
     */
    public function editAction($id)
    {
        $this->enforceUserSecurity();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AreaBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $this->enforceOwnerSecurity($entity);

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Area entity.
    *
    * @param Area $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Area $entity)
    {
        $form = $this->createForm(new AreaType(), $entity, array(
            'action' => $this->generateUrl('area_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * @Route("/{id}/update", name="area_update")
     * @Method({"GET", "POST"})
     * @Template()
     * Edits an existing Area entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $this->enforceUserSecurity();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AreaBundle:Area')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Area entity.');
        }

        $this->enforceOwnerSecurity($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('area_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * @Route("/{id}/delete", name="area_delete")
     * @Method({"GET", "POST"})
     * Deletes a Area entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $this->enforceUserSecurity();

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AreaBundle:Area')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Area entity.');
            }

            $this->enforceOwnerSecurity($entity);

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('area'));
    }

    /**
     * Creates a form to delete a Area entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('area_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function enforceUserSecurity(){
        if (!$this->getSecurityContext()->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Need ROLE_ADMIN');
        }
    }
}
