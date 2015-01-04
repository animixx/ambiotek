<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Actividades;
use Eye3\CaminosBundle\Form\ActividadesType;

/**
 * Actividades controller.
 *
 * @Route("/")
 */
class ActividadesController extends Controller
{

    /**
     * Lists all Actividades entities.
     *
     * @Route("/observaciones", name="observaciones")
     * @Method("GET")
     * @Template()
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @return array
     */
    public function observacionesAction(Request $request)
    {
        $fecha = date("d-m-Y");
		
		 $dataTable = $this->get('data_tables.manager')->getTable('actividadesTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
			'fecha' => $fecha,
        );

    }
	
    /**
     * Creates a new Actividades entity.
     *
     * @Route("/actividades", name="actividades_create")
     * @Method("POST")
     * @Template("Eye3CaminosBundle:Actividades:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Actividades();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actividades_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Actividades entity.
     *
     * @param Actividades $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Actividades $entity)
    {
        $form = $this->createForm(new ActividadesType(), $entity, array(
            'action' => $this->generateUrl('actividades_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Actividades entity.
     *
     * @Route("/actividades/new", name="actividades_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Actividades();
        $form = $this->createFormBuilder( $entity, array(
            'method' => 'POST',
        ))
			->add('usuario', 'text', array('label'=>'Usuario','required' => true))
			->add('actividad', 'text', array('label'=>'Actividad','required' => true))
			->add('hora', 'time',array('label'=>'Hora','widget'=>'single_text'))
			->add('fecha', 'date',array('label'=>'Fecha','widget'=>'single_text'))
		
			->add('submit', 'submit', array('label' => 'Crear'))
            ->getForm();

		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('actividades'));
        }

        $entity = new Actividades();
		
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Actividades entity.
     *
     * @Route("/actividades/{id}", name="actividades_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Eye3CaminosBundle:Actividades')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividades entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Actividades entity.
     *
     * @Route("/{id}/edit", name="actividades_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Eye3CaminosBundle:Actividades')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividades entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Actividades entity.
    *
    * @param Actividades $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Actividades $entity)
    {
        $form = $this->createForm(new ActividadesType(), $entity, array(
            'action' => $this->generateUrl('actividades_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Actividades entity.
     *
     * @Route("/actividades/{id}", name="actividades_update")
     * @Method("PUT")
     * @Template("Eye3CaminosBundle:Actividades:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('Eye3CaminosBundle:Actividades')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Actividades entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('actividades_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
	/**
     * Deletes a Actividades entity.
     *
     * @Route("/actividades/deleteconfirm/{id}", name="actividad_deleteconfirm")
     * @Method("GET")
     * @Template()
     */
    public function deleteconfirmAction(Request $request, $id)
    {
		$deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);
        
		 return array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),
        );
		

    } 
	
    /**
     * Deletes a Actividades entity.
     *
     * @Route("/actividades/{id}", name="actividades_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Eye3CaminosBundle:Actividades')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Actividades entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('actividades'));
    }

    /**
     * Creates a form to delete a Actividades entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('actividades_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }
	
	/**
     * @Route("/conductores", name="conductores")
     * @Template()
     */
    public function conductoresAction()
    {
        $fecha = date("d-m-Y");

		return array(
                'fecha' => $fecha,
            );    
	}
	

}
