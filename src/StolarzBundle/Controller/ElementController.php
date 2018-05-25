<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Element;
use StolarzBundle\Form\ElementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
        $session = $request->getSession();
        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order');
        $order = $orderRepository->findBy([], ['orderDateTime' => 'DESC'])[0];
        $session->set('orderId', $order->getId());

		$elementRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Element' );
		$orderElements = $elementRepository->findBy(['order' => $order->getId()]);

        $edgeRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Edge' );
        $allEdges = $edgeRepository->findAll();

        foreach($allEdges as $edge){
            $allEdgesRebuilded[$edge->getId()] = $edge;
        }

		$customer = $session->get('customer');
		$confirmation = $session->get('confirmation');
        $session->set('confirmation', null);
        $exist = $session->get('exist');
        $session->set('exist', null);
        $deleted = $session->get('deleted');
        $session->set('deleted', null);

		return $this->render( 'StolarzBundle::Element/elementMain.html.twig',
			array(
			    'order' => $order,
				'orderElements' => $orderElements,
				'allEdges' => $allEdgesRebuilded,
				'customer' => $customer,
                'confirmation' => $confirmation,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}

	/**
	 * @Route("/create", name="createElement")
	 */
	public function createElementAction( Request $request )
	{
	    $session = $request->getSession();
	    $orderId = $session->get('orderId');

        $orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
        $order = $orderRepository->find(['id' => $orderId]);

		$element = new Element();
		$form = $this->createForm( ElementType::class, $element );
		$form->handleRequest( $request );

		$element->setOrder($order);

		if ( $form->isSubmitted() && $form->isValid() ) {
			$element = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist( $element );

            $em->flush();

			$session = $request->getSession();
			$session->set( 'confirmation', "Element zapisano poprawnie." );

            return $this->redirectToRoute( 'elementMain' );
		}

        $session = $request->getSession();
        $customer = $session->get('customer');

		return $this->render( 'StolarzBundle::Element/elementCreate.html.twig', array(
			'form' => $form->createView(),
			'customer' => $customer,
            'element' => $element) );
	}

    /**
     * @Route("/delete/{elementId}", name="deleteElement", requirements={"elementId": "\d+"})
     */
    public function deleteElementAction( $elementId, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $element = $em->getRepository( 'StolarzBundle:Element' )->find( $elementId );

        $em = $this->getDoctrine()->getManager();
        $orderId = $element->getOrder()->getId();

        $session = $request->getSession();

        if ( !$element ) {
            $session->set( 'exist', $elementId );

            return $this->redirectToRoute( 'elementMain' );
        }

        $em->remove( $element );
        $em->flush();

        $session->set( 'deleted', $element );

        return $this->redirectToRoute( 'orderShowByOrderId', ['orderId' => $orderId] );
    }
}
