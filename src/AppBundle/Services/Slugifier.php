<?php
namespace AppBundle\Services;

use AuronConsultingOSS\Docker\Interfaces\SlugifierInterface;
use Cocur\Slugify\Slugify;

/**
 * String slugifier.
 *
 * @package   AppBundle\Services
 * @copyright Auron Consulting Ltd
 */
class Slugifier implements SlugifierInterface
{
    /**
     * @var Slugify
     */
    protected $slugifier;

    /**
     * Ensure we receive the slugifier.
     *
     * @param Slugify $slugifier
     */
    public function __construct(Slugify $slugifier)
    {
        $this->slugifier = $slugifier;
    }

    /**
     * Takes a string and returns a slugified version of it.
     *
     * @param string $string
     *
     * @return string
     */
    public function slugify(string $string) : string
    {
        return $this->slugifier->slugify($string);
    }
}
