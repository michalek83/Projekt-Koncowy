<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Order;
use StolarzBundle\Form\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/order")
 */
class OrderController extends Controller
{
	/**
	 * @Route("/create", name="createOrder")
	 */
	public function createOrderAction( Request $request )
	{
		$order = new Order();
		$form = $this->createForm( OrderType::class, $order );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$customer = $form->getData();
			$session = $request->getSession();
			$session->set( 'customer', $customer );

			return $this->redirectToRoute( 'elementMain' );
		}

		return $this->render( 'StolarzBundle::orderCreate.html.twig', array( 'form' => $form->createView() ) );
	}
}
