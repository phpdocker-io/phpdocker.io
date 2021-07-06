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

namespace App\PHPDocker\Generator;

use App\PHPDocker\Generator\Files\Dockerfile;
use App\PHPDocker\Generator\Files\ReadmeMd;
use App\PHPDocker\Interfaces\ArchiveInterface;
use App\PHPDocker\Interfaces\SlugifierInterface;
use App\PHPDocker\PhpExtension\PhpExtension;
use App\PHPDocker\Project\Project;
use App\PHPDocker\Zip\Archiver;
use Michelf\MarkdownExtra;
use Twig\Environment;

/**
 * Docker environment generator based on a Project.
 */
class Generator
{
    private const BASE_ZIP_FOLDER = 'phpdocker';

    public function __construct(
        protected Archiver $archiver,
        protected Environment $twig,
        protected MarkdownExtra $markdownExtra,
        protected SlugifierInterface $slugifier,
    ) {
        $this->archiver->setBaseFolder(self::BASE_ZIP_FOLDER);
    }

    /**
     * Generates all the files from the Project, and returns as an archive file.
     */
    public function generate(Project $project): ArchiveInterface
    {
//        $this
//            ->archiver
//            ->addFile($this->getReadmeMd($project))
//            ->addFile($this->getReadmeHtml($project))
//            ->addFile($this->getPhpDockerConf($project))
//            ->addFile($this->getPhpIniOverrides($project))
//            ->addFile($this->getNginxConf($project))
//            ->addFile($this->getDockerCompose($project), true);

        $this->archiver
            ->addFile(new ReadmeMd($this->twig, $project))
            ->addFile(new Dockerfile($this->twig, $project));

        return $this->archiver->generateArchive(sprintf('%s.zip', $this->slugifier->slugify($project->getName())));
    }

    /**
     * Generates the Readme file in Markdown format.
     */
    private function getReadmeMd(Project $project): GeneratedFile\ReadmeMd
    {
        static $readme;

        if ($readme === null) {
            $readme = new GeneratedFile\ReadmeMd($this->twig->render('README.md.twig', ['project' => $project]));
        }

        return $readme;
    }

    /**
     * Returns the HTML readme, converted off Markdown.
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
     */
    private function getDockerCompose(Project $project): GeneratedFile\DockerCompose
    {
        $data = [
            'phpVersion'      => $project->getPhpOptions()->getVersion(),
            'phpIniOverrides' => (new GeneratedFile\PhpIniOverrides(''))->getFilename(),
            'project'         => $project,
            'hasClickhouse'   => $project->hasClickhouse(),
        ];

        // Get YML file, raw, then prettify by eliminating excess of blank lines and ensuring a blank line at the end
        $rendered = $this->twig->render('docker-compose.yml.twig', $data);
        $rendered = preg_replace("/[\r\n]{2,}/", "\n\n", $rendered);
        $rendered .= "\n";

        return new GeneratedFile\DockerCompose($rendered);
    }

    /**
     * Returns the dockerfile for php-fpm.
     */
    private function getPhpDockerConf(Project $project): GeneratedFile\PhpDockerConf
    {
        $phpOptions = $project->getPhpOptions();
        $packages   = [];

        if ($project->getPhpOptions()->hasGit() === true) {
            $packages[] = 'git';
        }

        // Resolve extension packages to install
        foreach ($phpOptions->getExtensions() as $extension) {
            /** @var PhpExtension $extension */
            $packages = array_merge($packages, $extension->getPackages());
        }

        $data = [
            'phpVersion'      => $project->getPhpOptions()->getVersion(),
            'packages'        => array_unique($packages),
            'applicationType' => $project->getApplicationOptions()->getApplicationType(),
        ];

        return new GeneratedFile\PhpDockerConf($this->twig->render('dockerfile-php-fpm.conf.twig', $data));
    }

    /**
     * Returns the contents of php.ini
     */
    private function getPhpIniOverrides(Project $project): GeneratedFile\PhpIniOverrides
    {
        $data = ['maxUploadSize' => $project->getApplicationOptions()->getUploadSize()];

        return new GeneratedFile\PhpIniOverrides($this->twig->render('php-ini-overrides.ini.twig', $data));
    }

    /**
     * Generates and returns the nginx.conf file.
     */
    private function getNginxConf(Project $project): GeneratedFile\NginxConf
    {
        $data = [
            'projectName'     => $project->getName(),
            'applicationType' => $project->getApplicationOptions()->getApplicationType(),
            'maxUploadSize'   => $project->getApplicationOptions()->getUploadSize(),
        ];

        return new GeneratedFile\NginxConf($this->twig->render('nginx.conf.twig', $data));
    }
}
