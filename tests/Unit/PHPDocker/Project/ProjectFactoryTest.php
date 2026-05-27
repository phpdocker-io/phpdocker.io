<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project;

use App\PHPDocker\Project\ProjectFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ProjectFactoryTest extends TestCase
{
    #[Test]
    public function fromFormDataBuildsDefaultProject(): void
    {
        $project = (new ProjectFactory())->fromFormData($this->formData());

        self::assertSame('8.4', $project->getPhpOptions()->getVersion());
        self::assertSame('.', $project->getGlobalOptions()->getAppPath());
        self::assertSame('/application', $project->getGlobalOptions()->getDockerWorkingDir());
        self::assertTrue($project->hasNginx());
        self::assertFalse($project->hasMysql());
        self::assertFalse($project->hasRedis());
    }

    #[Test]
    public function fromFormDataBuildsEnabledServices(): void
    {
        $project = (new ProjectFactory())->fromFormData($this->formData([
            'hasMemcached' => true,
            'hasRedis' => true,
            'hasMailhog' => true,
            'hasClickhouse' => true,
            'mysqlOptions' => [
                'hasMysql' => true,
                'version' => '5.7',
                'rootPassword' => 'root',
                'databaseName' => 'app',
                'username' => 'user',
                'password' => 'pass',
            ],
            'postgresOptions' => [
                'hasPostgres' => true,
                'version' => 14,
                'rootUser' => 'pguser',
                'rootPassword' => 'pgpass',
                'databaseName' => 'pgdb',
            ],
            'elasticsearchOptions' => [
                'hasElasticsearch' => true,
                'version' => '5.6',
            ],
        ]));

        self::assertTrue($project->hasMemcached());
        self::assertTrue($project->hasRedis());
        self::assertTrue($project->hasMailhog());
        self::assertTrue($project->hasClickhouse());
        self::assertTrue($project->hasMysql());
        self::assertSame('5.7', $project->getMysqlOptions()->getVersion());
        self::assertTrue($project->hasPostgres());
        self::assertSame('14', $project->getPostgresOptions()->getVersion());
        self::assertTrue($project->hasElasticsearch());
        self::assertSame('5.6', $project->getElasticsearchOptions()->getVersion());
    }

    /**
     * @param array<string, mixed> $overrides
     *
     * @return array<string, mixed>
     */
    private function formData(array $overrides = []): array
    {
        return array_replace_recursive([
            'hasMemcached' => false,
            'hasRedis' => false,
            'hasMailhog' => false,
            'hasClickhouse' => false,
            'phpOptions' => [
                'version' => '8.4',
                'phpExtensions' => [],
                'hasGit' => false,
                'frontControllerPath' => 'public/index.php',
            ],
            'globalOptions' => [
                'basePort' => 8000,
                'appPath' => './',
                'dockerWorkingDir' => '/application/',
            ],
            'mysqlOptions' => [
                'hasMysql' => false,
                'version' => '8.0',
                'rootPassword' => '',
                'databaseName' => '',
                'username' => '',
                'password' => '',
            ],
            'mariadbOptions' => [
                'hasMariadb' => false,
                'version' => '11.0',
                'rootPassword' => '',
                'databaseName' => '',
                'username' => '',
                'password' => '',
            ],
            'postgresOptions' => [
                'hasPostgres' => false,
                'version' => '15',
                'rootUser' => '',
                'rootPassword' => '',
                'databaseName' => '',
            ],
            'elasticsearchOptions' => [
                'hasElasticsearch' => false,
                'version' => '6.5.4',
            ],
        ], $overrides);
    }
}
