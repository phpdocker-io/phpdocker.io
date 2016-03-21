<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * MySQLOptions entity and validation
 *
 * @package   AppBundle\Entity
 * @copyright Auron Consulting Ltd
 */
class MySQLOptions extends \AuronConsultingOSS\Docker\Project\ServiceOptions\MySQL
{
    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $rootPassword;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $databaseName;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $username;

    /**
     * @var string
     *
     * @Assert\NotBlank(groups={"mysqlOptions"})
     * @Assert\NotNull(groups={"mysqlOptions"})
     * @Assert\Length(min=1, max=128)
     */
    protected $password;

    /**
     * Redirect hasMysql to enabled.
     *
     * @param bool $hasMysql
     *
     * @return MySQLOptions
     */
    public function setHasMysql(bool $hasMysql = false) : self
    {
        return $this->setEnabled($hasMysql);
    }

    /**
     * @return bool
     */
    public function hasMysql() : bool
    {
        return $this->isEnabled();
    }
}
