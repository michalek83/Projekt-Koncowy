<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/customer")
 */
class CustomerController extends Controller
{
	/**
	 * @Route("/", name="customerMain")
	 */
	public function customerMainAction( Request $request )
	{
		$customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
		$allCustomers = $customerRepository->findBy( [], [ 'name' => 'ASC' ] );
		$session = $request->getSession();
		$confirmation = $session->get( 'confirmation', null );
		$session->set( 'confirmation', null );
		$exist = $session->get( 'exist', null );
		$session->set( 'exist', null );
		$deleted = $session->get( 'deleted', null );
		$session->set( 'deleted', null );

		return $this->render( 'StolarzBundle::customerMain.html.twig',
			array( 'confirmation' => $confirmation,
				'allCustomers' => $allCustomers,
				'exist' => $exist,
				'deleted' => $deleted ) );
	}

	/**
	 * @Route("/create", name="createCustomer")
	 */
	public function createCustomerAction( Request $request )
	{
		$customer = new Customer();
		$form = $this->createFormBuilder( $customer )
			->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
			->add( 'address', 'text', array( 'required' => true, 'label' => 'Adres: ' ) )
			->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
			->add( 'save', 'submit', array( 'label' => 'Stwórz klienta' ) )
			->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$customer = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist( $customer );
			$em->flush();

			$session = $request->getSession();
			$confirmation = "Klient " . $customer->getName() . " został zapisany poprawnie.";
			$session->set( 'confirmation', "$confirmation" );

			return $this->redirectToRoute( 'customerMain' );
		}

		return $this->render( 'StolarzBundle::customerCreate.html.twig', array( 'form' => $form->createView() ) );
	}

	/**
	 * @Route("/delete/{id}", name="deleteCustomer", requirements={"id": "\d+"})
	 */
	public function deleteCustomerAction( $id, Request $request )
	{
		$em = $this->getDoctrine()->getManager();
		$customer = $em->getRepository( 'StolarzBundle:Customer' )->find( $id );

		$session = $request->getSession();

		if ( !$customer ) {
			$session->set( 'exist', $id );

			return $this->redirectToRoute( 'customerMain' );
		}

		$em->remove( $customer );
		$em->flush();

		$session->set( 'deleted', $customer );

		return $this->redirectToRoute( 'customerMain' );
	}
}
