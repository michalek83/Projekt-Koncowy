<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Edge;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/edge")
 */
class EdgeController extends Controller
{
	/**
	 * @Route("/", name="edgeMain")
	 */
	public function edgeMainAction( Request $request )
	{
		$edgeRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Edge' );
		$allEdges = $edgeRepository->findBy( [], [ 'name' => 'ASC', 'thickness' => 'DESC' ] );
		$session = $request->getSession();
		$confirmation = $session->get( 'confirmation', null );
		$session->set( 'confirmation', null );
		$exist = $session->get( 'exist', null );
		$session->set( 'exist', null );
		$deleted = $session->get( 'deleted', null );
		$session->set( 'deleted', null );

		return $this->render( 'StolarzBundle::edgeMain.html.twig',
			array( 'confirmation' => $confirmation,
				'allEdges' => $allEdges,
				'exist' => $exist,
				'deleted' => $deleted ) );
	}

	/**
	 * @Route("/create", name="createEdge")
	 */
	public function createEdgeAction( Request $request )
	{
		$edge = new Edge();
		$form = $this->createFormBuilder( $edge )
			->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
			->add( 'thickness', 'number', array( 'required' => true, 'label' => 'Grubość: ', 'scale' => 2 ) )
			->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
			->add( 'save', 'submit', array( 'label' => 'Stwórz materiał' ) )
			->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$edge = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist( $edge );
			$em->flush();

			$session = $request->getSession();
			$confirmation = "Obrzeże " . $edge->getName() . " zapisano poprawnie.";
			$session->set( 'confirmation', "$confirmation" );

			return $this->redirectToRoute( 'edgeMain' );
		}

		return $this->render( 'StolarzBundle::createEdge.html.twig', array( 'form' => $form->createView() ) );
	}

	/**
	 * @Route("/delete/{id}", name="deleteEdge", requirements={"id": "\d+"})
	 */
	public function deleteEdgeAction( $id, Request $request )
	{
		$em = $this->getDoctrine()->getManager();
		$edge = $em->getRepository( 'StolarzBundle:Edge' )->find( $id );

		$session = $request->getSession();

		if ( !$edge ) {
			$session->set( 'exist', $id );

			return $this->redirectToRoute( 'edgeMain' );
		}

		$em->remove( $edge );
		$em->flush();

		$session->set( 'deleted', $edge );

		return $this->redirectToRoute( 'edgeMain' );
	}
}
