<?php

namespace Eye3\CaminosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActividadesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('usuario', 'text', array('label'=>'Usuario','required' => true))
			->add('actividad', 'text', array('label'=>'Actividad','required' => true))
			->add('hora', 'time',array('label'=>'Hora','widget'=>'single_text'))
			->add('fecha', 'date',array('label'=>'Fecha','widget'=>'single_text'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eye3\CaminosBundle\Entity\Actividades'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'eye3_caminosbundle_actividades';
    }
}
