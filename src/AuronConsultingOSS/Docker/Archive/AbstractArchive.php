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
    protected $name;

    /**
     * @var string
     */
    protected $content;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return AbstractArchive
     */
    public function setName(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return AbstractArchive
     */
    public function setContent(string $content) : self
    {
        $this->content = $content;

        return $this;
    }
}
