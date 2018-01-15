<?php

namespace StolarzBundle\Controller;

//use StolarzBundle\Entity\Customer;
//use StolarzBundle\Entity\Edge;
use StolarzBundle\Entity\Material;
//use StolarzBundle\Entity\Element;
//use StolarzBundle\Entity\Order;
//use StolarzBundle\Form\ElementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
//use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
//use Symfony\Component\Form\Extension\Core\Type\CollectionType;
//use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * @Route("/material")
 */
class MaterialController extends Controller
{
    /**
     * @Route("/", name="materialMain")
     */
    public function mainMaterialAction( Request $request )
	{
		$materialRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Material' );
		$allMaterials = $materialRepository->findBy( [], [ 'name' => 'ASC' ] );

		$session = $request->getSession();
		$confirmation = $session->get( 'confirmation', null );
		$session->set( 'confirmation', null );
		$exist = $session->get( 'exist', null );
		$session->set( 'exist', null );
		$deleted = $session->get( 'deleted', null );
		$session->set( 'deleted', null );

		return $this->render( 'StolarzBundle::materialMain.html.twig',
			array( 'confirmation' => $confirmation,
				'allMaterials' => $allMaterials,
				'exist' => $exist,
				'deleted' => $deleted ) );
	}

    /**
     * @Route("/create", name="createMaterial")
     */
    public function createMaterialAction( Request $request )
	{
		$material = new Material();
		$form = $this->createFormBuilder( $material )
			->add( 'name', 'text', array( 'required' => true, 'label' => 'Nazwa: ' ) )
			->add( 'description', 'text', array( 'label' => 'Uwagi: ', 'required' => false ) )
			->add( 'save', 'submit', array( 'label' => 'Stwórz materiał' ) )
			->getForm();

		$form->handleRequest( $request );

		if ( $form->isSubmitted() ) {
			$material = $form->getData();
			$em = $this->getDoctrine()->getManager();
			$em->persist( $material );
			$em->flush();

			$session = $request->getSession();
			$confirmation = "Materiał " . $material->getName() . " zapisano poprawnie.";
			$session->set( 'confirmation', "$confirmation" );

			return $this->redirectToRoute( 'materialMain' );
		}

		return $this->render( 'StolarzBundle::createMaterial.html.twig', array( 'form' => $form->createView() ) );
	}

    /**
     * @Route("/delete/{id}", name="deleteMaterial", requirements={"id": "\d+"})

     */
    public function deleteMaterialAction( $id, Request $request )
    {
        $em = $this->getDoctrine()->getManager();
		$material = $em->getRepository( 'StolarzBundle:Material' )->find( $id );

		$session = $request->getSession();

		if ( !$material ) {
			$session->set( 'exist', $id );

			return $this->redirectToRoute( 'materialMain' );
		}

		$em->remove( $material );
		$em->flush();

		$session->set( 'deleted', $material );

		return $this->redirectToRoute( 'materialMain' );
    }

}
