<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GraficosController extends Controller
{
    /**
     * @Route("/polvo", name="polvo")
     * @Template()
     */
    public function polvoAction(Request $request)
    {
		$fecha = $request->request->get('fecha', '03-12-2014');;
		$date= date_create($fecha);
		
		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GraficarMedicion(false,$date->format('dmy'));
		
		return array(
               'fecha' => $fecha,
			   'datos' => $puntos,
            );    
	}
			
	/**
     * @Route("/aditivo", name="aditivo")
     * @Template()
     */
    public function aditivoAction(Request $request)
    {
        $fecha = date("d-m-Y");
		
		return array(
               'fecha' => $fecha,
            );    
	}

}
