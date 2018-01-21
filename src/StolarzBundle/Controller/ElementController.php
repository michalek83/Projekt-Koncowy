<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Customer;
use StolarzBundle\Entity\Edge;
use StolarzBundle\Entity\Material;
use StolarzBundle\Entity\Element;
use StolarzBundle\Entity\Order;
use StolarzBundle\Form\ElementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * @Route("/element")
 */
class ElementController extends Controller
{
	/**
	 * @Route("/", name="elementMain")
	 */
	public function elementMainAction( Request $request )
	{
		$elementRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Element' );
		$allElements = $elementRepository->findAll();

		$session = $request->getSession();
		$order = $session->get('customer');

		$confirmation = $session->get('confirmation');
        $session->set('confirmation', null);
        $exist = $session->get('exist');
        $session->set('exist', null);
        $deleted = $session->get('deleted');
        $session->set('deleted', null);

		return $this->render( 'StolarzBundle::elementMain.html.twig',
			array(
                'confirmation' => $confirmation,
				'allElements' => $allElements,
				'order' => $order,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}

	/**
	 * @Route("/create1", name="createElement1")
	 */
	public function createElement1Action( Request $request )
	{
		$element = new Element();
		$form = $this->createForm(ElementType::class, $element);

		$session = $request->getSession();
		$order = $session->get( 'customer', null );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$element = $form->getData();
			var_dump( $element );
			$em = $this->getDoctrine()->getManager();
			$em->persist( $element );
//            $em->flush();

			$session = $request->getSession();
			$session->set( 'confirmation', "Zamówienie zapisano poprawnie." );

			return $this->redirectToRoute( 'elementMain' );
		}

		return $this->render( 'StolarzBundle::elementCreate1.html.twig', array(
			'form' => $form->createView(),
			'order' => $order ) );
	}

	/**
	 * @Route("/create", name="createElement")
	 */
	public function createElementAction( Request $request )
	{
		$element = new Element();
		$form = $this->createFormBuilder( $element )
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
//            ->add('edge', CollectionType::class, array(
//                'label' => "Obrzeże: ",
//                'entry_type' => EntityType::class,
//                'entry_options' => array(
//                    'class' => 'StolarzBundle:Edge',
//                    'choice_label' => 'nameThickness'
//                ),
//                'allow_add' => true,
//                'prototype' => true
//            ))
			->add( 'edge', EntityType::class, array(
				'class' => 'StolarzBundle:Edge',
				'label' => 'Obrzeże: ',
				'choice_label' => 'nameThickness'
			) )
			->add( 'lenght', 'number', array( 'label' => 'Długość: ' ) )
			->add( 'lenghtEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 1: ' ) )
			->add( 'lenghtEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po długości 2: ' ) )
			->add( 'width', 'number', array( 'label' => 'Szerokość: ' ) )
			->add( 'widthEdge1', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 1: ' ) )
			->add( 'widthEdge2', 'checkbox', array( 'required' => false, 'label' => 'Okleina po szerokości 2: ' ) )
			->add( 'quantity', 'number', array( 'label' => 'Ilość: ' ) )
			->add( 'rotatable', 'checkbox', array( 'required' => false, 'label' => 'Obrotowo?: ' ) )
			->add( 'Dodaj', 'submit' )
			->getForm();
//		var_dump( $form );
		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$element = $form->getData();
			var_dump( $element );
			$em = $this->getDoctrine()->getManager();
			$em->persist( $element );
//            $em->flush();

			$session = $request->getSession();
			$session->set( 'confirmation', "Zamówienie zapisano poprawnie." );

			return $this->redirectToRoute( 'elementMain' );
		}

		$session = $request->getSession();
		$order = $session->get( 'customer', null );

		return $this->render( 'StolarzBundle::elementCreate.html.twig', array(
			'form' => $form->createView(),
			'order' => $order ) );
	}
}
