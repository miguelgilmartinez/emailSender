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
        echo 'New user: ' . ($msg->body) . "\n";
        $message = json_decode($msg->body, true);
        $emailData = [
            'from' => 'welcome@goanddo.org',
            'to' => $message['email'],
            'subject' => "{$message['username']} Welcome to a better and heathier life",
            'body' => "Blah blah blah",
            'html' => "<body>Blah in HTML</body>"
        ];


        $this->mailer->sendEmail($emailData);
    }

    /**
     * @required
     */
    public function setMailer(MailController $mailer)
    {
        $this->mailer = $mailer;
    }
}
