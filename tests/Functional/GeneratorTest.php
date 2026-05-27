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

namespace App\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class GeneratorTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient(options: [
            'environment' => 'test',
            'debug'       => false,
        ]);
    }

    #[Test]
    public function generatorRedirectsToHome(): void
    {
        $this->client->request(method: 'GET', uri: '/generator');

        self::assertResponseRedirects(expectedLocation: 'http://localhost/', expectedCode: 301);
    }

    #[Test]
    public function generatorLoads(): void
    {
        $this->client->request(method: 'GET', uri: '/');

        self::assertResponseIsSuccessful();
    }

    #[Test]
    public function testPhpExtensionsAppearInDockerfile(): void
    {
        $this->generateAndGetZip([
            'project[phpOptions][version]'          => '8.4',
            'project[phpOptions][phpExtensions]'    => ['Xdebug', 'GD'],
            'project[globalOptions][basePort]'      => '8000',
        ]);

        $dockerfile = $this->getZipFileContent('phpdocker/php-fpm/Dockerfile');

        self::assertStringContainsString('php8.4-xdebug', $dockerfile);
        self::assertStringContainsString('php8.4-gd', $dockerfile);
    }

    #[Test]
    public function testGitPackageAppearsInDockerfileWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[phpOptions][version]'     => '8.4',
            'project[phpOptions][hasGit]'      => '1',
            'project[globalOptions][basePort]' => '8000',
        ]);

        $dockerfile = $this->getZipFileContent('phpdocker/php-fpm/Dockerfile');
        self::assertStringContainsString('git', $dockerfile);

        $this->generateAndGetZip([
            'project[phpOptions][version]'     => '8.4',
            'project[globalOptions][basePort]' => '8000',
        ]);

        $dockerfile = $this->getZipFileContent('phpdocker/php-fpm/Dockerfile');
        self::assertStringNotContainsString(' git', $dockerfile);
    }

    #[Test]
    public function testCustomPathsFlowToMultipleGeneratedFiles(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'        => '8000',
            'project[globalOptions][appPath]'         => '/var/www/myapp',
            'project[globalOptions][dockerWorkingDir]' => '/srv',
            'project[phpOptions][version]'            => '8.4',
            'project[phpOptions][frontControllerPath]' => 'app/index.php',
        ]);

        $nginxConf = $this->getZipFileContent('phpdocker/nginx/nginx.conf');
        self::assertStringContainsString('index.php', $nginxConf);
        self::assertStringContainsString('app', $nginxConf);

        $dockerCompose = $this->getZipFileContent('docker-compose.yml');
        self::assertStringContainsString('/var/www/myapp', $dockerCompose);

        $dockerfile = $this->getZipFileContent('phpdocker/php-fpm/Dockerfile');
        self::assertStringContainsString('/srv', $dockerfile);
    }

    #[Test]
    public function testNonDefaultDatabaseVersionsAppearInDockerCompose(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'          => '8000',
            'project[phpOptions][version]'              => '8.4',
            'project[mysqlOptions][hasMysql]'           => '1',
            'project[mysqlOptions][version]'            => '5.7',
            'project[mysqlOptions][rootPassword]'       => 'root',
            'project[mysqlOptions][databaseName]'       => 'mydb',
            'project[mysqlOptions][username]'           => 'user',
            'project[mysqlOptions][password]'           => 'pass',
            'project[postgresOptions][hasPostgres]'     => '1',
            'project[postgresOptions][version]'         => '14',
            'project[postgresOptions][rootUser]'        => 'pguser',
            'project[postgresOptions][rootPassword]'    => 'pgpass',
            'project[postgresOptions][databaseName]'    => 'pgdb',
            'project[mariadbOptions][hasMariadb]'       => '1',
            'project[mariadbOptions][version]'          => '10.4',
            'project[mariadbOptions][rootPassword]'     => 'root',
            'project[mariadbOptions][databaseName]'     => 'mydb',
            'project[mariadbOptions][username]'         => 'user',
            'project[mariadbOptions][password]'         => 'pass',
        ]);

        $dockerCompose = $this->getZipFileContent('docker-compose.yml');

        self::assertStringContainsString('mysql:5.7', $dockerCompose);
        self::assertStringContainsString('postgres:14', $dockerCompose);
        self::assertStringContainsString('mariadb:10.4', $dockerCompose);
    }

    #[Test]
    public function testElasticsearchVersionAppearsInDockerComposeWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'                    => '8000',
            'project[phpOptions][version]'                        => '8.4',
            'project[elasticsearchOptions][hasElasticsearch]'     => '1',
            'project[elasticsearchOptions][version]'              => '5.6',
        ]);

        $dockerCompose = $this->getZipFileContent('docker-compose.yml');

        self::assertStringContainsString('elasticsearch:5.6', $dockerCompose);
    }

    #[Test]
    public function testPortOffsetsRespectCustomBasePort(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'       => '3000',
            'project[phpOptions][version]'           => '8.4',
            'project[hasMailhog]'                    => '1',
            'project[mysqlOptions][hasMysql]'        => '1',
            'project[mysqlOptions][rootPassword]'    => 'root',
            'project[mysqlOptions][databaseName]'    => 'mydb',
            'project[mysqlOptions][username]'        => 'user',
            'project[mysqlOptions][password]'        => 'pass',
            'project[postgresOptions][hasPostgres]'  => '1',
            'project[postgresOptions][rootUser]'     => 'pguser',
            'project[postgresOptions][rootPassword]' => 'pgpass',
            'project[postgresOptions][databaseName]' => 'pgdb',
        ]);

        $dockerCompose = $this->getZipFileContent('docker-compose.yml');

        self::assertStringContainsString('3001', $dockerCompose); // Mailhog offset +1
        self::assertStringContainsString('3002', $dockerCompose); // MySQL offset +2
        self::assertStringContainsString('3004', $dockerCompose); // Postgres offset +4
    }

    private function generateAndGetZip(array $formData): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive', $formData);

        self::assertResponseIsSuccessful();
    }

    private function getZipFileContent(string $filename): string
    {
        $response = $this->client->getResponse();
        self::assertInstanceOf(BinaryFileResponse::class, $response, 'Expected a zip file response; form submission may have failed validation');

        $path = $response->getFile()->getPathname();
        self::assertFileExists($path, sprintf('Zip temp file does not exist at: %s', $path));

        $zip    = new ZipArchive();
        $result = $zip->open($path);
        self::assertSame(true, $result, sprintf('Failed to open zip at %s: error %d', $path, $result));

        $fileContent = $zip->getFromName($filename);
        $zip->close();

        self::assertNotFalse($fileContent, sprintf('File "%s" not found in zip archive', $filename));

        return $fileContent;
    }

    #[Test]
    public function generatorRequiresABasePort(): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive', [
            'project[globalOptions][basePort]' => '',
        ]);

        self::assertSelectorTextContains('#container_for_basePort', 'This value should not be blank.');
    }

    #[Test]
    public function testDefaultZipGeneration(): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive');

        self::assertResponseIsSuccessful();

        $response = $this->client->getResponse();
        self::assertInstanceOf(BinaryFileResponse::class, $response);
        self::assertStringContainsString('phpdocker.zip', $response->headers->get('Content-Disposition') ?? '');
    }

    #[Test]
    public function testDefaultZipContainsAllExpectedFiles(): void
    {
        $this->generateAndGetZip(['project[globalOptions][basePort]' => '8000']);

        self::assertTrue($this->zipContainsFile('docker-compose.yml'));
        self::assertTrue($this->zipContainsFile('phpdocker/php-fpm/Dockerfile'));
        self::assertTrue($this->zipContainsFile('phpdocker/php-fpm/php-ini-overrides.ini'));
        self::assertTrue($this->zipContainsFile('phpdocker/nginx/nginx.conf'));
        self::assertTrue($this->zipContainsFile('phpdocker/README.md'));
        self::assertTrue($this->zipContainsFile('phpdocker/README.html'));
    }

    #[Test]
    public function testWebserverAndPhpFpmAlwaysPresent(): void
    {
        $this->generateAndGetZip(['project[globalOptions][basePort]' => '8000']);

        $this->zipFileContains('docker-compose.yml', 'webserver:');
        $this->zipFileContains('docker-compose.yml', 'php-fpm:');
    }

    #[Test]
    public function testPhp82ReflectedInDockerfile(): void
    {
        $this->generateAndGetZip([
            'project[phpOptions][version]'     => '8.2',
            'project[globalOptions][basePort]' => '8000',
        ]);

        $this->zipFileContains('phpdocker/php-fpm/Dockerfile', 'phpdockerio/php:8.2-fpm');
    }

    #[Test]
    public function testPhp85ReflectedInDockerfile(): void
    {
        $this->generateAndGetZip([
            'project[phpOptions][version]'     => '8.5',
            'project[globalOptions][basePort]' => '8000',
        ]);

        $this->zipFileContains('phpdocker/php-fpm/Dockerfile', 'phpdockerio/php:8.5-fpm');
    }

    #[Test]
    public function testMysqlValidationWorks(): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive', [
            'project[mysqlOptions][hasMysql]' => '1',
        ]);

        self::assertSelectorTextContains('#container_for_mysql_rootPassword', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mysql_databaseName', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mysql_username', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mysql_password', 'This value should not be blank.');
    }

    #[Test]
    public function testMariadbValidationWorks(): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive', [
            'project[mariadbOptions][hasMariadb]' => '1',
        ]);

        self::assertSelectorTextContains('#container_for_mariadb_rootPassword', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mariadb_databaseName', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mariadb_username', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_mariadb_password', 'This value should not be blank.');
    }

    #[Test]
    public function testPostgresValidationWorks(): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm('Generate project archive', [
            'project[postgresOptions][hasPostgres]' => '1',
        ]);

        self::assertSelectorTextContains('#container_for_postgres_rootUser', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_postgres_rootPassword', 'This value should not be blank.');
        self::assertSelectorTextContains('#container_for_postgres_databaseName', 'This value should not be blank.');
    }

    #[Test]
    public function testMysqlConfigWorksCorrectly(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'    => '8000',
            'project[phpOptions][version]'        => '8.4',
            'project[mysqlOptions][hasMysql]'     => '1',
            'project[mysqlOptions][rootPassword]' => 'root pass',
            'project[mysqlOptions][databaseName]' => 'db name',
            'project[mysqlOptions][username]'     => 'user',
            'project[mysqlOptions][password]'     => 'pass',
        ]);

        $this->zipFileContains('docker-compose.yml', 'mysql:');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_ROOT_PASSWORD=root pass');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_DATABASE=db name');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_USER=user');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_PASSWORD=pass');
    }

    #[Test]
    public function testMariadbConfigWorksCorrectly(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'       => '8000',
            'project[phpOptions][version]'           => '8.4',
            'project[mariadbOptions][hasMariadb]'     => '1',
            'project[mariadbOptions][rootPassword]'  => 'root pass',
            'project[mariadbOptions][databaseName]'  => 'db name',
            'project[mariadbOptions][username]'      => 'user',
            'project[mariadbOptions][password]'      => 'pass',
        ]);

        $this->zipFileContains('docker-compose.yml', 'mariadb:');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_ROOT_PASSWORD=root pass');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_DATABASE=db name');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_USER=user');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_PASSWORD=pass');
    }

    #[Test]
    public function testPostgresConfigWorksCorrectly(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'         => '8000',
            'project[phpOptions][version]'             => '8.4',
            'project[postgresOptions][hasPostgres]'    => '1',
            'project[postgresOptions][rootUser]'       => 'root user',
            'project[postgresOptions][rootPassword]'   => 'root pass',
            'project[postgresOptions][databaseName]'   => 'db name',
        ]);

        $this->zipFileContains('docker-compose.yml', 'postgres:');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_USER=root user');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_PASSWORD=root pass');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_DB=db name');
    }

    #[Test]
    public function testRedisIncludedWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]' => '8000',
            'project[phpOptions][version]'     => '8.4',
            'project[hasRedis]'                => '1',
        ]);

        $this->zipFileContains('docker-compose.yml', 'redis:');
    }

    #[Test]
    public function testMemcachedIncludedWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]' => '8000',
            'project[phpOptions][version]'     => '8.4',
            'project[hasMemcached]'            => '1',
        ]);

        $this->zipFileContains('docker-compose.yml', 'memcached:');
    }

    #[Test]
    public function testMailhogIncludedWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]' => '8000',
            'project[phpOptions][version]'     => '8.4',
            'project[hasMailhog]'              => '1',
        ]);

        $this->zipFileContains('docker-compose.yml', 'mailhog:');
    }

    #[Test]
    public function testClickhouseIncludedWhenEnabled(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]' => '8000',
            'project[phpOptions][version]'     => '8.4',
            'project[hasClickhouse]'           => '1',
        ]);

        $this->zipFileContains('docker-compose.yml', 'clickhouse:');
    }

    #[Test]
    public function testOptionalServicesAbsentByDefault(): void
    {
        $this->generateAndGetZip(['project[globalOptions][basePort]' => '8000']);

        $this->zipFileNotContains('docker-compose.yml', 'redis:');
        $this->zipFileNotContains('docker-compose.yml', 'memcached:');
        $this->zipFileNotContains('docker-compose.yml', 'mailhog:');
        $this->zipFileNotContains('docker-compose.yml', 'clickhouse:');
        $this->zipFileNotContains('docker-compose.yml', 'mysql:');
        $this->zipFileNotContains('docker-compose.yml', 'mariadb:');
        $this->zipFileNotContains('docker-compose.yml', 'postgres:');
        $this->zipFileNotContains('docker-compose.yml', 'elasticsearch:');
    }

    #[Test]
    public function testAllOptionalServicesEnabledSimultaneously(): void
    {
        $this->generateAndGetZip([
            'project[globalOptions][basePort]'                => '8000',
            'project[phpOptions][version]'                    => '8.4',
            'project[hasRedis]'                               => '1',
            'project[hasMemcached]'                           => '1',
            'project[hasMailhog]'                             => '1',
            'project[hasClickhouse]'                          => '1',
            'project[mysqlOptions][hasMysql]'                 => '1',
            'project[mysqlOptions][rootPassword]'             => 'root pass',
            'project[mysqlOptions][databaseName]'             => 'db name',
            'project[mysqlOptions][username]'                 => 'user',
            'project[mysqlOptions][password]'                 => 'pass',
            'project[mariadbOptions][hasMariadb]'             => '1',
            'project[mariadbOptions][rootPassword]'          => 'root pass',
            'project[mariadbOptions][databaseName]'          => 'db name',
            'project[mariadbOptions][username]'              => 'user',
            'project[mariadbOptions][password]'              => 'pass',
            'project[postgresOptions][hasPostgres]'           => '1',
            'project[postgresOptions][rootUser]'              => 'root user',
            'project[postgresOptions][rootPassword]'          => 'root pass',
            'project[postgresOptions][databaseName]'          => 'db name',
        ]);

        $this->zipFileContains('docker-compose.yml', 'redis:');
        $this->zipFileContains('docker-compose.yml', 'memcached:');
        $this->zipFileContains('docker-compose.yml', 'mailhog:');
        $this->zipFileContains('docker-compose.yml', 'clickhouse:');
        $this->zipFileContains('docker-compose.yml', 'mysql:');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_ROOT_PASSWORD=root pass');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_DATABASE=db name');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_USER=user');
        $this->zipFileContains('docker-compose.yml', 'MYSQL_PASSWORD=pass');
        $this->zipFileContains('docker-compose.yml', 'mariadb:');
        $this->zipFileContains('docker-compose.yml', 'postgres:');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_USER=root user');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_PASSWORD=root pass');
        $this->zipFileContains('docker-compose.yml', 'POSTGRES_DB=db name');
    }

    private function zipContainsFile(string $filename): bool
    {
        $response = $this->client->getResponse();
        if (!$response instanceof BinaryFileResponse) {
            return false;
        }

        $path = $response->getFile()->getPathname();
        if (!is_file($path)) {
            return false;
        }

        $zip    = new ZipArchive();
        $result = $zip->open($path);
        if ($result !== true) {
            return false;
        }

        $content = $zip->getFromName($filename);
        $zip->close();

        return $content !== false;
    }

    private function zipFileContains(string $filename, string $expected): void
    {
        self::assertStringContainsString($expected, $this->getZipFileContent($filename));
    }

    private function zipFileNotContains(string $filename, string $expected): void
    {
        self::assertStringNotContainsString($expected, $this->getZipFileContent($filename));
    }
}
