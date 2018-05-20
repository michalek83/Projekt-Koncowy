<?php

namespace StolarzBundle\Controller;

use Proxies\__CG__\StolarzBundle\Entity\Material;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use StolarzBundle\Helper\CsvFile;


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
        $allElements = $em->getRepository('StolarzBundle:Element')->findBy(['order' => $orderId]);
        $allEdges = $em->getRepository('StolarzBundle:Edge')->findAll();
        $allMaterials = $em->getRepository('StolarzBundle:Material')->findAll();

        //email sending
        $emailSubject = 'Zamówienie nr '. $orderId . ' - Klient ' . $customer->getName() . '.';
        $emailSender = array('michalek_18@wp.pl' => 'Michał');
        $emailRecipient = $customer->getEmailAddress();

        //CSV data creation from order data
        $csvFile = new CsvFile($order, $allElements);
        $csvFile->createNewFile();

        $attachmentPath = $csvFile->getPathWithNameAndOrderNo();

        $message = (new \Swift_Message())
            ->setSubject($emailSubject)
            ->setFrom($emailSender)
            ->setTo($emailRecipient)
            ->setBody(
                $this->renderView(
                    'StolarzBundle::Emails/order.html.twig', array('customerName' => $customerName)
                ),
                'text/html'
            )
            ->attach(\Swift_Attachment::fromPath($attachmentPath)) //wzor - do zmiany
        ;

        $this->get('mailer')->send($message);

        $session = $request->getSession();
        $session->set('emailConfirmation', 'Wysłano');
        $session->set('emailCustomerName', $customerName);
        $session->set('emailOrderId', $orderId);

        return $this->redirectToRoute( 'main' );
    }

}