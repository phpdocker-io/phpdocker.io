<?php
namespace AppBundle\Entity\Generator;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * PostgresOptions entity and validation
 *
 * @package   AppBundle\Entity\ORM
 * @copyright Auron Consulting Ltd
 */
class PostgresOptions extends \AuronConsultingOSS\Docker\Project\ServiceOptions\Postgres
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $version = self::VERSION_95;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootUser;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootPassword;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"postgresOptions"})
     * @Assert\NotNull(groups={"postgresOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $databaseName;

    /**
     * Redirect hasPostgres to enabled.
     *
     * @param bool $hasPostgres
     *
     * @return PostgresOptions
     */
    public function setHasPostgres(bool $hasPostgres = false) : self
    {
        return $this->setEnabled($hasPostgres);
    }

    /**
     * @return bool
     */
    public function hasPostgres() : bool
    {
        return $this->isEnabled();
    }
}
