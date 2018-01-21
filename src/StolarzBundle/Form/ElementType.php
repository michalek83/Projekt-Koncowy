<?php

namespace StolarzBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use StolarzBundle\Entity\Edge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ElementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('material', EntityType::class, array(
                'class' => 'StolarzBundle:Material',
                'choice_label' => 'name',
                'label' => 'Materiał: '
            ))
            ->add('quantity', NumberType::class, ['label' => 'Ilość: '])
            ->add('lenght', NumberType::class, ['label' => 'Długość: '])
            ->add('edgeLenght1', EntityType::class, array(
                'class' => 'StolarzBundle:Edge',
                'choice_label' => 'name',
                'label' => 'Obrzeże po długości 1'
            ))                                                                  //Dopisać skale i zaokrąglanie do pol z numerami
            ->add('edgeLenght2', EntityType::class, array(
                'class' => 'StolarzBundle:Edge',
                'choice_label' => 'name',
                'label' => 'Obrzeże po długości 2'
            ))
            ->add('width', NumberType::class, ['label' => 'Szerokość: '])
            ->add('edgeWidth1', EntityType::class, array(
                'class' => 'StolarzBundle:Edge',
                'choice_label' => 'name',
                'label' => 'Obrzeże po szerokości 1'
            ))
            ->add('edgeWidth2', EntityType::class, array(
                'class' => 'StolarzBundle:Edge',
                'choice_label' => 'name',
                'label' => 'Obrzeże po szerokości 2'
            ))
            ->add('rotatable', ChoiceType::class, array (
                'label' => 'Obrotowo: ',
                'choices' => array(
                    'Tak' => true,
                    'Nie' => false,
                ),
                'choices_as_values' => true,
            ))
            ->add( 'Dodaj', 'submit' )
			->getForm()
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
