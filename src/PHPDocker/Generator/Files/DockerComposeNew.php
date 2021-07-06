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

class DockerComposeNew implements GeneratedFileInterface
{
    private const DOCKER_COMPOSE_FILE_VERSION = '3.1';

    private const WORKING_DIR    = '/application';
    private const DEFAULT_VOLUME = '.:/application';

    private array $services;

    public function __construct(private Dumper $yaml, private Project $project)
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
            ->addMariadb($basePort);

        $data = [
            'version'  => self::DOCKER_COMPOSE_FILE_VERSION,
            'services' => $this->services,
        ];

        return $this->yaml->dump(input: $data, inline: 4, indent: 2);
    }

    public function getFilename(): string
    {
        return 'docker-compose.new.yaml';
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
        if ($this->project->hasMysql() === true) {
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

}
