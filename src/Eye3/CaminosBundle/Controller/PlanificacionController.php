<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Registro;
use Eye3\CaminosBundle\Entity\Usuario;
use Eye3\CaminosBundle\Entity\Planriego;
use Eye3\CaminosBundle\Form\PlanriegoType;

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
	
	 /**
     * Displays a form to add/edit an Planriego entity.
     *
     * @Route("/priego", name="plan_riego")
	 * @Template()
     */
     public function planRiegoAction(Request $request)
    {
		
		$em = $this->getDoctrine()->getManager();

		$dato = $em->getRepository('Eye3CaminosBundle:Planriego')->LastDato();
		$entity2 = new Planriego();
		
		if (isset($dato)){
			$entity = $em->getRepository('Eye3CaminosBundle:Planriego')->find($dato);
				$entity2->setTipo($entity->getTipo());
				$entity2->setTasaFinal($entity->getTasaFinal());
				$entity2->setTasaRiego($entity->getTasaRiego());
				$entity2->setDilucion($entity->getDilucion());
				$entity2->setSuperficie($entity->getSuperficie());
				$entity2->setAncho($entity->getAncho());
				$entity2->setTramos($entity->getTramos());
				$entity2->setVolumen($entity->getVolumen());
				$entity2->setEstanque($entity->getEstanque());

			if (!$entity) {
				throw $this->createNotFoundException('Unable to find Planriego entity.');
			}
		}
		
		
		$form = $this->createForm(new PlanriegoType(),  $entity2, array(
            'method' => 'POST',
        ));
		
		if($this->get('security.context')->isGranted('ROLE_PLAN')) 
			$form->add('validar', 'submit', array('label' => 'Validar'));
		
        $form->add('submit', 'submit', array('label' => 'Crear'));


		
        $form->handleRequest($request);

        if ($form->isValid()) {
			if($this->get('security.context')->isGranted('ROLE_PLAN') and $form->get('validar')->isClicked()) 
				$entity2->setValidado(1);
			else
				$entity2->setValidado(0);
			
			$entity2->setCuando();
			$entity2->setQuien($em->getRepository('Eye3CaminosBundle:Usuario')->find($this->getUser()));
			$registry = new Registro();
			$registry->setAccion("Se ".(($entity2->getValidado())?'Valida':'Guarda')." plan Riego");
			$registry->setDetalle("Valores: tipo=".$entity2->getTipo().",final=".$entity2->getTasaFinal().",riego=".$entity2->getTasaRiego().",dilucion=".$entity2->getDilucion().",superficie=".$entity2->getSuperficie().",ancho=".$entity2->getAncho().",tramos=".(implode(',',$entity2->getTramos())).",volumen=".$entity2->getVolumen().",estanque=".$entity2->getEstanque());
			$registry->setFecha();
			$registry->setUsuario($em->getRepository('Eye3CaminosBundle:Usuario')->find($this->getUser()));
            $em->persist($entity2);
            $em->persist($registry);
		
            $em->flush();

            return $this->redirect($this->generateUrl('plan_riego'));
        }

		
        return array(
            'form'   => $form->createView(),
        );
    }
}
