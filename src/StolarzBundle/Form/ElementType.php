<?php

namespace StolarzBundle\Form;

use StolarzBundle\Entity\Element;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
//			->add('material', CollectionType::class, array(
//				'entry_type' => MaterialType::class,
//				'label' => 'Materiał: ',
//				'entry_options' => [
//
//					'label' => false,
//				],
//			))
			->add( 'material', EntityType::class, array(
				'class' => 'StolarzBundle:Material',
				'label' => 'Materiał: ',
				'choice_label' => 'name'
			) )
			->add( 'lenght', 'number', array( 'label' => 'Długość: ' ) )
			->add( 'lenghtEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 1: ' ) )
			->add( 'lenghtEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 2: ' ) )
			->add( 'width', 'number', array( 'label' => 'Szerokość: ' ) )
			->add( 'widthEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 1: ' ) )
			->add( 'widthEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 2: ' ) )
			->add( 'quantity', 'number', array( 'label' => 'Ilość: ' ) )
			->add( 'rotatable', 'checkbox', array( 'required' => false, 'label' => 'Obrotowo?: ' ) )
			->add( 'save', SubmitType::class, array( 'label' => 'Dodaj' ) )
		;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Element::class,
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
