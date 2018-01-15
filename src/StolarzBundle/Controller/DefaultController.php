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


class DefaultController extends Controller
{
	/**
	 * @Route("/", name="main")
	 */
	public function mainAction()
	{
		$orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
		$allOrders = $orderRepository->findAll();
//
//        $session = $request->getSession();
//        $confirmation = $session->get('confirmation', null);
//        $session->set('confirmation', null);
//        $exist = $session->get('exist', null);
//        $session->set('exist', null);
//        $deleted = $session->get('deleted', null);
//        $session->set('deleted', null);

		return $this->render( 'StolarzBundle::main.html.twig',
			array(
//                'confirmation' => $confirmation,
				'allOrders' => $allOrders,
//                'exist' => $exist,
//                'deleted' => $deleted
			) );
	}

	/**
	 * @Route("/createOrder", name="createOrder")
	 */
	public function createOrderAction( Request $request )
	{
		$order = new Order();
		$form = $this->createFormBuilder( $order )
			->add( 'customer', 'entity', array(
				'class' => 'StolarzBundle:Customer',
				'label' => 'Klient: ',
				'choice_label' => 'name'
			) )
			->add( 'Wybierz', 'submit' )
			->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$customer = $form->getData();
			$session = $request->getSession();
			$session->set( 'customer', $customer );

			return $this->redirectToRoute( 'elementMain' );
		}

		return $this->render( 'StolarzBundle::createOrder.html.twig', array( 'form' => $form->createView() ) );
	}

	/**
	 * @Route("/element", name="elementMain")
	 */
	public function elementMainAction( Request $request )
	{
		$elementRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Element' );
		$allElements = $elementRepository->findAll();

		$session = $request->getSession();
		$order = $session->get( 'customer', null );
//        $session->set('confirmation', null);
//        $exist = $session->get('exist', null);
//        $session->set('exist', null);
//        $deleted = $session->get('deleted', null);
//        $session->set('deleted', null);

		return $this->render( 'StolarzBundle::elementMain.html.twig',
			array(
//                'confirmation' => $confirmation,
				'allElements' => $allElements,
				'order' => $order
//                'exist' => $exist,
//                'deleted' => $deleted
			) );
	}

	/**
	 * @Route("/element/create1", name="createElement1")
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

		return $this->render( 'StolarzBundle::createElement1.html.twig', array(
			'form' => $form->createView(),
			'order' => $order ) );
	}

	/**
	 * @Route("/element/create", name="createElement")
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

		return $this->render( 'StolarzBundle::createElement.html.twig', array(
			'form' => $form->createView(),
			'order' => $order ) );
	}

//	/**
//	 * @Route("/customer", name="customerMain")
//	 */
//	public function customerMainAction( Request $request )
//	{
//		$customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
//		$allCustomers = $customerRepository->findBy( [], [ 'name' => 'ASC' ] );
//		$session = $request->getSession();
//		$confirmation = $session->get( 'confirmation', null );
//		$session->set( 'confirmation', null );
//		$exist = $session->get( 'exist', null );
//		$session->set( 'exist', null );
//		$deleted = $session->get( 'deleted', null );
//		$session->set( 'deleted', null );
//
//		return $this->render( 'StolarzBundle::customerMain.html.twig',
//			array( 'confirmation' => $confirmation,
//				'allCustomers' => $allCustomers,
//				'exist' => $exist,
//				'deleted' => $deleted ) );
//	}
//
//	/**
//	 * @Route("/customers/create", name="createCustomer")
//	 */
//	public function createCustomerAction( Request $request )
//	{
//		$customer = new Customer();
//		$form = $this->createFormBuilder( $customer )
//			->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
//			->add( 'address', 'text', array( 'required' => true, 'label' => 'Adres: ' ) )
//			->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
//			->add( 'save', 'submit', array( 'label' => 'Stwórz klienta' ) )
//			->getForm();
//
//		$form->handleRequest( $request );
//
//		if ( $form->isSubmitted() ) {
//			$customer = $form->getData();
//			$em = $this->getDoctrine()->getManager();
//			$em->persist( $customer );
//			$em->flush();
//
//			$session = $request->getSession();
//			$confirmation = "Klient " . $customer->getName() . " został zapisany poprawnie.";
//			$session->set( 'confirmation', "$confirmation" );
//
//			return $this->redirectToRoute( 'customerMain' );
//		}
//
//		return $this->render( 'StolarzBundle::customerCreate.html.twig', array( 'form' => $form->createView() ) );
//	}
//
//	/**
//	 * @Route("/customer/delete/{id}", name="deleteCustomer", requirements={"id": "\d+"})
//	 */
//	public function deleteCustomerAction( $id, Request $request )
//	{
//		$em = $this->getDoctrine()->getManager();
//		$customer = $em->getRepository( 'StolarzBundle:Customer' )->find( $id );
//
//		$session = $request->getSession();
//
//		if ( !$customer ) {
//			$session->set( 'exist', $id );
//
//			return $this->redirectToRoute( 'customerMain' );
//		}
//
//		$em->remove( $customer );
//		$em->flush();
//
//		$session->set( 'deleted', $customer );
//
//		return $this->redirectToRoute( 'customerMain' );
//	}
}
