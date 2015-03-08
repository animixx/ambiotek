<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
     /**
     * Lists all Default entities.
     *
     * @Route("/default", name="default")
	 * @return array
     */
	public function indexAction()
    {
        return $this->render('Eye3CaminosBundle:Default:index.html.twig');
    }
}
