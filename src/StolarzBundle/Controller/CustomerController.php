<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Customer;
use StolarzBundle\Form\CustomerType;
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

        foreach($allCustomers as $customer){
            $allCustomersRebuilded[$customer->getId()] = $customer;
        }

		$session = $request->getSession();
		$confirmation = $session->get( 'confirmation' );        // Potwierdzenie stworzenia klienta
		$session->set( 'confirmation' , null );
		$exist = $session->get( 'exist' );                      // Klient istnieje
		$session->set( 'exist', null );
		$deleted = $session->get( 'deleted' );                  // Klienta skasowano
		$session->set( 'deleted', null );

		return $this->render( 'StolarzBundle::customerMain.html.twig',
			array(
			    'confirmation' => $confirmation,
				'allCustomers' => $allCustomersRebuilded,
				'exist' => $exist,
				'deleted' => $deleted ) );
	}

	/**
	 * @Route("/create", name="createCustomer")
	 */
	public function createCustomerAction( Request $request )
	{
		$customer = new Customer();
		$form = $this->createForm( CustomerType::class, $customer );

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
