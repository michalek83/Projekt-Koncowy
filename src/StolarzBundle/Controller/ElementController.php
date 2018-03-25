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
		$elementRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Element' );
		$allElements = $elementRepository->findAll();

        $edgeRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Edge' );
        $allEdges = $edgeRepository->findAll();

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
				'allEdges' => $allEdges,
				'order' => $order,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}

	/**
	 * @Route("/create", name="createElement")
	 */
	public function createElementAction( Request $request )
	{
		$element = new Element();
		$form = $this->createForm( ElementType::class, $element );

		$form->handleRequest( $request );

		if ( $form->isSubmitted() && $form->isValid() ) {
			$element = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist( $element );
//            $em->flush();

			$session = $request->getSession();
			$session->set( 'confirmation', "Zamówienie zapisano poprawnie." );

			return $this->redirectToRoute( 'elementMain' );
		}

		$session = $request->getSession();
		$order = $session->get( 'customer' );

		return $this->render( 'StolarzBundle::elementCreate.html.twig', array(
			'form' => $form->createView(),
			'order' => $order,
            'element' => $element) );
	}
}
