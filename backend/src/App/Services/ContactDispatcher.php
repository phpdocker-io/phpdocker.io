<?php

namespace App\Services;

use PHPDocker\Contact\DispatcherInterface;
use PHPDocker\Contact\Message;

class ContactDispatcher implements DispatcherInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var string
     */
    private $emailFrom;

    /**
     * @var string
     */
    private $emailTo;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, string $emailFrom, string $emailTo)
    {
        $this->mailer    = $mailer;
        $this->twig      = $twig;
        $this->emailFrom = $emailFrom;
        $this->emailTo   = $emailTo;
    }

    /**
     * Sends a message.
     *
     * @param Message $message
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function send(Message $message): void
    {
        $messageBody = $this->twig->render('AppBundle:emails:contact-email.html.twig', [
            'senderEmail' => $message->getEmail(),
            'message'     => $message->getMessage(),
        ]);

        $swiftMessage = new \Swift_Message();
        $swiftMessage
            ->setSubject('PHPDocker.io - Contact request')
            ->setFrom($this->emailFrom)
            ->setReplyTo($message->getEmail())
            ->setTo($this->emailTo)
            ->setBody($messageBody, 'text/html');

        $this->mailer->send($swiftMessage);
    }
}
