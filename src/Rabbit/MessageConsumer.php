<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use App\Controller\MailController;

class MessageConsumer implements ConsumerInterface
{

   public $mailer;

    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->body, true);
        echo 'Received a message: ' . json_encode($message) . "\n";
        $this->sendEmailNow($message);
    }

    public function sendEmailNow(array $message)
    {
        $mailer = new MailController();

        $mailer->sendEmail($message);
    }
}
