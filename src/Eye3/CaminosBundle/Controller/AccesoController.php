<?php

namespace Eye3\CaminosBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Eye3\CaminosBundle\Entity\Usuario;
use Eye3\CaminosBundle\Form\UsuarioType;
use Eye3\CaminosBundle\Entity\Registro;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use FOS\UserBundle\Model\UserManagerInterface;


/**
 * Acceso controller.
 *
 * @Route("/")
 */
class AccesoController extends Controller
{

    /**
    * Lists all Registro entities.
    *
    * @Route("/uso", name="uso_sistema")
    * @Template()
	* @param \Symfony\Component\HttpFoundation\Request $request
    * @return array
    */
    public function usoAction(Request $request)
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
    * @Template()
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
		
		$form = $this->createForm(new UsuarioType(),  $entity, array(
            'method' => 'POST',
        ));

		if($this->get('security.context')->isGranted('ROLE_DIOS')) 
			$form->add('tipo','choice', array(
					'label' => 'Tipo Usuario',
					'empty_value' => 'Elija permisos',
					'choices' => array(
						'user'=>'Usuario',
						'sync'=>'Sincronizador',
						'plan'=>'Planificador',
						'admin'=>'Administrador',
						'dios'=>'SuperAdmin',
						),
					'multiple'  => false,
					));
		
		$form->add('submit', 'submit', array('label' => 'Crear'));

		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$registry = new Registro();
			$registry->setAccion("Creación");
			$registry->setDetalle("Creado como ".$entity->getTipo()." por ".$this->getUser());
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
	* @Method({"GET", "PUT"})
    * @Template()
    */
    public function editAction(Request $request,$id)
    {
		$em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Eye3CaminosBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

		$form = $this->createForm(new UsuarioType(), $entity, array(
            'method' => 'PUT',
        ));
		
		if($this->get('security.context')->isGranted('ROLE_DIOS')) 
			$form->add('tipo','choice', array(
					'label' => 'Tipo Usuario',
					'empty_value' => 'Elija permisos',
					'choices' => array(
						'user'=>'Usuario',
						'sync'=>'Sincronizador',
						'plan'=>'Planificador',
						'admin'=>'Administrador',
						'dios'=>'SuperAdmin',
						),
					'multiple'  => false,
					));
		 else
			$form->remove('username');

		$form->add('submit', 'submit', array('label' => 'Editar'));
		
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
			$registry = new Registro();
			$registry->setAccion("Modificación Usuario");
			$registry->setDetalle("Editado por ".$this->getUser());
			$registry->setFecha();
			$registry->setUsuario($entity);
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
    * Displays a form to edit a profile's Usuario entity.
    *
    * @Route("/profile", name="profile_usuario")
	* @Method({"GET", "PUT"})
    * @Template()
    */
    public function perfilAction(Request $request)
    {
		
		// print_r($this->getUser());exit;
		$em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('Eye3CaminosBundle:Usuario')->find($this->getUser());
        // $entity = $this->getUser();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

		$form = $this->createForm(new UsuarioType(), $entity, array(
            'method' => 'PUT',
        ));
		
		$form->add('current_password', 'password', array(
			'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'invalid_message' => 'contraseña no coincide con la actual.',
            'mapped' => false,
            'constraints' => new UserPassword(),
        ));
		
		$form
			->add('plainPassword', 'repeated', array(
                'type'=>'password',
                'invalid_message' => 'Las claves deben coincidir.',
                'first_options'  => array('label' => 'Contraseña'),
                'second_options' => array('label' => 'Confirmar'),
                ))
			->remove('username')
			->remove('tipo')
			->add('submit', 'submit', array('label' => 'Editar'));
		
        // $builder->add('plainPassword', 'repeated', array(
            // 'type' => 'password',
            // 'options' => array('translation_domain' => 'FOSUserBundle'),
            // 'first_options' => array('label' => 'form.new_password'),
            // 'second_options' => array('label' => 'form.new_password_confirmation'),
            // 'invalid_message' => 'fos_user.password.mismatch',
        // ));
		
		
        $form->handleRequest($request);

        if ($form->isValid()) {
			$userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($entity);
            $em = $this->getDoctrine()->getManager();
			$registry = new Registro();
			$registry->setAccion("Edición perfil");
			$registry->setFecha();
			$registry->setUsuario($entity);
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

			if($this->get('security.context')->isGranted('ROLE_DIOS')) 
			{
				$registry = new Registro();
				$registry->setAccion("Purgación Usuario");
				$registry->setDetalle("Exterminado usuario ".$entity->getNombre().", tipo=".$entity->getTipo());
				$registry->setFecha();
				$registry->setUsuario($this->getUser());
				$em->persist($registry);
				$em->remove($entity);
				$em->flush();
			}
			else
			{
				$entity->setLocked(1);
				$registry = new Registro();
				$registry->setAccion("Eliminación");
				$registry->setDetalle("Eliminado por ".$this->getUser());
				$registry->setFecha();
				$registry->setUsuario($entity);
				$em->persist($registry);
				$em->persist($entity);
				$em->flush();
			}
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
