<?php

namespace Eye3\CaminosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
                'choices' => array(
                    'user'=>'Usuario',
					'sync'=>'Sincronizador',
                    'plan'=>'Planificador',
                    'admin'=>'Administrador',
                    ),
				'multiple'  => false,
                ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eye3\CaminosBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eye3_caminosbundle_usuario';
    }
}
