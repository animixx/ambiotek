<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eye3\CaminosBundle\Entity\Sightdata;
use Ivory\GoogleMap\Map,
	Ivory\GoogleMap\MapTypeId,
    Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\InfoWindow;
use Ivory\GoogleMap\Events\MouseEvent;
	
class MapaController extends Controller
{
    /**
     * @Route("/mapa", name="mapa")
     * @Template()
     */
    public function indexAction()
    {
	
		$em = $this->getDoctrine()->getManager();
		$puntos = $em->getRepository('Eye3CaminosBundle:Sightdata')->GetPuntos();
		
		$map = new Map();

		// Enable the auto zoom flag
		$map->setAutoZoom(true);
		
	//	$map->setCenter(-21.0030005,-68.8088258, true);
		// $map->setMapOption('zoom', 16);
		
		$dot = 'http://issues.carrot2.org/secure/attachmentzip/unzip/10816/10145%5B1%5D/center-vertical/dot.png';
		
		$map->setMapOption('mapTypeId', MapTypeId::SATELLITE);
		$map->setMapOption('mapTypeId', 'satellite');
		$aux=1;
		
		foreach ($puntos as $marca)
		{
			$latitud = substr($marca->getIdGps()->getLatitude(),0,2);
			$longitud = substr($marca->getIdGps()->getLongitude(),0,3);
			$decimal_latitud = substr($marca->getIdGps()->getLatitude(), 2);
			$decimal_longitud = substr($marca->getIdGps()->getLongitude(), 3);
			
				
				$aux++;
				$marker="marker".$aux;
				$infoWindow="infoWindow".$aux;
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
			// if ($aux==3 )break;
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
