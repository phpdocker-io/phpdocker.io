<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * MySQLOptions entity and validation
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class MySQLOptions extends \AuronConsultingOSS\Docker\Entity\MySQLOptions
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $rootPassword = 'root-password';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $databaseName = 'database-name';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $username = 'username';

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $password = 'password';
}
