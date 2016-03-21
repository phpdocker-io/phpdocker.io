<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

use AuronConsultingOSS\Docker\Interfaces\GeneratedFileInterface;

/**
 * Base class for all generated files.
 *
 * @package   AuronConsultingOSS\Docker\Generator\GeneratedFile
 * @copyright Auron Consulting Ltd
 */
abstract class Base implements GeneratedFileInterface
{
    /**
     * @var string
     */
    protected $contents;

    /**
     * @return string
     */
    public function getContents() : string
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     *
     * @return Base
     */
    public function setContents(string $contents) : self
    {
        $this->contents = $contents;

        return $this;
    }
}
