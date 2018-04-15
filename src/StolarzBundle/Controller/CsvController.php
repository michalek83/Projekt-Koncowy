<?php

namespace StolarzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connections;

/**
 * @Route("/csv")
 */
class CsvController extends Controller
{
	/**
	 * @Route("/create", name="csvCreate")
	 */
	public function csvCreateAction( Request $request )
	{


		return $this->render( 'StolarzBundle::main.html.twig',
			array(
                'allOrders' => $allOrders,
                'allCustomers' => $allCustomersRebuilded,
                'confirmation' => $confirmation,
                'emailConfirmation' => $emailConfirmation,
                'exist' => $exist,
                'deleted' => $deleted
			) );
	}
}
