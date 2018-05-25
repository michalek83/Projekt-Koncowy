<?php

namespace StolarzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EdgeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
            ->add( 'thickness', 'number', array( 'required' => true, 'label' => 'Grubość: ', 'scale' => 2 ) )
            ->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
            ->add( 'save', 'submit', array( 'label' => 'Dodaj obrzeże' ) )
            ->getForm()
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StolarzBundle\Entity\Edge'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stolarzbundle_edge';
    }


}
