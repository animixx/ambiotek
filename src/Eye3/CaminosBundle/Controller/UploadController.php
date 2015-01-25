<?php

namespace Eye3\CaminosBundle\Controller;

use Eye3\CaminosBundle\Entity\Upload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * Actividades controller.
 *
 * @Route("/")
 */
class UploadController extends Controller
{

		/**
		 * @Template()
		 * @Route("/subiendo", name="subida")
		 */
		public function uploadAction(Request $request)
		{
			$document = new Upload();
			$form = $this->createFormBuilder($document)
				->add('file')
				->getForm();

			$form->add('submit', 'submit', array('label' => 'Subir'));
			
			$form->handleRequest($request);

			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$document->setNombre($document->getFile()->getClientOriginalName());
				$document->upload();
				 
				$em->persist($document);
				$em->flush();

				return $this->redirect($this->generateUrl('subida'));
			}

			return array('form' => $form->createView());
		}
		
}