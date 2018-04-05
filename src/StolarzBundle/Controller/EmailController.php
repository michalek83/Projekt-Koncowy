<?php

namespace StolarzBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


/**
 * @Route("/email")
 */
class EmailController extends Controller
{
    /**
     * @Route("/", name="emailSend")
     */
    public function emailSendAction(Request $request)
    {


        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('michalek_18@wp.pl')
            ->setTo('michalgorniak@o2.pl')
            ->setBody('Tresc przykladowego maila')
        ;

        $this->get('mailer')->send($message);

        $session = $request->getSession();
        $session->set('emailConfirmation', 'Wysłano');

        return $this->redirectToRoute( 'main' );
    }

}