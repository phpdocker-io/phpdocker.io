<?php
namespace PhpDockerIo\Interfaces;

/**
 * Interface a slugifier MUST fulfil.
 *
 * @package PhpDockerIo\Interfaces
 */
interface SlugifierInterface
{
    /**
     * Takes a string and returns a slugified version of it.
     *
     * @param string $string
     *
     * @return string
     */
    public function slugify(string $string): string;
}
