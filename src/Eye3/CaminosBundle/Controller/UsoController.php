<?php

namespace Eye3\CaminosBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Eye3\CaminosBundle\Entity\Usuario;
use Eye3\CaminosBundle\Entity\Registro;


/**
 * Uso controller.
 *
 * @Route("/")
 */
class UsoController extends Controller
{

    /**
    * Lists all Registro entities.
    *
    * @Route("/uso", name="uso_sistema")
    * @Template()
	* @param \Symfony\Component\HttpFoundation\Request $request
    * @return array
    */
    public function indexAction(Request $request)
    {
        $dataTable = $this->get('data_tables.manager')->getTable('accesoTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
        );
    }

   
	/**
    * Lists all Users.
    *
    * @Route("/usuarios", name="usuarios")
    * @Template("Eye3CaminosBundle:Uso:user.html.twig")
	* @param \Symfony\Component\HttpFoundation\Request $request
    * @return array
    */
    public function userAction(Request $request)
    {
	
        $dataTable = $this->get('data_tables.manager')->getTable('usuariosTable');
        if ($response = $dataTable->ProcessRequest($request)) {
            return $response;
        }

        return array(
            'dataTable' => $dataTable,
        );
    }

	
	/**
    * Displays a form to create a new Usuario entity.
    *
    * @Route("/usuarios/new", name="nuevo_usuario")
    * @Template()
    */
    public function newAction(Request $request)
    {
		$entity = new Usuario();
		$tipos=array('user'=>'Usuario','admin'=>'Administrador');
		if($this->get('security.context')->isGranted('ROLE_DIOS')) $tipos['dios']='SuperAdmin';
		
        $form = $this->createFormBuilder( $entity, array(
            'method' => 'POST',
        ))
			->add('username', 'text', array('label'=>'Usuario','required' => true))
			->add('nombre', 'text', array('label'=>'Nombre','required' => true))
			->add('email', 'email',array('required' => true))
			->add('genero','choice', array(
			'empty_value' => 'Elija Genero',
			   'required' => true,
                'choices' => array(
                    '0'=>'Hombre',
                    '1'=>'Mujer',
                    ),
			'multiple'  => false,
                ))
            ->add('tipo','choice', array(
				'label' => 'Tipo Usuario',
				'empty_value' => 'Elija permisos',
                'choices' => $tipos,
				'multiple'  => false,
                ))
			->add('submit', 'submit', array('label' => 'Crear'))
            ->getForm();

		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$registry = new Registro();
			$registry->setAccion("Creación");
			$registry->setFecha();
			$registry->setUsuario($entity);
			$entity->setEnabled(1);
			$entity->setPassword('');
            $em->persist($entity);
            $em->persist($registry);
            $em->flush();

            return $this->redirect($this->generateUrl('usuarios'));
        }

        $entity = new Usuario();
		
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }	
	/**
    * Displays a form to edit a Usuario entity.
    *
    * @Route("/usuarios/edit/{id}", name="editar_usuario")
	* @Method("GET")
    * @Template()
    */
    public function editAction(Request $request,$id)
    {
		$entity = new Usuario();
		$tipos=array('user'=>'Usuario','admin'=>'Administrador');
		if($this->get('security.context')->isGranted('ROLE_DIOS')) $tipos['dios']='SuperAdmin';
		
        $form = $this->createFormBuilder( $entity, array(
            'method' => 'POST',
        ))
			->add('username', 'text', array('label'=>'Usuario','required' => true))
			->add('nombre', 'text', array('label'=>'Nombre','required' => true))
			->add('email', 'email',array('required' => true))
			->add('genero','choice', array(
			'empty_value' => 'Elija Genero',
			   'required' => true,
                'choices' => array(
                    '0'=>'Hombre',
                    '1'=>'Mujer',
                    ),
			'multiple'  => false,
                ))
            ->add('tipo','choice', array(
				'label' => 'Tipo Usuario',
				'empty_value' => 'Elija permisos',
                'choices' => $tipos,
				'multiple'  => false,
                ))
			->add('submit', 'submit', array('label' => 'Editar'))
            ->getForm();

		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$registry = new Registro();
			$registry->setAccion("Edición por ".$this->getUser());
			$registry->setFecha();
			$registry->setUsuario($entity);
			// $entity->setEnabled(1);
			// $entity->setPassword('');
            $em->persist($entity);
            $em->persist($registry);
            $em->flush();

            return $this->redirect($this->generateUrl('usuarios'));
        }

        $entity = new Usuario();
		
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
	
	/**
     * Deletes a Usuario entity.
     *
     * @Route("/usuarios/deleteconfirm/{id}", name="user_deleteconfirm")
     * @Method("GET")
     * @Template()
     */
    public function deleteconfirmAction(Request $request, $id)
    {
		$deleteForm = $this->createDeleteForm($id);
        $deleteForm->handleRequest($request);
        
		 return array(
            'entity'      => $id,
            'delete_form' => $deleteForm->createView(),
        );
		

    } 
	
	/**
     * Deletes a Usuario entity.
     *
     * @Route("/usuarios/{id}", name="users_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('Eye3CaminosBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Usuario entity.');
            }

            $entity->setEnabled(0);
			$registry = new Registro();
			$registry->setAccion("Eliminación");
			$registry->setFecha();
			$registry->setUsuario($entity);
            $em->persist($registry);
			$em->persist($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('usuarios'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm()
        ;
    }
}
