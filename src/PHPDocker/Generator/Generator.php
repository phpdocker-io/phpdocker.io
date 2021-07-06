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

use App\PHPDocker\Generator\Files\DockerCompose;
use App\PHPDocker\Generator\Files\Dockerfile;
use App\PHPDocker\Generator\Files\NginxConf;
use App\PHPDocker\Generator\Files\PhpIni;
use App\PHPDocker\Generator\Files\ReadmeHtml;
use App\PHPDocker\Generator\Files\ReadmeMd;
use App\PHPDocker\Interfaces\ArchiveInterface;
use App\PHPDocker\Interfaces\SlugifierInterface;
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
        $readmeMd = new ReadmeMd($this->twig, $project);
        $phpIni   = new PhpIni($this->twig, $project);

        $this->archiver
            ->addFile($readmeMd)
            ->addFile(new ReadmeHtml($this->twig, $this->markdownExtra, $readmeMd->getContents()))
            ->addFile(new Dockerfile($this->twig, $project))
            ->addFile($phpIni)
            ->addFile(new NginxConf($this->twig, $project))
            ->addFile(new DockerCompose($this->twig, $project, $phpIni->getFilename()), true);

        return $this->archiver->generateArchive(sprintf('%s.zip', $this->slugifier->slugify($project->getName())));
    }
}
