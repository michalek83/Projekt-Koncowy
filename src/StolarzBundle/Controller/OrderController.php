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
        // Ten route jest nieuzywany jak na razie
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $allOrders = $orderRepository->findAll();

        $session = $request->getSession();
        $confirmation = $session->get('confirmation', null);    // Potwierdzenie stworzenia zamówienia
        $session->set('confirmation', null);
        $exist = $session->get('exist', null);                  // Zamówenie istnieje
        $session->set('exist', null);
        $deleted = $session->get('deleted', null);              // Zamówienie skasowano
        $session->set('deleted', null);

        return $this->render( 'StolarzBundle::orderMain.html.twig',
            array(
                'allOrders' => $allOrders,
                'confirmation' => $confirmation,
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

    /**
     * @Route("/showOrdersByCustomer/{customerId}", name="showOrdersByCustomerId", requirements={"customerId": "\d+"})
     */
    public function showOrdersByCustomerIdAction( $customerId )
    {
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $allOrdersByCustomerId = $orderRepository->findBy(['customer' => $customerId]);

        $customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
        $customer = $customerRepository->findOneBy(['id' => $customerId]);

        return $this->render( 'StolarzBundle::showOrdersByCustomerId.html.twig',
            array(
                'allOrdersByCustomerId' => $allOrdersByCustomerId,
                'customer' => $customer
            ) );
    }

    /**
     * @Route("/orderShowByOrderId/{orderId}", name="orderShowByOrderId", requirements={"orderId": "\d+"})
     */
    public function showOrderByOrderIdAction( $orderId )
    {
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $orderById = $orderRepository->findOneBy( ['id' => $orderId]);
        $customerId = $orderById->getCustomer()->getId();
        $customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
        $customer = $customerRepository->findOneBy( ['id' => $customerId]);
        $elementRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Element' );
        $orderElements = $elementRepository->findBy(['order' => $orderId]);
        $edgeRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Edge' );
        $allEdges = $edgeRepository->findAll();

        return $this->render( 'StolarzBundle::orderShowByOrderId.html.twig',
            array(
                'orderById' => $orderById,
                'customer' => $customer,
                'orderElements' => $orderElements,
                'allEdges' => $allEdges
            ) );
    }
}
