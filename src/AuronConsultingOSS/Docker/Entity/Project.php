<?php
namespace AuronConsultingOSS\Docker\Entity;

use AuronConsultingOSS\Docker\Exception\MissingDependencyException;
use AuronConsultingOSS\Docker\Interfaces\HostnameSuffixInterface;
use Cocur\Slugify\Slugify;

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
    protected $name = 'your-project';

    /**
     * @var int
     */
    protected $basePort = '8000';

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
     * @var MemcachedOptions
     */
    protected $memcachedOptions;

    /**
     * @var RedisOptions
     */
    protected $redisOptions;

    /**
     * @var MailhogOptions
     */
    protected $mailhogOptions;

    /**
     * @var string
     */
    protected $projectNameSlug;

    /**
     * @var Slugify
     */
    private $slugifier;

    /**
     * @var array
     */
    private $hostnamesForServices = [];

    public function __construct()
    {
        $this->nginxOptions     = new NginxOptions();
        $this->mysqlOptions     = new MySQLOptions();
        $this->phpOptions       = new PhpOptions();
        $this->redisOptions     = new RedisOptions();
        $this->memcachedOptions = new MemcachedOptions();
        $this->mailhogOptions   = new MailhogOptions();
    }

    /**
     * Calculates the hostname of a service based on the project name, and the service's hostname suffix.
     *
     * @param HostnameSuffixInterface $service
     *
     * @return string
     */
    public function getHostnameForService(HostnameSuffixInterface $service) : string
    {
        $serviceKey = get_class($service);
        if (array_key_exists($serviceKey, $this->hostnamesForServices) === false) {
            $this->hostnamesForServices[$serviceKey] = sprintf('%s-%s', $this->getProjectNameSlug(), $service->getHostnameSuffix());
        }

        return $this->hostnamesForServices[$serviceKey];
    }

    /**
     * Returns a slugged-up version of the project name.
     *
     * @return string
     * @throws MissingDependencyException
     */
    public function getProjectNameSlug() : string
    {
        if ($this->projectNameSlug === null) {
            $this->projectNameSlug = $this->getSlugifier()->slugify($this->getName());
        }

        return $this->projectNameSlug;
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
    public function setBasePort($basePort) : self
    {
        $this->basePort = $basePort;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasNginx() : bool
    {
        return $this->nginxOptions->isEnabled();
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
        return $this->mysqlOptions->isEnabled();
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
     * @return MemcachedOptions
     */
    public function getMemcachedOptions() : MemcachedOptions
    {
        return $this->memcachedOptions;
    }

    /**
     * @param MemcachedOptions $memcachedOptions
     *
     * @return Project
     */
    public function setMemcachedOptions(MemcachedOptions $memcachedOptions) : self
    {
        $this->memcachedOptions = $memcachedOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMemcached() : bool
    {
        return $this->memcachedOptions->isEnabled();
    }

    /**
     * @param bool $hasMemcached
     *
     * @return Project
     */
    public function setHasMemcached(bool $hasMemcached) : self
    {
        $this->memcachedOptions->setEnabled($hasMemcached);

        return $this;
    }

    /**
     * @return RedisOptions
     */
    public function getRedisOptions() : RedisOptions
    {
        return $this->redisOptions;
    }

    /**
     * @param RedisOptions $redisOptions
     *
     * @return Project
     */
    public function setRedisOptions(RedisOptions $redisOptions) : self
    {
        $this->redisOptions = $redisOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasRedis() : bool
    {
        return $this->redisOptions->isEnabled();
    }

    /**
     * @param bool $hasRedis
     *
     * @return Project
     */
    public function setHasRedis(bool $hasRedis) : self
    {
        $this->redisOptions->setEnabled($hasRedis);

        return $this;
    }

    /**
     * @return MailhogOptions
     */
    public function getMailhogOptions() : MailhogOptions
    {
        return $this->mailhogOptions;
    }

    /**
     * @param MailhogOptions $mailhogOptions
     *
     * @return Project
     */
    public function setMailhogOptions(MailhogOptions $mailhogOptions) : self
    {
        $this->mailhogOptions = $mailhogOptions;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasMailhog() : bool
    {
        return $this->mailhogOptions->isEnabled();
    }

    /**
     * @param boolean $hasMailhog
     *
     * @return Project
     */
    public function setHasMailhog(bool $hasMailhog) : self
    {
        $this->mailhogOptions->setEnabled($hasMailhog);

        return $this;
    }

    /**
     * @return Slugify
     * @throws MissingDependencyException
     */
    public function getSlugifier() : Slugify
    {
        if ($this->slugifier === null) {
            throw new MissingDependencyException('Slugifier hasn\'t been initialised');
        }

        return $this->slugifier;
    }

    /**
     * @param Slugify $slugifier
     *
     * @return Project
     */
    public function setSlugifier(Slugify $slugifier) : self
    {
        $this->slugifier = $slugifier;

        return $this;
    }
}
