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
}
