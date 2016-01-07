<?php
namespace AuronConsultingOSS\Docker\Archiver;

use AuronConsultingOSS\Docker\Archive\AbstractArchiver;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;

class ZipArchiver extends AbstractArchiver
{
    private $zipfile;
    public function __construct()
    {
        $this->zipfile = new \ZipArchive();
    }

    /**
     * Adds a file to the archive.
     *
     * @param string $filename
     * @param string $contents
     *
     * @return ZipArchiver
     */
    protected function addFile(string $filename, string $contents) : self
    {
        $this->zipfile->addFromString($filename, $contents);

        return $this;
    }

    /**
     * Actually generate and return archive.
     *
     * @return ArchiveInterface
     */
    protected function generateArchive() : ArchiveInterface
    {
        $this->zipfile->close();
        return (string) $this->zipfile;
    }
}
