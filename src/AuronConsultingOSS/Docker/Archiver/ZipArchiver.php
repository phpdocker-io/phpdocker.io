<?php
namespace AuronConsultingOSS\Docker\Archiver;

use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;
use AuronConsultingOSS\Docker\Interfaces\GeneratedFileInterface;

/**
 * Creates a zip file.
 *
 * @package   AuronConsultingOSS\Docker\Archiver
 * @copyright Auron Consulting Ltd
 */
class ZipArchiver
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
        $this->zipfile = new \ZipArchive();
        $this->zipfile->open(tempnam(sys_get_temp_dir(), get_class($this)), \ZipArchive::CREATE);
    }

    /**
     * Adds a file to the list.
     *
     * @param GeneratedFileInterface $generatedFile
     *
     * @return ZipArchiver
     */
    public function addFile(GeneratedFileInterface $generatedFile) : self
    {
        $this->zipfile->addFromString(
            $this->prefixFilename($generatedFile->getFilename()),
            $generatedFile->getContents()
        );
    }

    /**
     * Generate and return archive.
     *
     * @param string $archiveFilename
     *
     * @return ArchiveInterface
     * @throws Exception\NotCreatedException
     */
    public function generateArchive(string $archiveFilename) : ArchiveInterface
    {
        $filename = $this->zipfile->filename;

        if ($this->zipfile->close() === false) {
            throw new Exception\NotCreatedException('Archive creation failed for an unknown reason');
        }

        $file = new ZipFile();
        $file
            ->setFilename($archiveFilename)
            ->setTmpFilename($filename);

        return $file;
    }

    /**
     * Sets the base folder all given files will be added into.
     *
     * @param string $baseFolder
     *
     * @return ZipArchiver
     */
    public function setBaseFolder(string $baseFolder) : self
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
    private function prefixFilename(string $filename) : string
    {
        if ($this->baseFolder !== '') {
            return sprintf('%s%s%s', $this->baseFolder, DIRECTORY_SEPARATOR, $filename);
        }

        return $filename;
    }
}
