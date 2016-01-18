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
    protected $rootPassword = 'root-password';

    /**
     * @var string
     */
    protected $databaseName = 'database-name';

    /**
     * @var string
     */
    protected $username = 'username';

    /**
     * @var string
     */
    protected $password = 'password';
    
    /**
     * @var bool
     */
    protected $hasMysql = false;

    /**
     * @inheritdoc
     */
    public function getDefaultHostname() : string
    {
        return 'mysql';
    }

    /**
     * @return string
     */
    public function getRootPassword() : string
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
    public function getDatabaseName() : string
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
    public function getUsername() : string
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
    public function getPassword() : string
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

    /**
     * @return boolean
     */
    public function hasMysql() : bool
    {
        return $this->hasMysql;
    }

    /**
     * @param boolean $hasMysql
     *
     * @return bool
     */
    public function setHasMysql($hasMysql)
    {
        $this->hasMysql = $hasMysql;

        return $this;
    }
}
