<?php
namespace PhpDockerIo\Interfaces;

/**
 * Interface ArchiveInterface
 *
 * @package PhpDockerIo\Interfaces
 */
interface ArchiveInterface
{
    /**
     * Returns the filename to serve.
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Returns the filename of the temporary file on temp storage.
     *
     * @return string
     */
    public function getTmpFilename(): string;
}
