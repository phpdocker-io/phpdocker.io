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

namespace App\PHPDocker\Zip;

use App\PHPDocker\Interfaces\ArchiveInterface;
use App\PHPDocker\Interfaces\GeneratedFileInterface;
use ZipArchive;

/**
 * Creates a zip file.
 */
class Archiver
{
    /** @var string[] */
    protected array    $files      = [];
    protected string   $baseFolder = '';
    private ZipArchive $zipFile;

    /**
     * Initialise Zip File via the zip PECL extension into a temporary file on local storage.
     */
    public function __construct()
    {
        $this->zipFile = new ZipArchive();

        $zipFilename = tempnam(sys_get_temp_dir(), str_replace('\\', '_', self::class));
        $this->zipFile->open(sprintf('%s.zip', $zipFilename), ZipArchive::CREATE);
    }

    /**
     * Adds a file to the list.
     */
    public function addFile(GeneratedFileInterface $file, bool $ignorePrefix = false): self
    {
        $localName = $file->getFilename();
        if ($ignorePrefix === false) {
            $localName = $this->prefixFilename($localName);
        }

        $this->zipFile->addFromString($localName, $file->getContents());

        return $this;
    }

    /**
     * Generate and return archive.
     *
     * @throws Exception\ArchiveNotCreatedException
     */
    public function generateArchive(string $archiveFilename): ArchiveInterface
    {
        $filename = $this->zipFile->filename;

        if ($this->zipFile->close() === false) {
            throw new Exception\ArchiveNotCreatedException('Archive creation failed for an unknown reason');
        }

        $file = new File();
        $file
            ->setFilename($archiveFilename)
            ->setTmpFilename($filename);

        return $file;
    }

    /**
     * Sets the base folder all given files will be added into.
     */
    public function setBaseFolder(string $baseFolder): self
    {
        $this->baseFolder = $baseFolder;

        return $this;
    }

    /**
     * Prefixes a filename with the base folder.
     */
    private function prefixFilename(string $filename): string
    {
        if ($this->baseFolder !== '') {
            return sprintf('%s%s%s', $this->baseFolder, DIRECTORY_SEPARATOR, $filename);
        }

        return $filename;
    }
}
