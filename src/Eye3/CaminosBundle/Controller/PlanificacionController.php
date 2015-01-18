<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
	


}
