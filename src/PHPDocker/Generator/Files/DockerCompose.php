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

    /** @var array<string, mixed> */
    private array  $services;
    private string $defaultVolume;

    public function __construct(private Dumper $yaml, private Project $project, private string $phpIniLocation)
    {

    }

    public function getContents(): string
    {
        $basePort = $this->project->getBasePort();

        $workingDir = $this->project->getWorkingDirOptions();

        $this->defaultVolume = sprintf('%s:%s', $workingDir->getLocalWorkingDir(), $workingDir->getDockerWorkingDir());

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

        return $this->tidyYaml($this->yaml->dump(input: $data, inline: 4));
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
                'working_dir' => $this->project->getWorkingDirOptions()->getDockerWorkingDir(),
                'volumes'     => [$this->defaultVolume],
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
                'working_dir' => $this->project->getWorkingDirOptions()->getDockerWorkingDir(),
                'volumes'     => [$this->defaultVolume],
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
                'working_dir' => $this->project->getWorkingDirOptions()->getDockerWorkingDir(),
                'volumes'     => [$this->defaultVolume],
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
            'working_dir' => $this->project->getWorkingDirOptions()->getDockerWorkingDir(),
            'volumes'     => [
                $this->defaultVolume,
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
            'working_dir' => $this->project->getWorkingDirOptions()->getDockerWorkingDir(),
            'volumes'     => [
                $this->defaultVolume,
                sprintf('./phpdocker/%s:/etc/php/%s/fpm/conf.d/99-overrides.ini', $this->phpIniLocation, $shortVersion),
            ],
        ];

        return $this;
    }

    private function tidyYaml(string $renderedYaml): string
    {
        return $this->addEmptyLinesBetweenItems($this->prependHeader($renderedYaml));
    }

    private function prependHeader(string $renderedYaml): string
    {
        $header = <<<TEXT
###############################################################################
#                          Generated on phpdocker.io                          #
###############################################################################

TEXT;

        return $header . $renderedYaml;
    }

    /**
     * Format YAML string to add empty lines between block objects.
     *
     * @see https://github.com/symfony/symfony/issues/22421
     */
    private function addEmptyLinesBetweenItems(string $result): string
    {
        $i = 0;

        return preg_replace_callback('#^[\s]{4}[a-zA-Z_]+#m', static function ($match) use (&$i) {
            ++$i;
            if ($i === 1) {
                return $match[0];
            }

            return PHP_EOL . $match[0];
        }, $result);
    }
}
