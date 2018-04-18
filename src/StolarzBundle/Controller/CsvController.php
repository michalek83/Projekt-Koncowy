<?php

namespace StolarzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connections;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/csv")
 */
class CsvController extends Controller
{
    private $filesystem;

    public function __construct(
        Filesystem $filesystem
    )
    {
        $this->filesystem = $filesystem;
    }

    /**
	 * @Route("/create", name="csvCreate")
	 */
	public function csvCreateAction( Request $request )
	{
	    die("Hello");

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

	public function createTemporaryFolder()
    {
	    return $this->filesystem->mkdir('/tmp/CSV/');
    }

    public function createCsvFile()
    {

    }
}
