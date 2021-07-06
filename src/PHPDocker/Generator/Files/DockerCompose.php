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

namespace App\PHPDocker\Generator\Files;

use App\PHPDocker\Interfaces\GeneratedFileInterface;
use App\PHPDocker\Project\Project;
use Symfony\Component\Yaml\Dumper;

class DockerCompose implements GeneratedFileInterface
{
    private const DOCKER_COMPOSE_FILE_VERSION = '3.1';

    private const WORKING_DIR    = '/application';
    private const DEFAULT_VOLUME = '.:/application';

    private array $services;

    public function __construct(private Dumper $yaml, private Project $project, private string $phpIniLocation)
    {

    }

    public function getContents(): string
    {
        $basePort = $this->project->getBasePort();

        $this
            ->addMemcached()
            ->addMailhog($basePort)
            ->addRedis()
            ->addMysql($basePort)
            ->addMariadb($basePort)
            ->addPostgres($basePort)
            ->addElasticsearch()
            ->addClickhouse()
            ->addWebserver()
            ->addPhpFpm();

        $data = [
            'version'  => self::DOCKER_COMPOSE_FILE_VERSION,
            'services' => $this->services,
        ];

        return $this->yaml->dump(input: $data, inline: 4);
    }

    public function getFilename(): string
    {
        return 'docker-compose.yml';
    }

    private function addMemcached(): self
    {
        if ($this->project->hasMemcached() === true) {
            $this->services['memcached'] = ['image' => 'memcached:alpine'];
        }

        return $this;
    }

    private function addMailhog(int &$basePort): self
    {
        if ($this->project->hasMailhog() === true) {
            $basePort++;
            $this->services['mailhog'] = [
                'image' => 'mailhog/mailhog:latest',
                'ports' => [sprintf('%s:8025', $basePort)],
            ];
        }

        return $this;
    }

    private function addRedis(): self
    {
        if ($this->project->hasRedis() === true) {
            $this->services['redis'] = ['image' => 'redis:alpine'];
        }

        return $this;
    }

    private function addMysql(int &$basePort): self
    {
        if ($this->project->hasMysql() === true) {
            $basePort++;
            $mysqlOptions = $this->project->getMysqlOptions();

            $this->services['mysql'] = [
                'image'       => sprintf('mysql:%s', $mysqlOptions->getVersion()),
                'working_dir' => self::WORKING_DIR,
                'volumes'     => [self::DEFAULT_VOLUME],
                'environment' => [
                    sprintf('MYSQL_ROOT_PASSWORD=%s', $mysqlOptions->getRootPassword()),
                    sprintf('MYSQL_DATABASE=%s', $mysqlOptions->getDatabaseName()),
                    sprintf('MYSQL_USER=%s', $mysqlOptions->getUsername()),
                    sprintf('MYSQL_PASSWORD=%s', $mysqlOptions->getPassword()),
                ],
                'ports'       => [sprintf('%s:3306', $basePort)],
            ];
        }

        return $this;
    }

    private function addMariadb(int &$basePort): self
    {
        if ($this->project->hasMariadb() === true) {
            $basePort++;
            $mariadbOptions = $this->project->getMariadbOptions();

            $this->services['mariadb'] = [
                'image'       => sprintf('mariadb:%s', $mariadbOptions->getVersion()),
                'working_dir' => self::WORKING_DIR,
                'volumes'     => [self::DEFAULT_VOLUME],
                'environment' => [
                    sprintf('MYSQL_ROOT_PASSWORD=%s', $mariadbOptions->getRootPassword()),
                    sprintf('MYSQL_DATABASE=%s', $mariadbOptions->getDatabaseName()),
                    sprintf('MYSQL_USER=%s', $mariadbOptions->getUsername()),
                    sprintf('MYSQL_PASSWORD=%s', $mariadbOptions->getPassword()),
                ],
                'ports'       => [sprintf('%s:3306', $basePort)],
            ];
        }

        return $this;
    }

    private function addPostgres(int &$basePort): self
    {
        if ($this->project->hasPostgres() === true) {
            $basePort++;
            $pgOptions = $this->project->getPostgresOptions();

            $this->services['postgres'] = [
                'image'       => sprintf('postgres:%s-alpine', $pgOptions->getVersion()),
                'working_dir' => self::WORKING_DIR,
                'volumes'     => [self::DEFAULT_VOLUME],
                'environment' => [
                    sprintf('POSTGRES_USER=%s', $pgOptions->getRootUser()),
                    sprintf('POSTGRES_PASSWORD=%s', $pgOptions->getRootPassword()),
                    sprintf('POSTGRES_DB=%s', $pgOptions->getDatabaseName()),
                ],
                'ports'       => [sprintf('%s:5432', $basePort)],
            ];
        }

        return $this;
    }

    private function addElasticsearch(): self
    {
        if ($this->project->hasElasticsearch() === true) {
            $this->services['elasticsearch'] = [
                'image' => sprintf('elasticsearch:%s', $this->project->getElasticsearchOptions()->getVersion()),
            ];
        }

        return $this;
    }

    private function addClickhouse(): self
    {
        if ($this->project->hasMemcached() === true) {
            $this->services['clickhouse'] = ['image' => 'yandex/clickhouse-server:latest'];
        }

        return $this;
    }

    private function addWebserver(): self
    {
        $this->services['webserver'] = [
            'image'       => 'nginx:alpine',
            'working_dir' => self::WORKING_DIR,
            'volumes'     => [
                self::DEFAULT_VOLUME,
                './phpdocker/nginx/nginx.conf:/etc/nginx/conf.d/default.conf',
            ],
            'ports'       => [sprintf('%s:80', $this->project->getBasePort())],
        ];

        return $this;
    }

    private function addPhpFpm(): self
    {
        $shortVersion = str_replace(search: '.x', replace: '', subject: $this->project->getPhpOptions()->getVersion());

        $this->services['php-fpm'] = [
            'build'       => 'phpdocker/php-fpm',
            'working_dir' => self::WORKING_DIR,
            'volumes'     => [
                self::DEFAULT_VOLUME,
                sprintf('./phpdocker/%s:/etc/php/%s/fpm/conf.d/99-overrides.ini', $this->phpIniLocation, $shortVersion),
            ],
        ];

        return $this;
    }
}
