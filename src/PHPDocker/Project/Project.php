<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace PHPDocker\Project;

use PHPDocker\Interfaces\ContainerNameSuffixInterface;
use PHPDocker\Interfaces\SlugifierInterface;

/**
 * Defines a single project.
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
     * @var ServiceOptions\Application
     */
    protected $applicationOptions;

    /**
     * @var ServiceOptions\Nginx
     */
    protected $nginxOptions;

    /**
     * @var ServiceOptions\MySQL
     */
    protected $mysqlOptions;

    /**
     * @var ServiceOptions\MariaDB
     */
    protected $mariadbOptions;

    /**
     * @var ServiceOptions\Postgres
     */
    protected $postgresOptions;

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
     * @var ServiceOptions\Elasticsearch
     */
    protected $elasticsearchOptions;

    /**
     * @var ServiceOptions\Clickhouse
     */
    protected $clickhouseOptions;

    /**
     * @var string
     */
    protected $projectNameSlug;

    /**
     * @var SlugifierInterface
     */
    private $slugifier;

    /**
     * Initialise project
     *
     * @param SlugifierInterface $slugifier
     */
    public function __construct(SlugifierInterface $slugifier)
    {
        // Handle dependency injection
        $this->slugifier = $slugifier;

        // Initialise project properties
        $this->applicationOptions   = new ServiceOptions\Application();
        $this->nginxOptions         = new ServiceOptions\Nginx();
        $this->mysqlOptions         = new ServiceOptions\MySQL();
        $this->mariadbOptions       = new ServiceOptions\MariaDB();
        $this->postgresOptions      = new ServiceOptions\Postgres();
        $this->phpOptions           = new ServiceOptions\Php();
        $this->redisOptions         = new ServiceOptions\Redis();
        $this->memcachedOptions     = new ServiceOptions\Memcached();
        $this->mailhogOptions       = new ServiceOptions\Mailhog();
        $this->elasticsearchOptions = new ServiceOptions\Elasticsearch();
        $this->clickhouseOptions    = new ServiceOptions\Clickhouse();
    }

    /**
     * Returns a slugged-up version of the project name.
     *
     * @return string
     */
    public function getProjectNameSlug(): string
    {
        if ($this->projectNameSlug === null) {
            $this->projectNameSlug = $this->getSlugifier()->slugify($this->getName());
        }

        return $this->projectNameSlug;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Project
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getBasePort(): ?int
    {
        return $this->basePort;
    }

    /**
     * @param int $basePort
     *
     * @return Project
     */
    public function setBasePort($basePort): self
    {
        $this->basePort = $basePort;

        return $this;
    }

    /**
     * @return ServiceOptions\Application
     */
    public function getApplicationOptions(): ServiceOptions\Application
    {
        return $this->applicationOptions;
    }

    /**
     * @param ServiceOptions\Application $applicationOptions
     *
     * @return Project
     */
    public function setApplicationOptions(ServiceOptions\Application $applicationOptions): self
    {
        $this->applicationOptions = $applicationOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasNginx(): bool
    {
        return $this->nginxOptions->isEnabled();
    }

    /**
     * @return ServiceOptions\Nginx
     */
    public function getNginxOptions(): ServiceOptions\Nginx
    {
        return $this->nginxOptions;
    }

    /**
     * @param ServiceOptions\Nginx $nginxOptions
     *
     * @return Project
     */
    public function setNginxOptions(ServiceOptions\Nginx $nginxOptions): self
    {
        $this->nginxOptions = $nginxOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMysql(): bool
    {
        return $this->mysqlOptions->isEnabled();
    }

    /**
     * @return ServiceOptions\MySQL
     */
    public function getMysqlOptions(): ServiceOptions\MySQL
    {
        return $this->mysqlOptions;
    }

    /**
     * @param ServiceOptions\MySQL $mysqlOptions
     *
     * @return Project
     */
    public function setMysqlOptions(ServiceOptions\MySQL $mysqlOptions): self
    {
        $this->mysqlOptions = $mysqlOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMariadb(): bool
    {
        return $this->mariadbOptions->isEnabled();
    }

    /**
     * @return ServiceOptions\MariaDB
     */
    public function getMariadbOptions(): ServiceOptions\MariaDB
    {
        return $this->mariadbOptions;
    }

    /**
     * @param ServiceOptions\MariaDB $mariadbOptions
     *
     * @return Project
     */
    public function setMariadbOptions(ServiceOptions\MariaDB $mariadbOptions): self
    {
        $this->mariadbOptions = $mariadbOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasPostgres(): bool
    {
        return $this->postgresOptions->isEnabled();
    }

    /**
     * @return ServiceOptions\Postgres
     */
    public function getPostgresOptions(): ServiceOptions\Postgres
    {
        return $this->postgresOptions;
    }

    /**
     * @param ServiceOptions\Postgres $postgresOptions
     *
     * @return Project
     */
    public function setPostgresOptions(ServiceOptions\Postgres $postgresOptions): self
    {
        $this->postgresOptions = $postgresOptions;

        return $this;
    }

    /**
     * @return ServiceOptions\Php
     */
    public function getPhpOptions(): ServiceOptions\Php
    {
        return $this->phpOptions;
    }

    /**
     * @param ServiceOptions\Php $phpOptions
     *
     * @return Project
     */
    public function setPhpOptions(ServiceOptions\Php $phpOptions): self
    {
        $this->phpOptions = $phpOptions;

        return $this;
    }

    /**
     * @return ServiceOptions\Memcached
     */
    public function getMemcachedOptions(): ServiceOptions\Memcached
    {
        return $this->memcachedOptions;
    }

    /**
     * @param ServiceOptions\Memcached $memcachedOptions
     *
     * @return Project
     */
    public function setMemcachedOptions(ServiceOptions\Memcached $memcachedOptions): self
    {
        $this->memcachedOptions = $memcachedOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasMemcached(): bool
    {
        return $this->memcachedOptions->isEnabled();
    }

    /**
     * @param bool $hasMemcached
     *
     * @return Project
     */
    public function setHasMemcached(bool $hasMemcached): self
    {
        $this->memcachedOptions->setEnabled($hasMemcached);

        return $this;
    }

    /**
     * @return ServiceOptions\Redis
     */
    public function getRedisOptions(): ServiceOptions\Redis
    {
        return $this->redisOptions;
    }

    /**
     * @param ServiceOptions\Redis $redisOptions
     *
     * @return Project
     */
    public function setRedisOptions(ServiceOptions\Redis $redisOptions): self
    {
        $this->redisOptions = $redisOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasRedis(): bool
    {
        return $this->redisOptions->isEnabled();
    }

    /**
     * @param bool $hasRedis
     *
     * @return Project
     */
    public function setHasRedis(bool $hasRedis): self
    {
        $this->redisOptions->setEnabled($hasRedis);

        return $this;
    }

    /**
     * @return ServiceOptions\Mailhog
     */
    public function getMailhogOptions(): ServiceOptions\Mailhog
    {
        return $this->mailhogOptions;
    }

    /**
     * @param ServiceOptions\Mailhog $mailhogOptions
     *
     * @return Project
     */
    public function setMailhogOptions(ServiceOptions\Mailhog $mailhogOptions): self
    {
        $this->mailhogOptions = $mailhogOptions;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasMailhog(): bool
    {
        return $this->mailhogOptions->isEnabled();
    }

    /**
     * @param boolean $hasMailhog
     *
     * @return Project
     */
    public function setHasMailhog(bool $hasMailhog): self
    {
        $this->mailhogOptions->setEnabled($hasMailhog);

        return $this;
    }

    /**
     * @return SlugifierInterface
     * @throws Exception\MissingDependencyException
     */
    public function getSlugifier(): SlugifierInterface
    {
        if ($this->slugifier === null) {
            throw new Exception\MissingDependencyException('Slugifier hasn\'t been initialised');
        }

        return $this->slugifier;
    }

    /**
     * @return ServiceOptions\Elasticsearch
     */
    public function getElasticsearchOptions(): ServiceOptions\Elasticsearch
    {
        return $this->elasticsearchOptions;
    }

    /**
     * @param ServiceOptions\Elasticsearch $elasticsearchOptions
     *
     * @return Project
     */
    public function setElasticsearchOptions(ServiceOptions\Elasticsearch $elasticsearchOptions): self
    {
        $this->elasticsearchOptions = $elasticsearchOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasElasticsearch(): bool
    {
        return $this->elasticsearchOptions->isEnabled();
    }

    /**
     * @param bool $hasElasticsearch
     *
     * @return Project
     */
    public function setHasElasticsearch(bool $hasElasticsearch): self
    {
        $this->elasticsearchOptions->setEnabled($hasElasticsearch);

        return $this;
    }

    /**
     * @return ServiceOptions\Clickhouse
     */
    public function getClickhouseOptions(): ServiceOptions\Clickhouse
    {
        return $this->clickhouseOptions;
    }

    /**
     * @param ServiceOptions\Clickhouse $clickhouseOptions
     *
     * @return \PHPDocker\Project\Project
     */
    public function setClickhouseOptions(ServiceOptions\Clickhouse $clickhouseOptions): self
    {
        $this->clickhouseOptions = $clickhouseOptions;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasClickhouse(): bool
    {
        return $this->clickhouseOptions->isEnabled();
    }

    /**
     * @param bool $hasClickhouse
     *
     * @return Project
     */
    public function setHasClickhouse(bool $hasClickhouse): self
    {
        $this->clickhouseOptions->setEnabled($hasClickhouse);

        return $this;
    }
}
