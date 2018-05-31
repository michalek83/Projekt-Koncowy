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

        return $this->render( 'StolarzBundle::Order/orderMain.html.twig',
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

		if  ($form->isSubmitted() && ($form->isValid())) {
			$session = $request->getSession();
			$customer = $order->getCustomer();
			$orderName = $order->getOrderName();
			$session->set('customer', $customer);
			$session->set('orderName', $orderName);
            $em = $this->getDoctrine()->getManager();
            $em->persist( $order );

            $em->flush();

			return $this->redirectToRoute( 'elementMain' );
		}

		return $this->render( 'StolarzBundle::Order/orderCreate.html.twig', array( 'form' => $form->createView() ) );
	}

    /**
     * @Route("/orderShowByCustomerId/{customerId}", name="orderShowByCustomerId", requirements={"customerId": "\d+"})
     */
    public function showOrdersByCustomerIdAction( $customerId, Request $request )
    {
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $allOrdersByCustomerId = $orderRepository->findBy(['customer' => $customerId]);

        $customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
        $customer = $customerRepository->findOneBy(['id' => $customerId]);

        $session = $request->getSession();
        $session->set('customer', $customer);

        return $this->render( 'StolarzBundle::Order/orderShowByCustomerId.html.twig',
            array(
                'allOrdersByCustomerId' => $allOrdersByCustomerId,
                'customer' => $customer
            ) );
    }

    /**
     * @Route("/orderShowByOrderId/{orderId}", name="orderShowByOrderId", requirements={"orderId": "\d+"})
     */
    public function showOrderByOrderIdAction( $orderId, Request $request )
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

        $session = $request->getSession();
        $deleted = $session->get('deleted');
        $emailConfirmation = $session->get('emailConfirmation');    // Potwierdzenie wysłania maila
        $session->set('emailConfirmation', null);
        $emailCustomerName = $session->get('emailCustomerName');    // Nazwa klienta z potwierdzenia wysłąnia maila
        $session->set('emailCustomerName', null);
        $emailOrderId = $session->get('emailOrderId');    // Nazwa klienta z potwierdzenia wysłąnia maila
        $session->set('emailOrderId', null);
        $session->set('deleted', null);
        $session->set('previousPage', 'orderShowByOrderId');

        foreach($allEdges as $edge){
            $allEdgesRebuilded[$edge->getId()] = $edge;
        }

        return $this->render( 'StolarzBundle::Order/orderShowByOrderId.html.twig',
            array(
                'orderById' => $orderById,
                'customer' => $customer,
                'orderElements' => $orderElements,
                'allEdges' => $allEdgesRebuilded,
                'emailCustomerName' => $emailCustomerName,
                'emailOrderId' => $emailOrderId,
                'emailConfirmation' => $emailConfirmation,
                'deleted' => $deleted
            ) );
    }

    /**
     * @Route("/delete/{orderId}", name="deleteOrder", requirements={"orderId": "\d+"})
     */
    public function deleteOrderAction( $orderId, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository( 'StolarzBundle:Order' )->find( $orderId );

        $session = $request->getSession();
        $customerId = $order->getCustomer()->getId();

        if ( !$order ) {
            $session->set( 'exist', $orderId );

            return $this->redirectToRoute( 'orderMain' );
        }

        $em->remove( $order );
        $em->flush();

        $session->set( 'deleted', $order );

        return $this->redirectToRoute( 'orderShowByCustomerId', ['customerId' => $customerId] );
    }
}
