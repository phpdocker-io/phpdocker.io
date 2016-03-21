<?php
namespace AuronConsultingOSS\Docker\Archiver;

use AuronConsultingOSS\Docker\Archiver\Exception\NotCreatedException;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;

/**
 * Generates an in-memory zip archive.
 *
 * @package   AuronConsultingOSS\Docker\Archiver
 * @copyright Auron Consulting Ltd
 */
class ZipArchiver extends AbstractArchiver
{
    /**
     * @var \ZipArchive
     */
    private $zipfile;

    public function __construct()
    {
        $this->zipfile = new \ZipArchive();
        $this->zipfile->open(tempnam(sys_get_temp_dir(), get_class($this)), \ZipArchive::CREATE);
    }

    /**
     * Adds a file to the archive.
     *
     * @param string $filename
     * @param string $contents
     *
     * @return ZipArchiver
     */
    protected function addFile(string $filename, string $contents)
    {
        $this->zipfile->addFromString($filename, $contents);

        return $this;
    }

    /**
     * Actually generate and return archive.
     *
     * @param string $archiveFilename
     *
     * @return ArchiveInterface
     * @throws NotCreatedException
     */
    protected function generateArchive(string $archiveFilename) : ArchiveInterface
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
     * Returns the file extension for this particular archive.
     *
     * @return string
     */
    protected function getFileExtension() : string
    {
        return 'zip';
    }
}
