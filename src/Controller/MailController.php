<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use App\Service\MessageSender;

class MailController
{
    /**
     * @var MailerInterface SMTP service 
     */
    private MailerInterface $mailer;

    /*
    * @var MessageSender It's the AMQP service
    */
    private MessageSender $messageSender;

    public function __construct(MailerInterface $mailer, MessageSender $messageSender)
    {
        $this->mailer = $mailer;
        $this->messageSender = $messageSender;
    }

    /**
     * Sends a sad test email. Use this method to test your mail configuration.
     * @Route("/sendmail", name="sendmail")
     * @return Response
     */
    public function testSendEmail()
    {
        $this->sendEmail(
            [
                'from' =>  'hello@example.com',
                'to' => 'you@example.com',
                'subject' => 'Time for Symfony Mailer!',
                'text' =>  'Sending emails is fun again!',
                'html' => '<p>See Twig integration for better HTML integration!</p>'
            ]
        );
        return new Response('Email sent');
    }

    /**
     * The most important method here... sends an email
     * @param array $emailData [from, to, subject, body, html]
     */
    public function sendEmail(array $emailData)
    {
        $emailOK = true;
        $email = (new Email())
            ->from($emailData['from'])
            ->to($emailData['to'])
            ->subject($emailData['subject'] . '_ ' . $emailData['messageUUID'])
            ->text($emailData['text'])
            ->html($emailData['html']);
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $emailOK = false;
        }
        $this->reportEmailResponse($emailOK, $emailData['messageUUID']);
    }

    /**
     * Reports back to the queue.
     *
     * @param bool $response True if email was successfully delivered to SMTP server
     * @return void
     */
    private function reportEmailResponse(bool $emailOK, string $messageUUID)
    {
        $data = ['messageUUID' => $messageUUID, 'emailOK' => $emailOK];
        $this->messageSender->createMessage($data);
    }
}
