<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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
 */

namespace PHPDocker\Generator;

use Michelf\MarkdownExtra;
use PHPDocker\Interfaces\ArchiveInterface;
use PHPDocker\PhpExtension\PhpExtension;
use PHPDocker\Project\Project;
use PHPDocker\Zip\Archiver;

/**
 * Docker environment generator based on a Project.
 *
 * @package AuronConsultingOSS\Docker
 * @author  Luis A. Pabon Flores
 */
class Generator
{
    const BASE_ZIP_FOLDER = 'phpdocker';

    /**
     * @var Archiver
     */
    protected $zipArchiver;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var MarkdownExtra
     */
    protected $markdownExtra;

    public function __construct(Archiver $archiver, \Twig_Environment $twig, MarkdownExtra $markdownExtra)
    {
        $this->zipArchiver   = $archiver;
        $this->twig          = $twig;
        $this->markdownExtra = $markdownExtra;

        $this->zipArchiver->setBaseFolder(self::BASE_ZIP_FOLDER);
    }

    /**
     * Generates all the files from the Project, and returns as an archive file.
     *
     * @param Project $project
     *
     * @return ArchiveInterface
     */
    public function generate(Project $project): ArchiveInterface
    {
        $this
            ->zipArchiver
            ->addFile($this->getReadmeMd($project))
            ->addFile($this->getReadmeHtml($project))
            ->addFile($this->getDockerCompose($project))
            ->addFile($this->getPhpDockerConf($project))
            ->addFile($this->getPhpIniOverrides($project))
            ->addFile($this->getNginxConf($project));

        return $this->zipArchiver->generateArchive(sprintf('%s.zip', $project->getProjectNameSlug()));
    }

    /**
     * Generates the Readme file in Markdown format.
     *
     * @param Project $project
     *
     * @return GeneratedFile\ReadmeMd
     */
    private function getReadmeMd(Project $project): GeneratedFile\ReadmeMd
    {
        static $readme;

        if ($readme === null) {
            $data = [
                'webserverPort' => $project->getBasePort(),
                'mailhogPort'   => $project->getBasePort() + 1,
            ];

            $readme = new GeneratedFile\ReadmeMd($this->twig->render('README.md.twig',
                array_merge($data, $this->getContainerNameDataBlock($project))));
        }

        return $readme;
    }

    /**
     * Returns the HTML readme, converted off Markdown.
     *
     * @param Project $project
     *
     * @return GeneratedFile\ReadmeHtml
     */
    private function getReadmeHtml(Project $project): GeneratedFile\ReadmeHtml
    {
        static $readmeHtml;

        if ($readmeHtml === null) {
            $html       = $this->markdownExtra->transform($this->getReadmeMd($project)->getContents());
            $readmeHtml = new GeneratedFile\ReadmeHtml($this->twig->render('README.html.twig', ['text' => $html]));
        }

        return $readmeHtml;
    }

    /**
     * Generates the docker-compose file, and returns as a string of its contents.
     *
     * @param Project $project
     *
     * @return GeneratedFile\DockerCompose
     */
    private function getDockerCompose(Project $project): GeneratedFile\DockerCompose
    {
        $data = [
            'phpVersion'      => $project->getPhpOptions()->getVersion(),
            'phpIniOverrides' => (new GeneratedFile\PhpIniOverrides(''))->getFilename(),
            'mailhogPort'     => $project->getBasePort() + 1,
            'webserverPort'   => $project->getBasePort(),
            'mysql'           => $project->getMysqlOptions(),
            'postgres'        => $project->getPostgresOptions(),
            'elasticsearch'   => $project->getElasticsearchOptions(),
        ];

        // Get hostnames
        $data = array_merge($data, $this->getContainerNameDataBlock($project));

        // Get YML file, raw, then prettify by eliminating excess of blank lines
        $rendered = $this->twig->render('docker-compose.yml.twig', $data);
        $rendered = ltrim(preg_replace("/[\r\n]{2,}/", "\n\n", $rendered));

        return new GeneratedFile\DockerCompose($rendered);
    }

    /**
     * Returns the dockerfile for php-fpm.
     *
     * @param Project $project
     *
     * @return GeneratedFile\PhpDockerConf
     */
    private function getPhpDockerConf(Project $project): GeneratedFile\PhpDockerConf
    {
        $phpOptions = $project->getPhpOptions();
        $packages   = [];

        // Resolve extension packages to install
        foreach ($phpOptions->getExtensions() as $extension) {
            /** @var PhpExtension $extension */
            $packages = array_merge($packages, $extension->getPackages());
        }

        $data = [
            'phpVersion'        => $project->getPhpOptions()->getVersion(),
            'extensionPackages' => array_unique($packages),
            'applicationType'   => $project->getApplicationOptions()->getApplicationType(),
        ];

        return new GeneratedFile\PhpDockerConf($this->twig->render('dockerfile-php-fpm.conf.twig', $data));
    }

    /**
     * Returns the contents of php.ini
     *
     * @param Project $project
     *
     * @return GeneratedFile\PhpIniOverrides
     */
    private function getPhpIniOverrides(Project $project): GeneratedFile\PhpIniOverrides
    {
        $data = ['maxUploadSize' => $project->getApplicationOptions()->getUploadSize()];

        return new GeneratedFile\PhpIniOverrides($this->twig->render('php-ini-overrides.ini.twig', $data));
    }

    /**
     * Generates and returns the nginx.conf file.
     *
     * @param Project $project
     *
     * @return GeneratedFile\NginxConf
     */
    private function getNginxConf(Project $project): GeneratedFile\NginxConf
    {
        $data = [
            'projectName'     => $project->getName(),
            'projectNameSlug' => $project->getProjectNameSlug(),
            'applicationType' => $project->getApplicationOptions()->getApplicationType(),
            'maxUploadSize'   => $project->getApplicationOptions()->getUploadSize(),
        ];

        return new GeneratedFile\NginxConf($this->twig->render('nginx.conf.twig', $data));
    }

    /**
     * Returns a data block with hostnames for all configured services.
     *
     * @param Project $project
     *
     * @return array
     */
    private function getContainerNameDataBlock(Project $project)
    {
        static $hostnameDataBlock = [];

        if (count($hostnameDataBlock) === 0) {
            $hostnameDataBlock = [
                'webserverContainerName'     => $project->getContainerNameForService($project->getNginxOptions()),
                'phpFpmContainerName'        => $project->getContainerNameForService($project->getPhpOptions()),
                'mysqlContainerName'         => $project->hasMysql() ? $project->getContainerNameForService($project->getMysqlOptions()) : null,
                'postgresContainerName'      => $project->hasPostgres() ? $project->getContainerNameForService($project->getPostgresOptions()) : null,
                'memcachedContainerName'     => $project->hasMemcached() ? $project->getContainerNameForService($project->getMemcachedOptions()) : null,
                'redisContainerName'         => $project->hasRedis() ? $project->getContainerNameForService($project->getRedisOptions()) : null,
                'mailhogContainerName'       => $project->hasMailhog() ? $project->getContainerNameForService($project->getMailhogOptions()) : null,
                'elasticsearchContainerName' => $project->hasElasticsearch() ? $project->getContainerNameForService($project->getElasticsearchOptions()) : null,
            ];
        }

        return $hostnameDataBlock;
    }

    /**
     * Calculates a random IP address based on a pattern.
     *
     * @return string
     */
    private function getVmIpAddress(): string
    {
        static $vmIpAddress;

        if ($vmIpAddress === null) {
            $vmIpAddress = sprintf(self::VM_IP_ADDRESS_PATTERN, random_int(1, 254));
        }

        return $vmIpAddress;
    }
}
