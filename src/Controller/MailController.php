<?php

namespace App\Controller;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class MailController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
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
        $email = (new Email())
            ->from($emailData['from'])
            ->to($emailData['to'])
            ->subject("OOOOOOOOO" . $emailData['subject'])
            ->text($emailData['text'])
            ->html($emailData['html']);
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        $this->mailer->send($email);
    }
}
