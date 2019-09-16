<?php
declare(strict_types=1);
/**
 * Copyright 2019 Luis Alberto Pabón Flores
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

namespace PHPDocker\Generator;

use Michelf\MarkdownExtra as Markdown;
use PHPDocker\PhpExtension\PhpExtension;
use PHPDocker\Project\Project;
use PHPDocker\Util\SlugifierInterface as Slugifier;
use PHPDocker\Zip\Archiver;
use PHPDocker\Zip\File as ZipFile;
use Twig\Environment as Twig;

/**
 * Docker environment generator based on a Project.
 *
 * @package PHPDocker
 * @author  Luis A. Pabon Flores
 */
class Generator
{
    private const BASE_ZIP_FOLDER = 'phpdocker';

    /**
     * @var Archiver
     */
    protected $zipArchiver;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Markdown
     */
    protected $markdownExtra;

    /**
     * @var Slugifier
     */
    private $slugifier;

    /**
     * @var string
     */
    private $projectSlug;

    public function __construct(Archiver $archiver, Twig $twig, Markdown $markdown, Slugifier $slugifier)
    {
        $this->zipArchiver   = $archiver;
        $this->twig          = $twig;
        $this->markdownExtra = $markdown;
        $this->slugifier     = $slugifier;

        $this->zipArchiver->setBaseFolder(self::BASE_ZIP_FOLDER);
    }

    /**
     * Generates all the files from the Project, and returns as an archive file.
     *
     * @param Project $project
     *
     * @return ZipFile
     */
    public function generate(Project $project): ZipFile
    {
        $this->projectSlug = $this->slugifier->slugify($project->getName());

        $this
            ->zipArchiver
            ->addFile($this->getReadmeMd($project))
            ->addFile($this->getReadmeHtml($project))
            ->addFile($this->getPhpDockerConf($project))
            ->addFile($this->getPhpIniOverrides($project))
            ->addFile($this->getNginxConf($project))
            ->addFile($this->getDockerCompose($project), true);

        return $this->zipArchiver->generateArchive(sprintf('%s.zip', $this->projectSlug));
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
            $readme = new GeneratedFile\ReadmeMd($this->twig->render('README.md.twig', ['project' => $project]));
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
            'slug'            => $this->projectSlug,
            'project'         => $project,
        ];

        // Get YML file, raw, then prettify by eliminating excess of blank lines and ensuring a blank line at the end
        $rendered = $this->twig->render('docker-compose.yml.twig', $data);
        $rendered = preg_replace("/[\r\n]{2,}/", "\n\n", $rendered);
        $rendered .= "\n";

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
            'hasGit'            => $project->getPhpOptions()->hasGit(),
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
        $data = [
            'maxUploadSize' => $project->getApplicationOptions()->getUploadSize(),
            'xdebugEnabled' => true,  // @todo
        ];

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
            'projectNameSlug' => $this->projectSlug,
            'applicationType' => $project->getApplicationOptions()->getApplicationType(),
            'maxUploadSize'   => $project->getApplicationOptions()->getUploadSize(),
        ];

        return new GeneratedFile\NginxConf($this->twig->render('nginx.conf.twig', $data));
    }
}
