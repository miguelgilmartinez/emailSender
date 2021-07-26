<?php

namespace App\MessageBus;
use App\Messages\MyMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
class SendMessage
{

    public function __invoke(MyMessage $message, MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        $mailer->send($email);
    }
}
