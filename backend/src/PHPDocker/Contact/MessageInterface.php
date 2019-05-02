<?php
declare(strict_types=1);

namespace PHPDocker\Contact;

/**
 * Defines the accessors for a contact email message we can use to dispatch it.
 *
 * @package PHPDocker\Contact
 */
interface MessageInterface
{
    /**
     * Should return the email address to send the message to.
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Should return the actual message being sent.
     *
     * @return string
     */
    public function getMessage(): string;
}
