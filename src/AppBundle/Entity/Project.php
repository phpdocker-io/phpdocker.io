<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Project entity and validation.
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class Project extends \AuronConsultingOSS\Docker\Entity\Project
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min=1, max=128)
     */
    protected $name = 'your-project';

    /**
     * @var int
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="integer")
     * @Assert\Range(min="1025", max="65500")
     */
    protected $basePort = '8000';

    /**
     * @var MySQLOptions
     *
     * @Assert\Valid()
     */
    protected $mysqlOptions;

    /**
     * @var PhpOptions
     *
     * @Assert\Valid()
     */
    protected $phpOptions;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasMemcached = false;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasRedis = false;

    /**
     * @var bool
     *
     * @Assert\Type(type="bool")
     */
    protected $hasMailcatcher = false;

    public function __construct()
    {
        parent::__construct();
        $this->mysqlOptions = new MySQLOptions();
        $this->phpOptions   = new PhpOptions();
    }
}
