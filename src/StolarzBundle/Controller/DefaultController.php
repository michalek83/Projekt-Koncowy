<?php

namespace StolarzBundle\Controller;

use StolarzBundle\Entity\Customer;
use StolarzBundle\Entity\Edge;
use StolarzBundle\Entity\Material;
use StolarzBundle\Entity\Element;
use StolarzBundle\Entity\Order;
use StolarzBundle\Form\ElementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class DefaultController extends Controller
{
	/**
	 * @Route("/", name="main")
	 */
	public function mainAction( Request $request )
	{
		$orderRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Order' );
		$allOrders = $orderRepository->findAll();

        $session = $request->getSession();
        $confirmation = $session->get('confirmation', null);
        $session->set('confirmation', null);
        $exist = $session->get('exist', null);
        $session->set('exist', null);
        $deleted = $session->get('deleted', null);
        $session->set('deleted', null);

		return $this->render( 'StolarzBundle::main.html.twig',
			array(
                'confirmation' => $confirmation,
				'allOrders' => $allOrders,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}
}
