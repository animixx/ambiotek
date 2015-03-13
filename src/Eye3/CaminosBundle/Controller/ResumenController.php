<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\AssetsHelper;
use Eye3\CaminosBundle\Entity\Sightdata;
use Eye3\CaminosBundle\Entity\Aditivo;
use Ivory\GoogleMap\Map,
	Ivory\GoogleMap\MapTypeId,
    Ivory\GoogleMap\Overlays\Marker,
	Ivory\GoogleMap\Overlays\Polyline,
	Ivory\GoogleMap\Events\Event,
	Ivory\GoogleMap\Events\MouseEvent,
	Ivory\GoogleMap\Overlays\InfoWindow;

class ResumenController extends Controller
{
	
	/**
     * @Route("/ultimo", name="ultimo")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		
		// $fecha = date("d-m-Y");
		$fecha = $request->request->get('fecha', '12-03-2015');;
		$date= date_create($fecha);

		$em = $this->getDoctrine()->getManager();
		$medicionXpuntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(false,$date->format('dmy'));

		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GraficarMedicion(false,$date->format('Y-m-d'));
		
		$map = new Map();

		if(  count($medicionXpuntos) >0)
		{
			// Enable the auto zoom flag
			$map->setAutoZoom(true);
		}
		else
		{
			$map->setCenter(-21.004101,-68.792018, true);
			$map->setMapOption('zoom', 16);
		}
			
		$map->setMapOption('streetViewControl', false);
		$map->setMapOption('mapTypeId', MapTypeId::SATELLITE);
		$map->setMapOption('mapTypeControl', false);
	
		
		$dot_red = 'http://eye3.cl/teck/bundles/eye3caminos/images/punto_rojo.png';
		$dot_blue = 'http://eye3.cl/teck/bundles/eye3caminos/images/punto_azul.png';
		$dot_green = 'http://eye3.cl/teck/bundles/eye3caminos/images/punto_verde.png';
		$dot_lightgreen = 'http://eye3.cl/teck/bundles/eye3caminos/images/punto_verdeclaro.png';
		$dot_yellow = 'http://eye3.cl/teck/bundles/eye3caminos/images/dot-yellow.png';
		
		// $dot_red =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-red.png');
		// $dot_blue =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-blue.png','eye3caminos');
		// $dot_green =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-green.png','eye3caminos');
		// $dot_yellow =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-yellow.png','eye3caminos');
		
		$cuentaPunto=0;
		
		
		
		$eventos[]=array('medicion','markers');
		foreach ($medicionXpuntos as $maraca)
		{
			
				$marker="marker".$maraca['id_gps'];
				$infoWindow="infoWindow".$maraca['id_gps'];
			// Add marker overlay to your map
				$$marker = new Marker();
				$$marker->setPrefixJavascriptVariable('medicion_');
				$$marker->setPosition($maraca['latitude'],$maraca['longitude'], true);  
				if ($maraca['pm10lat']>999)
				{ $$marker->setIcon($dot_red);}
				elseif ($maraca['pm10lat']>599)
				{ $$marker->setIcon($dot_yellow);}
				elseif ($maraca['pm10lat']>299)
				{	$$marker->setIcon($dot_lightgreen);}
				else
				{ $$marker->setIcon($dot_green);}

			$$infoWindow = new InfoWindow();
			
			// Configure your info window options
			$info='';
			if ($maraca['pm10lat']) {$info.=" PM10=".$maraca['pm10lat'];};
			$$infoWindow->setContent("<div style='width:".(strlen($info)*6+10)."px;'>$info</div>");
			$$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
			// $$infoWindow->setOptions(array(
				// 'disableAutoPan' => true,
				// 'zIndex'         => 10,
				// 'flat'         => false,
				// 'width' => '200px',
				// 'pane' => "mapPane",
				// 'enableEventPropagation' => true
				// ));
			$$infoWindow->setOpen(false);
			$$infoWindow->setAutoOpen(true);
			$$infoWindow->setOpenEvent(MouseEvent::MOUSEOVER);
			$$infoWindow->setAutoClose(true);

			$$marker->setInfoWindow($$infoWindow);
			
			$map->addMarker($$marker);
			 // if ($cuentaPuto==263 )break;
		}	
		
		
		
		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
			   'fecha' => $fecha,
			   'datos' => $puntos,
			   'mediciones' => count($medicionXpuntos),
            );    
	}
	
	/**
     * @Route("/resumen", name="resumen")
     * @Template()
     */
    public function riegoAction(Request $request)
    {
		
		$end = $request->request->get('end', date("d-m-Y"));
		$date_end= date_create($end);
		$date_start= date_create($end);		/*valor temporal, que se modifica en la siguiente linea, es creado ahora solo para el caso inicial*/
		$start = $request->request->get('start',$date_start->modify('-3 months')->format('d-m-Y'));
		$date_start= date_create($start);
		
		$em = $this->getDoctrine()->getManager();
		$grafico = $em->getRepository('Eye3CaminosBundle:Aditivo')->GraficarAditivo($date_start->format('Y-m-d'),$date_end->format('Y-m-d'));
		
		$promedio = $em->getRepository('Eye3CaminosBundle:Sightdata')->GraficarMedicion(true,$date_end->format('Y-m-d'),$date_start->format('Y-m-d'));

        return array(
		    'start' => $start,
		    'end' => $end,
		    'grafico' => $grafico,
			'promedio' => $promedio,  
        );
	}
}
