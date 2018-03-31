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
     * @Route("/", name="orderMain")
     */
    public function mainAction( Request $request )
    {
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $allOrdersByCustomerId = $orderRepository->findAll();

        $session = $request->getSession();
        $confirmation = $session->get('confirmation', null);    // Potwierdzenie stworzenia zamówienia
        $session->set('confirmation', null);
        $exist = $session->get('exist', null);                  // Zamówenie istnieje
        $session->set('exist', null);
        $deleted = $session->get('deleted', null);              // Zamówienie skasowano
        $session->set('deleted', null);

        return $this->render( 'StolarzBundle::orderMain.html.twig',
            array(
                'confirmation' => $confirmation,
                'allOrdersByCustomerId' => $allOrdersByCustomerId,
                'exist' => $exist,
                'deleted' => $deleted
            ) );
    }

	/**
	 * @Route("/create", name="createOrder")
	 */
	public function createOrderAction( Request $request )
	{
		$order = new Order();
		$form = $this->createForm( OrderType::class, $order );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$session = $request->getSession();
			$customer = $order->getCustomer();
			$session->set('customer', $customer);
            $em = $this->getDoctrine()->getManager();
            $em->persist( $order );

            $em->flush();

			return $this->redirectToRoute( 'elementMain' );
		}

		return $this->render( 'StolarzBundle::orderCreate.html.twig', array( 'form' => $form->createView() ) );
	}
}
