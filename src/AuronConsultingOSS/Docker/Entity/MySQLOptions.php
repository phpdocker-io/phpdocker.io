<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Options for MySQL container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class MySQLOptions extends AbstractServiceOptions
{
    /**
     * @var string
     */
    protected $rootPassword;

    /**
     * @var string
     */
    protected $databaseName;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @inheritdoc
     */
    public function getHostnameSuffix() : string
    {
        return 'mysql';
    }

    /**
     * @return string
     */
    public function getRootPassword()
    {
        return $this->rootPassword;
    }

    /**
     * @param string $rootPassword
     *
     * @return MySQLOptions
     */
    public function setRootPassword(string $rootPassword = null) : MySQLOptions
    {
        $this->rootPassword = $rootPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * @param string $databaseName
     *
     * @return MySQLOptions
     */
    public function setDatabaseName(string $databaseName = null) : MySQLOptions
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return MySQLOptions
     */
    public function setUsername(string $username = null) : MySQLOptions
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return MySQLOptions
     */
    public function setPassword(string $password = null) : MySQLOptions
    {
        $this->password = $password;

        return $this;
    }
}
