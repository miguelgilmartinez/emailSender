<?php

namespace App\MessageBus;
use App\Controller\MailerController;
use App\Messages\MyMessage;

class SendMessage
{
    public function __invoke(MyMessage $message)
    {
        $mail = new MailerController();
        $mail->sendEmail();
    }
}
