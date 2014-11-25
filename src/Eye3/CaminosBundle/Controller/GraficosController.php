<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class GraficosController extends Controller
{
    /**
     * @Route("/graficos", name="graficos")
     * @Template()
     */
    public function indexAction()
    {
        $fecha = date("d-m-Y");
		
		return array(
               'fecha' => $fecha,
            );    }

}
