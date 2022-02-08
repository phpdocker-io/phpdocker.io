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

use App\PHPDocker\Project\ServiceOptions\Php;

/**
 * Defines a single project.
 */
class Project
{
    private ServiceOptions\Nginx         $nginxOptions;
    private ServiceOptions\MySQL         $mysqlOptions;
    private ServiceOptions\MariaDB       $mariadbOptions;
    private ServiceOptions\Postgres      $postgresOptions;
    private ServiceOptions\Memcached     $memcachedOptions;
    private ServiceOptions\Redis         $redisOptions;
    private ServiceOptions\Mailhog       $mailhogOptions;
    private ServiceOptions\Elasticsearch $elasticsearchOptions;
    private ServiceOptions\Clickhouse    $clickhouseOptions;

    public function __construct(
        private Php $phpOptions,
        private ServiceOptions\GlobalOptions $globalOptions,
    ) {
        // Initialise project properties
        $this->nginxOptions         = new ServiceOptions\Nginx();
        $this->mysqlOptions         = new ServiceOptions\MySQL();
        $this->mariadbOptions       = new ServiceOptions\MariaDB();
        $this->postgresOptions      = new ServiceOptions\Postgres();
        $this->redisOptions         = new ServiceOptions\Redis();
        $this->memcachedOptions     = new ServiceOptions\Memcached();
        $this->mailhogOptions       = new ServiceOptions\Mailhog();
        $this->elasticsearchOptions = new ServiceOptions\Elasticsearch();
        $this->clickhouseOptions    = new ServiceOptions\Clickhouse();
    }

    public function hasNginx(): bool
    {
        return $this->nginxOptions->isEnabled();
    }

    public function getNginxOptions(): ServiceOptions\Nginx
    {
        return $this->nginxOptions;
    }

    public function hasMysql(): bool
    {
        return $this->mysqlOptions->isEnabled();
    }

    public function getMysqlOptions(): ServiceOptions\MySQL
    {
        return $this->mysqlOptions;
    }

    public function hasMariadb(): bool
    {
        return $this->mariadbOptions->isEnabled();
    }

    public function getMariadbOptions(): ServiceOptions\MariaDB
    {
        return $this->mariadbOptions;
    }

    public function hasPostgres(): bool
    {
        return $this->postgresOptions->isEnabled();
    }

    public function getPostgresOptions(): ServiceOptions\Postgres
    {
        return $this->postgresOptions;
    }

    public function getPhpOptions(): ServiceOptions\Php
    {
        return $this->phpOptions;
    }

    public function getMemcachedOptions(): ServiceOptions\Memcached
    {
        return $this->memcachedOptions;
    }

    public function hasMemcached(): bool
    {
        return $this->memcachedOptions->isEnabled();
    }

    public function getRedisOptions(): ServiceOptions\Redis
    {
        return $this->redisOptions;
    }

    public function hasRedis(): bool
    {
        return $this->redisOptions->isEnabled();
    }

    public function getMailhogOptions(): ServiceOptions\Mailhog
    {
        return $this->mailhogOptions;
    }

    public function hasMailhog(): bool
    {
        return $this->mailhogOptions->isEnabled();
    }

    public function getElasticsearchOptions(): ServiceOptions\Elasticsearch
    {
        return $this->elasticsearchOptions;
    }

    public function hasElasticsearch(): bool
    {
        return $this->elasticsearchOptions->isEnabled();
    }

    public function getClickhouseOptions(): ServiceOptions\Clickhouse
    {
        return $this->clickhouseOptions;
    }

    public function hasClickhouse(): bool
    {
        return $this->clickhouseOptions->isEnabled();
    }

    public function getGlobalOptions(): ServiceOptions\GlobalOptions
    {
        return $this->globalOptions;
    }
}
