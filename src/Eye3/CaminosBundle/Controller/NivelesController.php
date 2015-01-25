<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class NivelesController extends Controller
{
    /**
     * @Route("/polvo", name="polvo")
     * @Template()
     */
    public function polvoAction(Request $request)
    {
		$rango = $request->request->get('rango');

		$fecha = $request->request->get('fecha', '03-12-2014');
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
		
		 $dataTable = $this->get('data_tables.manager')->getTable('aditivoTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
        );
		
	}

}
