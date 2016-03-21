<?php
namespace AuronConsultingOSS\Docker\Project;

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
    protected $name;

    /**
     * @var int
     */
    protected $basePort;

    /**
     * @var ServiceOptions\Nginx
     */
    protected $nginxOptions;

    /**
     * @var ServiceOptions\MySQL
     */
    protected $mysqlOptions;

    /**
     * @var ServiceOptions\Php
     */
    protected $phpOptions;

    /**
     * @var ServiceOptions\Memcached
     */
    protected $memcachedOptions;

    /**
     * @var ServiceOptions\Redis
     */
    protected $redisOptions;

    /**
     * @var ServiceOptions\Mailhog
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
        $this->nginxOptions     = new ServiceOptions\Nginx();
        $this->mysqlOptions     = new ServiceOptions\MySQL();
        $this->phpOptions       = new ServiceOptions\Php();
        $this->redisOptions     = new ServiceOptions\Redis();
        $this->memcachedOptions = new ServiceOptions\Memcached();
        $this->mailhogOptions   = new ServiceOptions\Mailhog();
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
    public function getName()
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
     * @return ServiceOptions\Nginx
     */
    public function getNginxOptions() : ServiceOptions\Nginx
    {
        return $this->nginxOptions;
    }

    /**
     * @param ServiceOptions\Nginx $nginxOptions
     *
     * @return Project
     */
    public function setNginxOptions(ServiceOptions\Nginx $nginxOptions) : self
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
     * @return ServiceOptions\MySQL
     */
    public function getMysqlOptions() : ServiceOptions\MySQL
    {
        return $this->mysqlOptions;
    }

    /**
     * @param ServiceOptions\MySQL $mysqlOptions
     *
     * @return Project
     */
    public function setMysqlOptions(ServiceOptions\MySQL $mysqlOptions) : self
    {
        $this->mysqlOptions = $mysqlOptions;

        return $this;
    }

    /**
     * @return ServiceOptions\Php
     */
    public function getPhpOptions() : ServiceOptions\Php
    {
        return $this->phpOptions;
    }

    /**
     * @param ServiceOptions\Php $phpOptions
     *
     * @return Project
     */
    public function setPhpOptions(ServiceOptions\Php $phpOptions) : self
    {
        $this->phpOptions = $phpOptions;

        return $this;
    }

    /**
     * @return ServiceOptions\Memcached
     */
    public function getMemcachedOptions() : ServiceOptions\Memcached
    {
        return $this->memcachedOptions;
    }

    /**
     * @param ServiceOptions\Memcached $memcachedOptions
     *
     * @return Project
     */
    public function setMemcachedOptions(ServiceOptions\Memcached $memcachedOptions) : self
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
     * @return ServiceOptions\Redis
     */
    public function getRedisOptions() : ServiceOptions\Redis
    {
        return $this->redisOptions;
    }

    /**
     * @param ServiceOptions\Redis $redisOptions
     *
     * @return Project
     */
    public function setRedisOptions(ServiceOptions\Redis $redisOptions) : self
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
     * @return ServiceOptions\Mailhog
     */
    public function getMailhogOptions() : ServiceOptions\Mailhog
    {
        return $this->mailhogOptions;
    }

    /**
     * @param ServiceOptions\Mailhog $mailhogOptions
     *
     * @return Project
     */
    public function setMailhogOptions(ServiceOptions\Mailhog $mailhogOptions) : self
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
