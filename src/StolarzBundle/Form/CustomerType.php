<?php

namespace StolarzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
            ->add( 'address', 'text', array( 'required' => true, 'label' => 'Adres: ' ) )
            ->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
            ->add( 'save', 'submit', array( 'label' => 'Stwórz klienta' ) )
            ->getForm()
            ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StolarzBundle\Entity\Customer'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stolarzbundle_customer';
    }


}
