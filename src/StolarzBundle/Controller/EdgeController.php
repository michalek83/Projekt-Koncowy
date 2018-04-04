<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Edge;
use StolarzBundle\Form\EdgeType;
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
		$confirmation = $session->get( 'confirmation');                 // Potwierdzenie stworzenia obrzeża
		$session->set( 'confirmation', null );
		$exist = $session->get( 'exist');                               // Obrzeże istnieje
		$session->set( 'exist', null );
		$deleted = $session->get( 'deleted');                           // Obrzeże skasowano
		$session->set( 'deleted', null );

		return $this->render( 'StolarzBundle::Edge/edgeMain.html.twig',
			array(
			    'confirmation' => $confirmation,
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
		$form = $this->createForm( EdgeType::class, $edge );

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

		return $this->render( 'StolarzBundle::Edge/edgeCreate.html.twig', array( 'form' => $form->createView() ) );
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
