<?php
namespace AuronConsultingOSS\Docker\Archive;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;

/**
 * Base class for all archive files.
 *
 * @package   AuronConsultingOSS\Docker\Archive
 * @copyright Auron Consulting Ltd
 */
abstract class AbstractArchive implements ArchiveInterface
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
     * @return AbstractArchive
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
     * @return AbstractArchive
     */
    public function setTmpFilename(string $tmpFilename) : self
    {
        $this->tmpFilename = $tmpFilename;

        return $this;
    }
}
