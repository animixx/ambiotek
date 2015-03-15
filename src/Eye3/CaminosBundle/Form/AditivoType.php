<?php

namespace Eye3\CaminosBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AditivoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
			->add('fecha', 'datetime',array('label'=>'Fecha/Hora','widget'=>'single_text','format'=>'dd/MM/yyyy HH:mm' ))
			->add('agua', 'text', array('label'=>'Agua (m3)','required' => true))
			->add('aditivo', 'text', array('label'=>'Aditivo (m3)','required' => true))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Eye3\CaminosBundle\Entity\Aditivo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'form_aditivo';
    }
}
