<?php
namespace AuronConsultingOSS\Docker\Project\ServiceOptions;

/**
 * Options for MySQL container.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class MySQL extends Base
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
     * @return MySQL
     */
    public function setRootPassword(string $rootPassword = null) : MySQL
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
     * @return MySQL
     */
    public function setDatabaseName(string $databaseName = null) : MySQL
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
     * @return MySQL
     */
    public function setUsername(string $username = null) : self
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
     * @return MySQL
     */
    public function setPassword(string $password = null) : self
    {
        $this->password = $password;

        return $this;
    }
}
