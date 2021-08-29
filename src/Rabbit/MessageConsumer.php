<?php

namespace App\Rabbit;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;
use App\Controller\MailController;

/**
 * Consume messages from RabbitMQ and send emails.
 */
class MessageConsumer implements ConsumerInterface
{

    public $mailController;

    /**
     * Consume a message from queue.
     * @param AMQPMessage $msg
     * @return void
     */
    public function execute(AMQPMessage $msg)
    {
        $message = json_decode($msg->body, true);
        $this->mailController->sendEmail($message);
    }

    /**
     * @required
     * Inject the MailController
     */
    public function setMailer(MailController $mailer)
    {
        $this->mailController = $mailer;
    }
}
