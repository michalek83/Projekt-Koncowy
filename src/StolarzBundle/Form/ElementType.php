<?php

namespace StolarzBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('order')
            ->add('material')
            ->add('lenght')
            ->add('width')
            ->add('quantity')
            ->add('lenghtEdge1')
            ->add( 'edgeLenght1', 'entity', array(
                'class' => 'StolarzBundle:Edge',
                'label' => 'Okleina po długości 1: ',
                'choice_label' => 'name'
            ) )
            ->add('lenghtEdge2')
            ->add( 'edgeLenght2', 'entity', array(
                'class' => 'StolarzBundle:Edge',
                'label' => 'Okleina po długości 2: ',
                'choice_label' => 'name'
            ) )
            ->add('widthEdge1')
            ->add( 'edgeWidth1', 'entity', array(
                'class' => 'StolarzBundle:Edge',
                'label' => 'Okleina po szerokości 1: ',
                'choice_label' => 'name'
            ) )
            ->add('widthEdge2')
            ->add( 'edgeWidth2', 'entity', array(
                'class' => 'StolarzBundle:Edge',
                'label' => 'Okleina po szerokości 2: ',
                'choice_label' => 'name'
            ) )
            ->add('rotatable')

            ->add( 'lenght', 'number', array( 'label' => 'Długość: ' ) )
            ->add( 'lenghtEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 1: ' ) )
            ->add( 'lenghtEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 2: ' ) )
            ->add( 'width', 'number', array( 'label' => 'Szerokość: ' ) )
            ->add( 'widthEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 1: ' ) )
            ->add( 'widthEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 2: ' ) )
            ->add( 'quantity', 'number', array( 'label' => 'Ilość: ' ) )
            ->add( 'rotatable', 'checkbox', array( 'required' => false, 'label' => 'Obrotowo?: ' ) )

            ;
    }



    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'StolarzBundle\Entity\Element'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'stolarzbundle_element';
    }


}
