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

namespace App\PHPDocker\Project;

use App\PHPDocker\Project\ServiceOptions\Clickhouse;
use App\PHPDocker\Project\ServiceOptions\Elasticsearch;
use App\PHPDocker\Project\ServiceOptions\GlobalOptions;
use App\PHPDocker\Project\ServiceOptions\Mailhog;
use App\PHPDocker\Project\ServiceOptions\MariaDB;
use App\PHPDocker\Project\ServiceOptions\Memcached;
use App\PHPDocker\Project\ServiceOptions\MySQL;
use App\PHPDocker\Project\ServiceOptions\Nginx;
use App\PHPDocker\Project\ServiceOptions\Php;
use App\PHPDocker\Project\ServiceOptions\Postgres;
use App\PHPDocker\Project\ServiceOptions\Redis;

/**
 * Defines a single project.
 */
final readonly class Project
{
    private Nginx $nginxOptions;
    private MySQL $mysqlOptions;
    private MariaDB $mariadbOptions;
    private Postgres $postgresOptions;
    private Memcached $memcachedOptions;
    private Redis $redisOptions;
    private Mailhog $mailhogOptions;
    private Elasticsearch $elasticsearchOptions;
    private Clickhouse $clickhouseOptions;

    public function __construct(
        private Php $phpOptions,
        private GlobalOptions $globalOptions,
        ?Nginx $nginxOptions = null,
        ?MySQL $mysqlOptions = null,
        ?MariaDB $mariadbOptions = null,
        ?Postgres $postgresOptions = null,
        ?Memcached $memcachedOptions = null,
        ?Redis $redisOptions = null,
        ?Mailhog $mailhogOptions = null,
        ?Elasticsearch $elasticsearchOptions = null,
        ?Clickhouse $clickhouseOptions = null,
    ) {
        $this->nginxOptions         = $nginxOptions ?? new Nginx();
        $this->mysqlOptions         = $mysqlOptions ?? new MySQL();
        $this->mariadbOptions       = $mariadbOptions ?? new MariaDB();
        $this->postgresOptions      = $postgresOptions ?? new Postgres();
        $this->memcachedOptions     = $memcachedOptions ?? new Memcached();
        $this->redisOptions         = $redisOptions ?? new Redis();
        $this->mailhogOptions       = $mailhogOptions ?? new Mailhog();
        $this->elasticsearchOptions = $elasticsearchOptions ?? new Elasticsearch();
        $this->clickhouseOptions    = $clickhouseOptions ?? new Clickhouse();
    }

    public function hasNginx(): bool
    {
        return $this->nginxOptions->isEnabled();
    }

    public function getNginxOptions(): Nginx
    {
        return $this->nginxOptions;
    }

    public function hasMysql(): bool
    {
        return $this->mysqlOptions->isEnabled();
    }

    public function getMysqlOptions(): MySQL
    {
        return $this->mysqlOptions;
    }

    public function hasMariadb(): bool
    {
        return $this->mariadbOptions->isEnabled();
    }

    public function getMariadbOptions(): MariaDB
    {
        return $this->mariadbOptions;
    }

    public function hasPostgres(): bool
    {
        return $this->postgresOptions->isEnabled();
    }

    public function getPostgresOptions(): Postgres
    {
        return $this->postgresOptions;
    }

    public function getPhpOptions(): Php
    {
        return $this->phpOptions;
    }

    public function getMemcachedOptions(): Memcached
    {
        return $this->memcachedOptions;
    }

    public function hasMemcached(): bool
    {
        return $this->memcachedOptions->isEnabled();
    }

    public function getRedisOptions(): Redis
    {
        return $this->redisOptions;
    }

    public function hasRedis(): bool
    {
        return $this->redisOptions->isEnabled();
    }

    public function getMailhogOptions(): Mailhog
    {
        return $this->mailhogOptions;
    }

    public function hasMailhog(): bool
    {
        return $this->mailhogOptions->isEnabled();
    }

    public function getElasticsearchOptions(): Elasticsearch
    {
        return $this->elasticsearchOptions;
    }

    public function hasElasticsearch(): bool
    {
        return $this->elasticsearchOptions->isEnabled();
    }

    public function getClickhouseOptions(): Clickhouse
    {
        return $this->clickhouseOptions;
    }

    public function hasClickhouse(): bool
    {
        return $this->clickhouseOptions->isEnabled();
    }

    public function getGlobalOptions(): GlobalOptions
    {
        return $this->globalOptions;
    }
}
