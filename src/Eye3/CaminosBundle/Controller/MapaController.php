<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ivory\GoogleMap\Map,
	Ivory\GoogleMap\MapTypeId,
    Ivory\GoogleMap\Overlays\Marker;
	
class MapaController extends Controller
{
    /**
     * @Route("/mapa", name="mapa")
     * @Template()
     */
    public function indexAction()
    {
	
		$map = new Map();

		// Enable the auto zoom flag
		// $map->setAutoZoom(true);
		
		$map->setCenter(-21.0030005,-68.8088258, true);
		$map->setMapOption('zoom', 15);
		
		
		$map->setMapOption('mapTypeId', MapTypeId::SATELLITE);
		$map->setMapOption('mapTypeId', 'satellite');

		// Add marker overlay to your map
			$marker = new Marker();
			$marker->setPosition(-21.0030005,-68.8088258, true);     
		$map->addMarker($marker);
		
		
		$map->setStylesheetOptions(array(
			'width'  => '800px',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
            );    }

}
