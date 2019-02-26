<?php

namespace PHPDocker\Contact;

/**
 * Defines a dispatcher for the contact message.
 *
 * @package PHPDocker\Contact
 */
interface DispatcherInterface
{
    /**
     * Sends a message.
     *
     * @param Message $message
     */
    public function send(Message $message): void;
}
