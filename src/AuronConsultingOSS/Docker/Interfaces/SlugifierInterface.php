<?php
namespace AuronConsultingOSS\Docker\Interfaces;

/**
 * Interface a slugifier MUST fulfil.
 *
 * @package   AuronConsultingOSS\Docker\Interfaces
 * @copyright Auron Consulting Ltd
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
    public function slugify(string $string) : string;
}
