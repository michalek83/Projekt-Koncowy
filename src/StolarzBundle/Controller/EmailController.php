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
     * @Route("/send/{orderId}", name="emailSend", requirements={"orderId": "\d+"})
     */
    public function emailSendAction($orderId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $order = $em->getRepository( 'StolarzBundle:Order' )->find( $orderId );
        $customerId = $order->getCustomer()->getId();
        $customer = $em->getRepository( 'StolarzBundle:Customer' )->find( $customerId );

        $emailSubject = 'Zamówienie nr '. $orderId . '- Klient ' . $customer->getName() . '.';
        $emailSender = array('michalek_18@wp.pl' => 'Michał');
        $emailRecipient = 'michalgorniak@o2.pl';
        $emailContent;

        $message = (new \Swift_Message())
            ->setSubject($emailSubject)
            ->setFrom($emailSender)
            ->setTo($emailRecipient)
            ->setBody('Tresc przykladowego maila')
        ;

        $this->get('mailer')->send($message);

        $session = $request->getSession();
        $session->set('emailConfirmation', 'Wysłano');

        return $this->redirectToRoute( 'main' );
    }

}