<?php
namespace AuronConsultingOSS\Docker\Archiver;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;

/**
 * Represents a zip file.
 *
 * @package   AuronConsultingOSS\Docker\Archive
 * @copyright Auron Consulting Ltd
 */
class ZipFile implements ArchiveInterface
{
    /**
     * @var string
     */
    protected $filename;

    /**
     * @var string
     */
    protected $tmpFilename;

    /**
     * @return string
     */
    public function getFilename() : string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     *
     * @return ZipFile
     */
    public function setFilename(string $filename) : self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getTmpFilename() : string
    {
        return $this->tmpFilename;
    }

    /**
     * @param string $tmpFilename
     *
     * @return ZipFile
     */
    public function setTmpFilename(string $tmpFilename) : self
    {
        $this->tmpFilename = $tmpFilename;

        return $this;
    }
}
