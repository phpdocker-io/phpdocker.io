<?php
declare(strict_types=1);

namespace App\PHPDocker\Interfaces;

/**
 * Interface a slugifier MUST fulfil.
 */
interface SlugifierInterface
{
    /**
     * Takes a string and returns a slugified version of it.
     */
    public function slugify(string $string): string;
}
