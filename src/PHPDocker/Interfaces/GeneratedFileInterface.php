<?php
namespace PHPDocker\Interfaces;

/**
 * Describes a parsed, generated file by its filename and contents.
 */
interface GeneratedFileInterface
{
    /**
     * Must return the relative filename this file will be described by.
     *
     * Eg:
     *   - Folder\SomeFile
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Must return the file contents as a string.
     *
     * @return string
     */
    public function getContents(): string;
}
