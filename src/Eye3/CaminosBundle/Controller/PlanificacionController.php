<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Registro;

class PlanificacionController extends Controller
{
    /**
     * @Route("observaciones" , name="observaciones")
     * @Method("GET")
     * @Template()
	 * @param \Symfony\Component\HttpFoundation\Request $request
	 * @return array
     */
    public function observacionesAction(Request $request)
    {
         $fecha = date("d-m-Y");
		
		 $dataTable = $this->get('data_tables.manager')->getTable('observacionesTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
			'fecha' => $fecha,
        );
		
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
		
	
    /**
     * Displays a form to edit an existing Observacion entity.
     *
     * @Route("/observaciones/{id}/edit", name="observacion_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     */
    public function editObservacionAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Eye3CaminosBundle:Sightdata')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Observacion entity.');
        }

        $form = $this->createFormBuilder($entity, array(
            'method' => 'PUT',
        ))
			->add('value', 'text', array('label'=>'Observación','required' => true))
			->add('submit', 'submit', array('label' => 'Actualizar'))
			->getForm();
		
		$form->handleRequest($request);

        if ($form->isValid()) {
			$registry = new Registro();
			$registry->setAccion("Editado registro observación");
			$registry->setDetalle("Se modifica registro observación id=".$entity->getId()." a valor=".$entity->getValue());
			$registry->setFecha();
			$registry->setUsuario($this->getUser());
			$em->persist($registry);
            $em->flush();

            return $this->redirect($this->generateUrl('observaciones'));
        }
		
        return array(
            'entity'      => $entity,
            'form'   => $form->createView(),
        );
    }

	/**
     * Deletes a Observacion entity.
     *
     * @Route("/observaciones/deleteconfirm/{id}", name="observacion_deleteconfirm")
     * @Method("GET")
     * @Template("Eye3CaminosBundle:Niveles:deleteconfirm.html.twig")
     */
    public function borrarObservacionconfirmAction(Request $request, $id)
    {
		$deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);
        
		 return array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),
        );
    } 
	
    /**
     * Deletes a Observacion entity.
     *
     * @Route("/observaciones/{id}", name="observacion_delete")
     * @Method("DELETE")
     */
    public function deleteObservacionAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Eye3CaminosBundle:Sightdata')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Observacion entity.');
            }
			
			if($this->get('security.context')->isGranted('ROLE_DIOS')) 
			{
				$registry = new Registro();
				$registry->setAccion("Purgación Observación");
				
				$registry->setDetalle("Exterminada observación id=".$entity->getId().", gps=".$entity->getIdGps()->getId().", string=".$entity->getValue());
				$registry->setFecha();
				$registry->setUsuario($this->getUser());
				$em->persist($registry);
				$em->remove($entity);
				$em->flush();
			}
			else
			{
				$entity->setInvalido(1);
				$registry = new Registro();
				$registry->setAccion("Borrado registro observaciones");
				$registry->setDetalle("Se borra registro observaciones id=".$entity->getId());
				$registry->setFecha();
				$registry->setUsuario($this->getUser());
				$em->persist($registry);
				$em->persist($entity);
				$em->flush();
			}
        }

        return $this->redirect($this->generateUrl('observaciones'));
    }

    /**
     * Creates a form to delete a Observacion entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('observacion_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }

}
