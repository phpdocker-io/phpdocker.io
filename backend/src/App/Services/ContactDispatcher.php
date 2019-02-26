<?php

namespace App\Services;

use PHPDocker\Contact\DispatcherInterface;
use PHPDocker\Contact\Message;

class ContactDispatcher implements DispatcherInterface
{
    public function __construct()
    {
    }

    /**
     * Sends a message.
     *
     * @param Message $message
     */
    public function send(Message $message): void
    {
        // TODO: Implement send() method.
    }
}
