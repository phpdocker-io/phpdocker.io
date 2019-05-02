<?php
declare(strict_types=1);

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
     * @param MessageInterface $message
     *
     */
    public function send(MessageInterface $message): void;
}
