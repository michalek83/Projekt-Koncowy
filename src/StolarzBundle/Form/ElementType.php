<?php

namespace StolarzBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
        $builder->add('lenght')
			->add('width')
			->add('quantity')
			->add('lenghtEdge1')
			->add('lenghtEdge2')
			->add('widthEdge1')
			->add('widthEdge2')
			->add('rotatable')
//			->add('material', CollectionType::class, array(
//                'label' => "Materiał: ",
//                'entry_type' => EntityType::class,
//                'entry_options' => array(
//                    'class' => 'StolarzBundle:Material',
//                    'choice_label' => 'name'
//                ),
//                'allow_add' => true,
//                'prototype' => true
//            ))
			->add( 'material', EntityType::class, array(
				'class' => 'StolarzBundle:Material',
				'label' => 'Materiał: ',
				'choice_label' => 'name'
			) )
			->add( 'Dodaj', 'submit' )
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
