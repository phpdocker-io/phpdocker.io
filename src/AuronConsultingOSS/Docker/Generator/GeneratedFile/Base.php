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
     * You MUST provide the file contents on the constructor.
     *
     * @param string $contents
     */
    public function __construct(string $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getContents() : string
    {
        return $this->contents;
    }
}
