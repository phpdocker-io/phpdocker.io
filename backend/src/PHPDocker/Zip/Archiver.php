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

namespace PHPDocker\Zip;

use PHPDocker\Generator\GeneratedFile\GeneratedFileInterface;
use ZipArchive;

/**
 * Creates a zip file.
 *
 * @package PHPDocker\Archiver
 * @author  Luis A. Pabon Flores
 */
class Archiver
{
    /**
     * @var string
     */
    protected $baseFolder = '';

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var \ZipArchive
     */
    private $zipfile;

    /**
     * Initialise Zip File via the zip PECL extension into a temporary file on local storage.
     */
    public function __construct()
    {
        $this->zipfile = new ZipArchive();
        $this->zipfile->open(tempnam(sys_get_temp_dir(), get_class($this)), ZipArchive::CREATE);
    }

    /**
     * Adds a file to the list.
     *
     * @param GeneratedFileInterface $generatedFile
     * @param bool                   $ignorePrefix
     *
     * @return Archiver
     */
    public function addFile(GeneratedFileInterface $generatedFile, bool $ignorePrefix = false): self
    {
        $localName = $generatedFile->getFilename();
        if ($ignorePrefix === false) {
            $localName = $this->prefixFilename($localName);
        }

        $this->zipfile->addFromString($localName, $generatedFile->getContents());

        return $this;
    }

    /**
     * Generate and return archive.
     *
     * @param string $archiveFilename
     *
     * @return File
     * @throws Exception\ArchiveNotCreatedException
     */
    public function generateArchive(string $archiveFilename): File
    {
        $filename = $this->zipfile->filename;

        if ($this->zipfile->close() === false) {
            throw new Exception\ArchiveNotCreatedException('Archive creation failed for an unknown reason');
        }

        return (new File())
            ->setFilename($archiveFilename)
            ->setTmpFilename($filename);
    }

    /**
     * Sets the base folder all given files will be added into.
     *
     * @param string $baseFolder
     *
     * @return Archiver
     */
    public function setBaseFolder(string $baseFolder): self
    {
        $this->baseFolder = $baseFolder;

        return $this;
    }

    /**
     * Prefixes a filename with the base folder.
     *
     * @param string $filename
     *
     * @return string
     */
    private function prefixFilename(string $filename): string
    {
        if ($this->baseFolder !== '') {
            return sprintf('%s%s%s', $this->baseFolder, DIRECTORY_SEPARATOR, $filename);
        }

        return $filename;
    }
}
