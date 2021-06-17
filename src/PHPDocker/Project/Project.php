<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
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
 *
 */

/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */
/** @noinspection PhpPureAttributeCanBeAddedInspection */

namespace App\PHPDocker\Project;

use App\PHPDocker\Interfaces\SlugifierInterface;

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

    public function __construct(protected SlugifierInterface $slugifier)
    {
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
     */
    public function getProjectNameSlug(): string
    {
        if ($this->projectNameSlug === null) {
            $this->projectNameSlug = $this->getSlugifier()->slugify($this->getName());
        }

        return $this->projectNameSlug;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBasePort(): ?int
    {
        return $this->basePort;
    }

    public function setBasePort(int $basePort): self
    {
        $this->basePort = $basePort;

        return $this;
    }

    public function getApplicationOptions(): ServiceOptions\Application
    {
        return $this->applicationOptions;
    }

    public function setApplicationOptions(ServiceOptions\Application $applicationOptions): self
    {
        $this->applicationOptions = $applicationOptions;

        return $this;
    }

    public function hasNginx(): bool
    {
        return $this->nginxOptions->isEnabled();
    }

    public function getNginxOptions(): ServiceOptions\Nginx
    {
        return $this->nginxOptions;
    }

    public function setNginxOptions(ServiceOptions\Nginx $nginxOptions): self
    {
        $this->nginxOptions = $nginxOptions;

        return $this;
    }

    public function hasMysql(): bool
    {
        return $this->mysqlOptions->isEnabled();
    }

    public function getMysqlOptions(): ServiceOptions\MySQL
    {
        return $this->mysqlOptions;
    }

    public function setMysqlOptions(ServiceOptions\MySQL $mysqlOptions): self
    {
        $this->mysqlOptions = $mysqlOptions;

        return $this;
    }

    public function hasMariadb(): bool
    {
        return $this->mariadbOptions->isEnabled();
    }

    public function getMariadbOptions(): ServiceOptions\MariaDB
    {
        return $this->mariadbOptions;
    }

    public function setMariadbOptions(ServiceOptions\MariaDB $mariadbOptions): self
    {
        $this->mariadbOptions = $mariadbOptions;

        return $this;
    }

    public function hasPostgres(): bool
    {
        return $this->postgresOptions->isEnabled();
    }

    public function getPostgresOptions(): ServiceOptions\Postgres
    {
        return $this->postgresOptions;
    }

    public function setPostgresOptions(ServiceOptions\Postgres $postgresOptions): self
    {
        $this->postgresOptions = $postgresOptions;

        return $this;
    }

    public function getPhpOptions(): ServiceOptions\Php
    {
        return $this->phpOptions;
    }

    public function setPhpOptions(ServiceOptions\Php $phpOptions): self
    {
        $this->phpOptions = $phpOptions;

        return $this;
    }

    public function getMemcachedOptions(): ServiceOptions\Memcached
    {
        return $this->memcachedOptions;
    }

    public function setMemcachedOptions(ServiceOptions\Memcached $memcachedOptions): self
    {
        $this->memcachedOptions = $memcachedOptions;

        return $this;
    }

    public function hasMemcached(): bool
    {
        return $this->memcachedOptions->isEnabled();
    }

    public function setHasMemcached(bool $hasMemcached): self
    {
        $this->memcachedOptions->setEnabled($hasMemcached);

        return $this;
    }

    public function getRedisOptions(): ServiceOptions\Redis
    {
        return $this->redisOptions;
    }

    public function setRedisOptions(ServiceOptions\Redis $redisOptions): self
    {
        $this->redisOptions = $redisOptions;

        return $this;
    }

    public function hasRedis(): bool
    {
        return $this->redisOptions->isEnabled();
    }

    public function setHasRedis(bool $hasRedis): self
    {
        $this->redisOptions->setEnabled($hasRedis);

        return $this;
    }

    public function getMailhogOptions(): ServiceOptions\Mailhog
    {
        return $this->mailhogOptions;
    }

    public function setMailhogOptions(ServiceOptions\Mailhog $mailhogOptions): self
    {
        $this->mailhogOptions = $mailhogOptions;

        return $this;
    }

    public function hasMailhog(): bool
    {
        return $this->mailhogOptions->isEnabled();
    }

    public function setHasMailhog(bool $hasMailhog): self
    {
        $this->mailhogOptions->setEnabled($hasMailhog);

        return $this;
    }

    /**
     * @throws Exception\MissingDependencyException
     */
    public function getSlugifier(): SlugifierInterface
    {
        if ($this->slugifier === null) {
            throw new Exception\MissingDependencyException("Slugifier hasn't been initialised");
        }

        return $this->slugifier;
    }

    public function getElasticsearchOptions(): ServiceOptions\Elasticsearch
    {
        return $this->elasticsearchOptions;
    }

    public function setElasticsearchOptions(ServiceOptions\Elasticsearch $elasticsearchOptions): self
    {
        $this->elasticsearchOptions = $elasticsearchOptions;

        return $this;
    }

    public function hasElasticsearch(): bool
    {
        return $this->elasticsearchOptions->isEnabled();
    }

    public function setHasElasticsearch(bool $hasElasticsearch): self
    {
        $this->elasticsearchOptions->setEnabled($hasElasticsearch);

        return $this;
    }

    public function getClickhouseOptions(): ServiceOptions\Clickhouse
    {
        return $this->clickhouseOptions;
    }

    public function setClickhouseOptions(ServiceOptions\Clickhouse $clickhouseOptions): self
    {
        $this->clickhouseOptions = $clickhouseOptions;

        return $this;
    }

    public function hasClickhouse(): bool
    {
        return $this->clickhouseOptions->isEnabled();
    }

    public function setHasClickhouse(bool $hasClickhouse): self
    {
        $this->clickhouseOptions->setEnabled($hasClickhouse);

        return $this;
    }
}
