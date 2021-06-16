<?php

namespace PHPDocker\Interfaces;

/**
 * Interface ArchiveInterface
 */
interface ArchiveInterface
{
    /**
     * Returns the filename to serve.
     */
    public function getFilename(): string;

    /**
     * Returns the filename of the temporary file on temp storage.
     */
    public function getTmpFilename(): string;
}
