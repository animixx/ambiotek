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
		$map->setAutoZoom(false);
		
		$map->setCenter(0, 0, true);
		$map->setMapOption('zoom', 5);
		
		$map->setBound(-21, -62, -22, -63, true, true);
		
		$map->setMapOption('mapTypeId', MapTypeId::SATELLITE);
		$map->setMapOption('mapTypeId', 'satellite');

		$map->setMapOption('mapTypeId', MapTypeId::TERRAIN);
		$map->setMapOption('mapTypeId', 'terrain');

		// Add marker overlay to your map
		$map->addMarker(new Marker());
		
		
		$map->setStylesheetOptions(array(
			'width'  => '800px',
			'height' => '500px'
		));

		$map->setLanguage('es');

        return array(
               'map' => $map,
            );    }

}
