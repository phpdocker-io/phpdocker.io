<?php
namespace AuronConsultingOSS\Docker\Entity;

/**
 * Defines a single project.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Project
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $basePort;

    /**
     * @var NginxOptions
     */
    protected $nginxOptions;

    /**
     * @var MySQLOptions
     */
    protected $mysqlOptions;

    /**
     * @var PhpOptions
     */
    protected $phpOptions;

    /**
     * @var bool
     */
    protected $hasMemcached = false;

    /**
     * @var bool
     */
    protected $hasRedis = false;

    /**
     * @var bool
     */
    protected $hasMailcatcher = false;

    public function __construct()
    {
        $this->nginxOptions = new NginxOptions();
        $this->mysqlOptions = new MySQLOptions();
        $this->phpOptions   = new PhpOptions();
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Project
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getBasePort()
    {
        return $this->basePort;
    }

    /**
     * @param int $basePort
     *
     * @return Project
     */
    public function setBasePort($basePort)
    {
        $this->basePort = $basePort;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasNginx() : bool
    {
        return $this->nginxOptions === null;
    }

    /**
     * @return NginxOptions
     */
    public function getNginxOptions() : NginxOptions
    {
        return $this->nginxOptions;
    }

    /**
     * @param NginxOptions $nginxOptions
     *
     * @return Project
     */
    public function setNginxOptions(NginxOptions $nginxOptions) : self
    {
        $this->nginxOptions = $nginxOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMysql() : bool
    {
        return $this->mysqlOptions === null;
    }

    /**
     * @return MySQLOptions
     */
    public function getMysqlOptions() : MySQLOptions
    {
        return $this->mysqlOptions;
    }

    /**
     * @param MySQLOptions $mysqlOptions
     *
     * @return Project
     */
    public function setMysqlOptions(MySQLOptions $mysqlOptions) : self
    {
        $this->mysqlOptions = $mysqlOptions;

        return $this;
    }

    /**
     * @return PhpOptions
     */
    public function getPhpOptions() : PhpOptions
    {
        return $this->phpOptions;
    }

    /**
     * @param PhpOptions $phpOptions
     *
     * @return Project
     */
    public function setPhpOptions(PhpOptions $phpOptions) : self
    {
        $this->phpOptions = $phpOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMemcached() : bool
    {
        return $this->hasMemcached;
    }

    /**
     * @param bool $hasMemcached
     *
     * @return Project
     */
    public function setHasMemcached(bool $hasMemcached) : self
    {
        $this->hasMemcached = $hasMemcached;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasRedis() : bool
    {
        return $this->hasRedis;
    }

    /**
     * @param bool $hasRedis
     *
     * @return Project
     */
    public function setHasRedis(bool $hasRedis) : self
    {
        $this->hasRedis = $hasRedis;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasMailcatcher()
    {
        return $this->hasMailcatcher;
    }

    /**
     * @param boolean $hasMailcatcher
     *
     * @return Project
     */
    public function setHasMailcatcher(bool $hasMailcatcher) : self
    {
        $this->hasMailcatcher = $hasMailcatcher;

        return $this;
    }
}
