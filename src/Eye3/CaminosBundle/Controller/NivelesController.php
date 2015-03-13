<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Aditivo;
use Eye3\CaminosBundle\Form\AditivoType;
use Eye3\CaminosBundle\Entity\Registro;

class NivelesController extends Controller
{
    /**
     * @Route("/polvo", name="polvo")
     * @Template()
     */
    public function polvoAction(Request $request)
    {
		$rango = $request->request->get('rango');
		$fecha = $request->request->get('fecha', '12-03-2015');
		$end = $request->request->get('end', $fecha);
		$date= date_create($fecha);
		$date_end= date_create($end);
		$date_start= date_create($end);		/*valor temporal, que se modifica en la siguiente linea, es creado ahora solo para el caso inicial*/
		$start = $request->request->get('start',$date_start->modify('-4 months')->format('d-m-Y'));
		$date_start= date_create($start);
		
		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GraficarMedicion(false,$date->format('Y-m-d'));
		$promedio = $em->getRepository('Eye3CaminosBundle:Sightdata')->GraficarMedicion(true,$date_end->format('Y-m-d'),$date_start->format('Y-m-d'));
		
		return array(
               'fecha' => $fecha,
               'rango' => $rango,
               'start' => $start,
               'end' => $end,
			   'datos' => $puntos,
			   'promedio' => $promedio,
            );    
	}
			
	/**
     * @Route("/aditivo", name="aditivo")
     * @Template()
     */
    public function aditivoAction(Request $request)
    {
		$rango = $request->request->get('rango','on');

		$end = $request->request->get('end', date("d-m-Y"));
		$date_end= date_create($end);
		$date_start= date_create($end);		/*valor temporal, que se modifica en la siguiente linea, es creado ahora solo para el caso inicial*/
		$start = $request->request->get('start',$date_start->modify('-6 months')->format('d-m-Y'));
		$date_start= date_create($start);
		
		$em = $this->getDoctrine()->getManager();
		$grafico = $em->getRepository('Eye3CaminosBundle:Aditivo')->GraficarAditivo($date_start->format('Y-m-d'),$date_end->format('Y-m-d'));
		
		 $dataTable = $this->get('data_tables.manager')->getTable('aditivoTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
		    'rango' => $rango,
		    'start' => $start,
		    'end' => $end,
		    'grafico' => $grafico,
			  
        );
		
	}
	
	 /**
     * Displays a form to create a new Aditivo entity.
     *
     * @Route("/aditivo/new", name="aditivo_new")
     * @Template()
     */
    public function newaditivoAction(Request $request)
    {
		 $entity = new Aditivo();
		$form = $this->createForm(new AditivoType(),  $entity, array(
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));


		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$entity->setUsuario($this->getUser());
			$registry = new Registro();
			$registry->setAccion("Creación registro aditivo");
			$registry->setDetalle("Se ingresa registro aditivo con fecha=".$entity->getFecha()->format('d-m-Y H:i').", Agua=".$entity->getAgua().", Aditivo=".$entity->getAditivo());
			$registry->setFecha();
			$registry->setUsuario($this->getUser());
			$em->persist($registry);
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('aditivo'));
        }

        // $entity = new Aditivo();
		
        return array(
            'entity' => $entity,
			'fecha' =>  new \DateTime("now"),
            'form'   => $form->createView(),
        );
    }
	
    /**
     * Displays a form to edit an existing Aditivo entity.
     *
     * @Route("/aditivo/{id}/edit", name="aditivo_edit")
     * @Method({"GET", "PUT"})
     * @Template()
     */
    public function editAditivoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Eye3CaminosBundle:Aditivo')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Aditivo entity.');
        }

        $editForm = $this->createForm(new AditivoType(), $entity, array(
            'method' => 'PUT',
        ));
        $editForm->add('submit', 'submit', array('label' => 'Actualizar'));
		
		$editForm->handleRequest($request);

        if ($editForm->isValid()) {
			$registry = new Registro();
			$registry->setAccion("Editado registro aditivo");
			$registry->setDetalle("Se modifica registro aditivo id=".$entity->getId()." a valores=> fecha=".$entity->getFecha()->format('d-m-Y H:i').", Agua=".$entity->getAgua().", Aditivo=".$entity->getAditivo());
			$registry->setFecha();
			$registry->setUsuario($this->getUser());
			$em->persist($registry);
            $em->flush();

            return $this->redirect($this->generateUrl('aditivo'));
        }
		
        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        );
    }

	
	/**
     * Deletes a Aditivo entity.
     *
     * @Route("/aditivo/deleteconfirm/{id}", name="aditivo_deleteconfirm")
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
     * Deletes a Aditivo entity.
     *
     * @Route("/aditivo/{id}", name="aditivo_delete")
     * @Method("DELETE")
     */
    public function deleteAditivoAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Eye3CaminosBundle:Aditivo')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Aditivo entity.');
            }

			$registry = new Registro();
			$registry->setAccion("Borrado registro aditivo");
			$registry->setDetalle("Se borra registro aditivo id=".$entity->getId());
			$registry->setFecha();
			$registry->setUsuario($this->getUser());
			$em->persist($registry);
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('aditivo'));
    }

    /**
     * Creates a form to delete a Aditivo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('aditivo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }
	

}
