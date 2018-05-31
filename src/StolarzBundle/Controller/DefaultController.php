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
        $customerRepository = $this->getDoctrine()->getRepository( 'StolarzBundle:Customer' );
        $allCustomers = $customerRepository->findAll();

        foreach($allCustomers as $customer){
            $allCustomersRebuilded[$customer->getId()] = $customer;
        }

        $session = $request->getSession();
        $confirmation = $session->get('confirmation');    // Potwierdzenie stworzenia zamówienia
        $session->set('confirmation', null);
        $emailConfirmation = $session->get('emailConfirmation');    // Potwierdzenie wysłania maila
        $session->set('emailConfirmation', null);
        $emailCustomerName = $session->get('emailCustomerName');    // Nazwa klienta z potwierdzenia wysłąnia maila
        $session->set('emailCustomerName', null);
        $emailOrderId = $session->get('emailOrderId');    // Nazwa klienta z potwierdzenia wysłąnia maila
        $session->set('emailOrderId', null);
        $exist = $session->get('exist');                  // Zamówenie istnieje
        $session->set('exist', null);
        $deleted = $session->get('deleted');              // Zamówienie skasowano
        $session->set('deleted', null);
        $session->set('previousPage', 'main');

		return $this->render( 'StolarzBundle::main.html.twig',
			array(
                'allOrders' => $allOrders,
                'allCustomers' => $allCustomersRebuilded,
                'confirmation' => $confirmation,
                'emailCustomerName' => $emailCustomerName,
                'emailOrderId' => $emailOrderId,
                'emailConfirmation' => $emailConfirmation,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}
}
