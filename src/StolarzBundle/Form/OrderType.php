<?php

namespace StolarzBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add( 'customer', EntityType::class, array(
                'class' => 'StolarzBundle:Customer',
                'label' => 'Klient: ',
                'choice_label' => 'name'
            ))
            ->add( 'orderName', TextType::class, array( 'required' => true, 'label' => 'Nazwa zamówienia: ' ) )
            ->add( 'Wybierz', 'submit', array('label' => 'Wybierz klienta') )
            ->getForm()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StolarzBundle\Entity\Order'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stolarzbundle_order';
    }


}
