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
        $customerName = $customer->getName();

        $emailSubject = 'Zamówienie nr '. $orderId . ' - Klient ' . $customer->getName() . '.';
        $emailSender = array('michalek_18@wp.pl' => 'Michał');
        $emailRecipient = $customer->getEmailAddress();
        $emailContent = $this->renderView('StolarzBundle::Email/order.html.twig',
            array(
                'customerName' => $customerName
            ));

        var_dump($emailContent);die;

        $message = (new \Swift_Message())
            ->setSubject($emailSubject)
            ->setFrom($emailSender)
            ->setTo($emailRecipient)
            ->setBody($emailContent)
        ;
//        var_dump($message);die;
        $this->get('mailer')->send($message);

        $session = $request->getSession();
        $session->set('emailConfirmation', 'Wysłano');
        $session->set('emailCustomerName', $customerName);
        $session->set('emailOrderId', $orderId);

        return $this->redirectToRoute( 'main' );
    }

}