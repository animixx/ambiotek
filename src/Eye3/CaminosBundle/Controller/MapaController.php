<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Templating\Helper\AssetsHelper;
use Eye3\CaminosBundle\Entity\Sightdata;
use Ivory\GoogleMap\Map,
	Ivory\GoogleMap\MapTypeId,
    Ivory\GoogleMap\Overlays\Marker,
	Ivory\GoogleMap\Overlays\Polyline,
	Ivory\GoogleMap\Events\Event,
	Ivory\GoogleMap\Events\MouseEvent,
	Ivory\GoogleMap\Overlays\InfoWindow;
	
class MapaController extends Controller
{
    /**
     * @Route("/mapa", name="mapa")
     * @Template()
     */
    public function indexAction(Request $request)
    {
		
		// $fecha = date("d-m-Y");
		$fecha = $request->request->get('fecha', '03-12-2014');;
		$date= date_create($fecha);

		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetSightDots($date->format('dmy'));
		$medicionXpuntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(false,$date->format('dmy'));
		$medicionXtramos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(true,$date->format('dmy'));

		$area = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetAreas($date->format('Y-m-d'));
		
		// todavia falta validar cuando mas de un area
		$tramos = (is_numeric($area))?$em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramos($area):array();
		
		$map = new Map();

		if( ( count($tramos) + count($puntos) + count($medicionXpuntos) + count($medicionXtramos))>0)
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
		$dot_yellow = 'http://eye3.cl/teck/bundles/eye3caminos/images/dot-yellow.png';
		
		// $dot_red =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-red.png');
		// $dot_blue =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-blue.png','eye3caminos');
		// $dot_green =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-green.png','eye3caminos');
		// $dot_yellow =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-yellow.png','eye3caminos');
		
		$cuentaPunto=0;
		
		$eventos[]=array('tramo','polylines');
		foreach ($medicionXtramos as $tramo)
		{
			$polyline="polyline".$tramo['id'];
			$infoWindow="infoWindow".$tramo['id'];
			$$polyline = new Polyline();
			$$polyline->setPrefixJavascriptVariable('tramo_');
			
			$punto_tramo = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramo($tramo['id']);
		// print_r($medicionXtramos);exit;

			if (is_array($punto_tramo))
			{
				foreach ($punto_tramo as $coordenada)
				{
					$$polyline->addCoordinate($coordenada['Y'], $coordenada['X'], true);
				}
			}

			$$infoWindow = new InfoWindow();

			// Configure your info window options
			$$infoWindow->setContent("<div >".$tramo['pm25']."</div>");
			$$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
			$$infoWindow->setOptions(array(
				'disableAutoPan' => true,
				'zIndex'         => 10,
				'flat'         => false,
				'width' => '200px',
				'pane' => "mapPane",
				'enableEventPropagation' => true
				));
			$$infoWindow->setOpen(true);
			$$infoWindow->setAutoOpen(true);
			$$infoWindow->setOpenEvent(MouseEvent::MOUSEOVER);
			$$infoWindow->setAutoClose(true);

			$$polyline->setInfoWindow($$infoWindow);
			
			$$polyline->setOptions(array(
				'geodesic'    => true,
				'strokeWeight'    => 8,
				'strokeOpacity'    => 0.4,
				'strokeColor' => '#FF0000',
			));
			$map->addPolyline($$polyline);
		}
		
		$eventos[]=array('ruta','polylines');
		foreach ($tramos as $tramo)
		{
			$polyline="polyline".$tramo['id'];
			$$polyline = new Polyline();
			$$polyline->setPrefixJavascriptVariable('ruta_');
			
			$punto_tramo = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramo($tramo['id']);

			if (is_array($punto_tramo))
			{
				foreach ($punto_tramo as $coordenada)
				{
					$$polyline->addCoordinate($coordenada['Y'], $coordenada['X'], true);
				}
			}
			
			$$polyline->setOptions(array(
				'geodesic'    => true,
				'strokeOpacity'    => 0.4,
				'strokeColor' => '#00ffff',
			));
			$map->addPolyline($$polyline);
		}
		
		$eventos[]=array('medicion','markers');
		foreach ($medicionXpuntos as $maraca)
		{
			
				$marker="marker".$maraca['id_gps'];
				$infoWindow="infoWindow".$maraca['id_gps'];
			// Add marker overlay to your map
				$$marker = new Marker();
				$$marker->setPrefixJavascriptVariable('medicion_');
				$$marker->setPosition($maraca['latitud'],$maraca['longitud'], true);  
				if ($maraca['id_tramo']>0)
					$$marker->setIcon($dot_green);
				else
					$$marker->setIcon($dot_red);

			$$infoWindow = new InfoWindow();
			
			// Configure your info window options
			$info='';
			if ($maraca['tsplat']) {$info.=" TSP=".$maraca['tsplat'];};
			if ($maraca['pm10lat']) {$info.=" PM10=".$maraca['pm10lat'];};
			if ($maraca['pm25lat']) {$info.=" PM2.5=".$maraca['pm25lat'];};
			if ($maraca['pm1lat']) {$info.=" PM1=".$maraca['pm1lat'];};
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
		
		$eventos[]=array('observacion','markers');
		foreach ($puntos as $marca)
		{
			// if (!is_numeric ($marca->getValue()))
			// {
				$latitud = substr($marca->getIdGps()->getLatitude(),0,2);
				$longitud = substr($marca->getIdGps()->getLongitude(),0,3);
				$decimal_latitud = substr($marca->getIdGps()->getLatitude(), 2);
				$decimal_longitud = substr($marca->getIdGps()->getLongitude(), 3);
				
					$cuentaPunto++;
					$marker="marker".$cuentaPunto;
					$infoWindow="infoWindow".$cuentaPunto;
				// Add marker overlay to your map
					$$marker = new Marker();
					$$marker->setPrefixJavascriptVariable('observacion_');
					$$marker->setPosition(-($latitud+($decimal_latitud/60+0.00002)),-($longitud+($decimal_longitud/60+0.00003)), true);  
					$$marker->setIcon($dot_blue);
					

				$$infoWindow = new InfoWindow();

				// Configure your info window options
				$$infoWindow->setContent("<div style='width:".(strlen($marca->getValue())*6+10)."px;'>".$marca->getValue()."</div>");
				$$infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
				$$infoWindow->setOptions(array(
					'disableAutoPan' => true,
					'zIndex'         => 10,
					'flat'         => false,
					'width' => '200px',
					'pane' => "mapPane",
					'enableEventPropagation' => true
					));
				$$infoWindow->setOpen(false);
				$$infoWindow->setAutoOpen(true);
				$$infoWindow->setOpenEvent(MouseEvent::MOUSEOVER);
				$$infoWindow->setAutoClose(true);

				$$marker->setInfoWindow($$infoWindow);
				
				$map->addMarker($$marker);
				 // if ($cuentaPunto==2 )break;
			// }
		}	
		
		foreach ($eventos as $evento)
		{
				$event = 'event_'.$evento[0];
				$instance = 'instance_'.$evento[0];
				$handle = 'handle_'.$evento[0];
				
				$$event = new Event();

				$$instance = 'document.getElementById("'.$evento[0].'")';
				$$handle = 'function(){ 
										var map; var container = '.$map->getJavascriptVariable().'_container; 
										if ('.$$instance.'.checked){ map = '.$map->getJavascriptVariable().';};
										for (var dato in container.'.$evento[1].') 
												{ if (dato.split("_",1)=="'.$evento[0].'") {container.'.$evento[1].'[dato].setMap(map)}}
									}';
				// Configure your event
				$$event->setInstance($$instance);
				$$event->setEventName('click');
				$$event->setHandle($$handle);
				
				$map->getEventManager()->addDomEvent($$event);
				
		}
	
		
		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
			   'fecha' => $fecha,
			   'rutas' => count($tramos),
			   'observaciones' => count($puntos),
			   'mediciones' => count($medicionXpuntos),
			   'tramos' => count($medicionXtramos),
            );    
	}
			
	/**
     * @Route("/riego", name="riego")
     * @Template()
     */
    public function riegoAction(Request $request)
    {
		
		// $fecha = date("d-m-Y");
		$fecha = $request->request->get('fecha', '03-12-2014');;
		$date= date_create($fecha);

		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetSightDots($date->format('dmy'));
		$medicionXpuntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(false,$date->format('dmy'));
		$medicionXtramos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(true,$date->format('dmy'));

		$area = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetAreas($date->format('Y-m-d'));
		
		// todavia falta validar cuando mas de un area
		$tramos = (is_numeric($area))?$em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramos($area):array();
		
		$map = new Map();

		if( ( count($tramos) + count($puntos) + count($medicionXpuntos) + count($medicionXtramos))>0)
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
		$dot_yellow = 'http://eye3.cl/teck/bundles/eye3caminos/images/dot-yellow.png';
		
		// $dot_red =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-red.png');
		// $dot_blue =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-blue.png','eye3caminos');
		// $dot_green =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-green.png','eye3caminos');
		// $dot_yellow =  $this->container->get('templating.helper.assets')->getUrl('bundles/eye3caminos/images/dot-yellow.png','eye3caminos');
		
		$cuentaPunto=0;
		
		
		$eventos[]=array('ruta','polylines');
		foreach ($tramos as $tramo)
		{
			$polyline="polyline".$tramo['id'];
			$$polyline = new Polyline();
			$$polyline->setPrefixJavascriptVariable('ruta_');
			
			$punto_tramo = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramo($tramo['id']);

			if (is_array($punto_tramo))
			{
				foreach ($punto_tramo as $coordenada)
				{
					$$polyline->addCoordinate($coordenada['Y'], $coordenada['X'], true);
				}
			}
			
			$$polyline->setOptions(array(
				'geodesic'    => true,
				'strokeOpacity'    => 0.4,
				'strokeColor' => '#00ffff',
			));
			$map->addPolyline($$polyline);
		}
		
		foreach ($eventos as $evento)
		{
				$event = 'event_'.$evento[0];
				$instance = 'instance_'.$evento[0];
				$handle = 'handle_'.$evento[0];
				
				$$event = new Event();

				$$instance = 'document.getElementById("'.$evento[0].'")';
				$$handle = 'function(){ 
										var map; var container = '.$map->getJavascriptVariable().'_container; 
										if ('.$$instance.'.checked){ map = '.$map->getJavascriptVariable().';};
										for (var dato in container.'.$evento[1].') 
												{ if (dato.split("_",1)=="'.$evento[0].'") {container.'.$evento[1].'[dato].setMap(map)}}
									}';
				// Configure your event
				$$event->setInstance($$instance);
				$$event->setEventName('click');
				$$event->setHandle($$handle);
				
				$map->getEventManager()->addDomEvent($$event);
				
		}
	
		
		$map->setStylesheetOptions(array(
			'width'  => '100%',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
			   'fecha' => $fecha,
			   'rutas' => count($tramos),
            );    
	}

}
