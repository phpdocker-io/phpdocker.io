<?php
declare(strict_types=1);

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
use UnexpectedValueException;

final readonly class ProjectFactory
{
    /**
     * @param array<string, mixed> $formData
     */
    public function fromFormData(array $formData): Project
    {
        /** @var array<string, mixed> $phpData */
        $phpData = $formData['phpOptions'];
        /** @var string[] $extensions */
        $extensions = $phpData['phpExtensions'] ?? [];

        /** @var array<string, mixed> $globalOptionsData */
        $globalOptionsData = $formData['globalOptions'];

        /** @var array<string, mixed> $mysqlData */
        $mysqlData = $formData['mysqlOptions'];
        /** @var array<string, mixed> $mariadbData */
        $mariadbData = $formData['mariadbOptions'];
        /** @var array<string, mixed> $postgresData */
        $postgresData = $formData['postgresOptions'];
        /** @var array<string, mixed> $elasticsearchData */
        $elasticsearchData = $formData['elasticsearchOptions'];

        return new Project(
            phpOptions: new Php(
                version: $this->stringValue($phpData, 'version'),
                extensions: $extensions,
                hasGit: $this->boolValue($phpData, 'hasGit'),
                frontControllerPath: $this->stringValue($phpData, 'frontControllerPath'),
            ),
            globalOptions: new GlobalOptions(
                basePort: $this->intValue($globalOptionsData, 'basePort'),
                appPath: rtrim($this->stringValue($globalOptionsData, 'appPath'), '/'),
                dockerWorkingDir: rtrim($this->stringValue($globalOptionsData, 'dockerWorkingDir'), '/'),
            ),
            nginxOptions: new Nginx(),
            mysqlOptions: $this->buildMySqlOptions($mysqlData),
            mariadbOptions: $this->buildMariaDbOptions($mariadbData),
            postgresOptions: $this->buildPostgresOptions($postgresData),
            memcachedOptions: new Memcached(enabled: $this->boolValue($formData, 'hasMemcached')),
            redisOptions: new Redis(enabled: $this->boolValue($formData, 'hasRedis')),
            mailhogOptions: new Mailhog(enabled: $this->boolValue($formData, 'hasMailhog')),
            elasticsearchOptions: $this->buildElasticsearchOptions($elasticsearchData),
            clickhouseOptions: new Clickhouse(enabled: $this->boolValue($formData, 'hasClickhouse')),
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function buildMySqlOptions(array $data): ?MySQL
    {
        if ($data['hasMysql'] !== true) {
            return null;
        }

        return new MySQL(
            version: $this->stringValue($data, 'version'),
            rootPassword: $this->stringValue($data, 'rootPassword'),
            databaseName: $this->stringValue($data, 'databaseName'),
            username: $this->stringValue($data, 'username'),
            password: $this->stringValue($data, 'password'),
            enabled: true,
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function buildMariaDbOptions(array $data): ?MariaDB
    {
        if ($data['hasMariadb'] !== true) {
            return null;
        }

        return new MariaDB(
            version: $this->stringValue($data, 'version'),
            rootPassword: $this->stringValue($data, 'rootPassword'),
            databaseName: $this->stringValue($data, 'databaseName'),
            username: $this->stringValue($data, 'username'),
            password: $this->stringValue($data, 'password'),
            enabled: true,
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function buildPostgresOptions(array $data): ?Postgres
    {
        if ($data['hasPostgres'] !== true) {
            return null;
        }

        return new Postgres(
            version: $this->stringValue($data, 'version'),
            rootUser: $this->stringValue($data, 'rootUser'),
            rootPassword: $this->stringValue($data, 'rootPassword'),
            databaseName: $this->stringValue($data, 'databaseName'),
            enabled: true,
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function buildElasticsearchOptions(array $data): ?Elasticsearch
    {
        if ($data['hasElasticsearch'] !== true) {
            return null;
        }

        return new Elasticsearch(
            version: $this->stringValue($data, 'version'),
            enabled: true,
        );
    }

    /**
     * @param array<string, mixed> $data
     */
    private function stringValue(array $data, string $key): string
    {
        $value = $data[$key] ?? null;
        if (is_string($value) || is_int($value) || is_float($value)) {
            return (string) $value;
        }

        throw new UnexpectedValueException(sprintf('Expected "%s" to be a scalar string value.', $key));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function intValue(array $data, string $key): int
    {
        $value = $data[$key] ?? null;
        if (is_int($value)) {
            return $value;
        }

        throw new UnexpectedValueException(sprintf('Expected "%s" to be an integer value.', $key));
    }

    /**
     * @param array<string, mixed> $data
     */
    private function boolValue(array $data, string $key): bool
    {
        $value = $data[$key] ?? null;
        if (is_bool($value)) {
            return $value;
        }

        throw new UnexpectedValueException(sprintf('Expected "%s" to be a boolean value.', $key));
    }
}
