<?php

namespace Eye3\CaminosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanriegoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo','choice', array(
			'empty_value' => 'Seleccione tipo de riego',
			   'required' => true,
                'choices' => array(
                    'conformacion'=>'Conformación',
                    'conservacion'=>'Conservación',
                    'reparacion'=>'Reparación',
                    ),
			'multiple'  => false,
                ))
            ->add('tasaFinal','integer', array('label'=>'Tasa final a aplicar','required' => false,'attr' => array('min' => 0)))
            ->add('tasaRiego','integer', array('label'=>'Tasa de Riego','required' => true))
            ->add('dilucion','integer', array('label'=>'Dilucion de aditivo','required' => true))
            ->add('superficie','integer', array('label'=>'Superficie a regar','required' => true))
            ->add('ancho','integer', array('label'=>'Ancho promedio caminos','required' => true))
            ->add('tramos','choice', array(
				'multiple'  => true,
				'expanded'  => true,
				'label'  => "Tramos a regar",
                'choices' => array(
                    'T1'=>'T1',
                    'T2'=>'T2',
                    'T3'=>'T3',
                    'T4'=>'T4',
                    'T5'=>'T5',
                    'T6'=>'T6',
                    'T7'=>'T7',
                    'T8'=>'T8'
                    )
                ))
            ->add('volumen','integer', array('label'=>'Volumen por contenedor de aditivo','required' => true))
            ->add('estanque','integer', array('label'=>'Capacidad estanque aljibe','required' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eye3\CaminosBundle\Entity\Planriego'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eye3_caminosbundle_planriego';
    }
}
