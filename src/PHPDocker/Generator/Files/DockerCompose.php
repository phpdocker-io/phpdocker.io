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

final readonly class DockerCompose implements GeneratedFileInterface
{
    private const string DOCKER_COMPOSE_FILE_VERSION = '3.1';

    public function __construct(private Dumper $yaml, private Project $project, private string $phpIniLocation)
    {
    }

    public function getContents(): string
    {
        $data = [
            'version'  => self::DOCKER_COMPOSE_FILE_VERSION,
            'services' => $this->buildServices(),
        ];

        return $this->tidyYaml($this->yaml->dump(input: $data, inline: 4));
    }

    public function getFilename(): string
    {
        return 'docker-compose.yml';
    }

    /**
     * @return array<string, array<int|string, mixed>>
     */
    private function buildServices(): array
    {
        $globalOptions = $this->project->getGlobalOptions();
        $basePort      = $globalOptions->getBasePort();
        $defaultVolume = sprintf('%s:%s', $globalOptions->getAppPath(), $globalOptions->getDockerWorkingDir());

        $services = [];

        if ($memcached = $this->buildMemcachedService()) {
            $services['memcached'] = $memcached;
        }

        if ($mailhog = $this->buildMailhogService($basePort)) {
            $services['mailhog'] = $mailhog;
        }

        if ($redis = $this->buildRedisService()) {
            $services['redis'] = $redis;
        }

        if ($mysql = $this->buildMysqlService($defaultVolume, $basePort)) {
            $services['mysql'] = $mysql;
        }

        if ($mariadb = $this->buildMariadbService($defaultVolume, $basePort)) {
            $services['mariadb'] = $mariadb;
        }

        if ($postgres = $this->buildPostgresService($defaultVolume, $basePort)) {
            $services['postgres'] = $postgres;
        }

        if ($elasticsearch = $this->buildElasticsearchService()) {
            $services['elasticsearch'] = $elasticsearch;
        }

        if ($clickhouse = $this->buildClickhouseService()) {
            $services['clickhouse'] = $clickhouse;
        }

        $services['webserver'] = $this->buildWebserverService($defaultVolume, $basePort);
        $services['php-fpm']   = $this->buildPhpFpmService($defaultVolume);

        return $services;
    }

    /**
     * @return array<string, string>|null
     */
    private function buildMemcachedService(): ?array
    {
        if ($this->project->hasMemcached() === false) {
            return null;
        }

        return ['image' => 'memcached:alpine'];
    }

    /**
     * @return array<string, array<int, string>|string>|null
     */
    private function buildMailhogService(int $basePort): ?array
    {
        if ($this->project->hasMailhog() === false) {
            return null;
        }

        $extPort = $this->project->getMailhogOptions()->getExternalPort($basePort);

        return [
            'image' => 'mailhog/mailhog:latest',
            'ports' => [sprintf('%s:8025', $extPort)],
        ];
    }

    /**
     * @return array<string, string>|null
     */
    private function buildRedisService(): ?array
    {
        if ($this->project->hasRedis() === false) {
            return null;
        }

        return ['image' => 'redis:alpine'];
    }

    /**
     * @return array<string, array<int, string>|string>|null
     */
    private function buildMysqlService(string $defaultVolume, int $basePort): ?array
    {
        if ($this->project->hasMysql() === false) {
            return null;
        }

        $mysql   = $this->project->getMysqlOptions();
        $extPort = $mysql->getExternalPort($basePort);

        return [
            'image'       => sprintf('mysql:%s', $mysql->getVersion()),
            'working_dir' => $this->project->getGlobalOptions()->getDockerWorkingDir(),
            'volumes'     => [$defaultVolume],
            'environment' => [
                sprintf('MYSQL_ROOT_PASSWORD=%s', $mysql->getRootPassword()),
                sprintf('MYSQL_DATABASE=%s', $mysql->getDatabaseName()),
                sprintf('MYSQL_USER=%s', $mysql->getUsername()),
                sprintf('MYSQL_PASSWORD=%s', $mysql->getPassword()),
            ],
            'ports'       => [sprintf('%s:3306', $extPort)],
        ];
    }

    /**
     * @return array<string, array<int, string>|string>|null
     */
    private function buildMariadbService(string $defaultVolume, int $basePort): ?array
    {
        if ($this->project->hasMariadb() === false) {
            return null;
        }

        $mariadb = $this->project->getMariadbOptions();
        $extPort = $mariadb->getExternalPort($basePort);

        return [
            'image'       => sprintf('mariadb:%s', $mariadb->getVersion()),
            'working_dir' => $this->project->getGlobalOptions()->getDockerWorkingDir(),
            'volumes'     => [$defaultVolume],
            'environment' => [
                sprintf('MYSQL_ROOT_PASSWORD=%s', $mariadb->getRootPassword()),
                sprintf('MYSQL_DATABASE=%s', $mariadb->getDatabaseName()),
                sprintf('MYSQL_USER=%s', $mariadb->getUsername()),
                sprintf('MYSQL_PASSWORD=%s', $mariadb->getPassword()),
            ],
            'ports'       => [sprintf('%s:3306', $extPort)],
        ];
    }

    /**
     * @return array<string, array<int, string>|string>|null
     */
    private function buildPostgresService(string $defaultVolume, int $basePort): ?array
    {
        if ($this->project->hasPostgres() === false) {
            return null;
        }

        $postgres = $this->project->getPostgresOptions();
        $extPort  = $postgres->getExternalPort($basePort);

        return [
            'image'       => sprintf('postgres:%s-alpine', $postgres->getVersion()),
            'working_dir' => $this->project->getGlobalOptions()->getDockerWorkingDir(),
            'volumes'     => [$defaultVolume],
            'environment' => [
                sprintf('POSTGRES_USER=%s', $postgres->getRootUser()),
                sprintf('POSTGRES_PASSWORD=%s', $postgres->getRootPassword()),
                sprintf('POSTGRES_DB=%s', $postgres->getDatabaseName()),
            ],
            'ports'       => [sprintf('%s:5432', $extPort)],
        ];
    }

    /**
     * @return array<string, string>|null
     */
    private function buildElasticsearchService(): ?array
    {
        if ($this->project->hasElasticsearch() === false) {
            return null;
        }

        return [
            'image' => sprintf('elasticsearch:%s', $this->project->getElasticsearchOptions()->getVersion()),
        ];
    }

    /**
     * @return array<string, string>|null
     */
    private function buildClickhouseService(): ?array
    {
        if ($this->project->hasClickhouse() === false) {
            return null;
        }

        return ['image' => 'clickhouse/clickhouse-server:latest'];
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    private function buildWebserverService(string $defaultVolume, int $basePort): array
    {
        return [
            'image'       => 'nginx:alpine',
            'working_dir' => $this->project->getGlobalOptions()->getDockerWorkingDir(),
            'volumes'     => [
                $defaultVolume,
                './phpdocker/nginx/nginx.conf:/etc/nginx/conf.d/default.conf',
            ],
            'ports'       => [sprintf('%s:80', $basePort)],
        ];
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    private function buildPhpFpmService(string $defaultVolume): array
    {
        $shortVersion = str_replace(search: '.x', replace: '', subject: $this->project->getPhpOptions()->getVersion());

        return [
            'build'       => 'phpdocker/php-fpm',
            'working_dir' => $this->project->getGlobalOptions()->getDockerWorkingDir(),
            'volumes'     => [
                $defaultVolume,
                sprintf('./phpdocker/%s:/etc/php/%s/fpm/conf.d/99-overrides.ini', $this->phpIniLocation, $shortVersion),
                sprintf('./phpdocker/%s:/etc/php/%s/cli/conf.d/99-overrides.ini', $this->phpIniLocation, $shortVersion),
            ],
        ];
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

        $matcher = static function ($match) use (&$i) {
            ++$i;
            if ($i === 1) {
                return $match[0];
            }

            return PHP_EOL . $match[0];
        };

        return preg_replace_callback('#^[\s]{4}[a-zA-Z_]+#m', $matcher, $result) ?? $result;
    }
}
