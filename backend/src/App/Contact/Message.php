<?php

namespace PHPDocker\Contact;

/**
 * Contact message
 *
 * @package PHPDocker\Contact
 */
class Message
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Message
     */
    public function setEmail(string $email): Message
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Message
     */
    public function setMessage(string $message): Message
    {
        $this->message = $message;

        return $this;
    }
}
