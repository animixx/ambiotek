<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Sightdata;
use Ivory\GoogleMap\Map,
	Ivory\GoogleMap\MapTypeId,
    Ivory\GoogleMap\Overlays\Marker,
	Ivory\GoogleMap\Overlays\Polyline,
	Ivory\GoogleMap\Events\MouseEvent,
	Ivory\GoogleMap\Overlays\InfoWindow;
	
class MapaController extends Controller
{
    /**
     * @Route("/mapa", name="mapa")
     * @Template()
     */
    public function indexAction()
    {
	
		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetSightDots();
		$medicionXpuntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion(false);
		$medicionXtramos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetMedicion();
		
		$tramos = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramos();
		
		$map = new Map();

		// Enable the auto zoom flag
		// $map->setAutoZoom(true);
		
		$map->setCenter(-21.004101,-68.792018, true);
		$map->setMapOption('zoom', 16);
		
		$dot = 'http://issues.carrot2.org/secure/attachmentzip/unzip/10816/10145%5B1%5D/center-vertical/dot.png';
		
		$map->setMapOption('mapTypeId', MapTypeId::SATELLITE);
		$map->setMapOption('mapTypeId', 'satellite');
		$cuentaPunto=1;
		
		foreach ($medicionXtramos as $tramo)
		{
			$polyline="polyline".$tramo['id'];
			$infoWindow="infoWindow".$tramo['id'];
			$$polyline = new Polyline();
			
			$punto_tramo = $em->getRepository('Eye3CaminosBundle:Gpsdata')->GetTramo($tramo['id']);

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
			$$infoWindow->setOpen(false);
			$$infoWindow->setAutoOpen(true);
			$$infoWindow->setOpenEvent(MouseEvent::MOUSEOVER);
			$$infoWindow->setAutoClose(true);

			// $$polyline->setInfoWindow($$infoWindow);
			
			$$polyline->setOptions(array(
				'geodesic'    => true,
				'strokeWeight'    => 8,
				'strokeOpacity'    => 0.4,
				'strokeColor' => '#FF0000',
			));
			$map->addPolyline($$polyline);
		}
		
		foreach ($tramos as $tramo)
		{
			$polyline="polyline".$tramo['id'];
			$$polyline = new Polyline();
			
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
		
		foreach ($puntos as $marca)
		{
			print_r($marca);exit;
			$latitud = substr($marca->getIdGps()->getLatitude(),0,2);
			$longitud = substr($marca->getIdGps()->getLongitude(),0,3);
			$decimal_latitud = substr($marca->getIdGps()->getLatitude(), 2);
			$decimal_longitud = substr($marca->getIdGps()->getLongitude(), 3);
			
				$cuentaPunto++;
				$marker="marker".$cuentaPunto;
				$infoWindow="infoWindow".$cuentaPunto;
			// Add marker overlay to your map
				$$marker = new Marker();
				$$marker->setPosition(-($latitud+($decimal_latitud/60)),-($longitud+($decimal_longitud/60)), true);  
				$$marker->setIcon($dot);
				

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
			 // if ($cuentaPunto==3 )break;
		}	
				
		foreach ($medicionXpuntos as $maraca)
		{
			
				$marker="marker".$maraca['id_gps'];
				$infoWindow="infoWindow".$maraca['id_gps'];
			// Add marker overlay to your map
				$$marker = new Marker();
				$$marker->setPosition($maraca['latitud'],$maraca['longitud'], true);  
				$$marker->setIcon($dot);
				

			$$infoWindow = new InfoWindow();

			// Configure your info window options
			$$infoWindow->setContent("<div >PM25=".$maraca['pm25lat']."</div>");
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
			 // if ($cuentaPunto==3 )break;
		}	
		
		
		$map->setStylesheetOptions(array(
			'width'  => '800px',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
            );    }

}
