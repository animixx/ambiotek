<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class MapaController extends Controller
{
    /**
     * @Route("/mapa", name="mapa")
     * @Template()
     */
    public function indexAction()
    {
        return array(
                // ...
            );    }

}
