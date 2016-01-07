<?php
namespace AuronConsultingOSS\Docker\Generator;

use AuronConsultingOSS\Docker\Archive\AbstractArchiver;
use AuronConsultingOSS\Docker\Archiver\ZipArchiver;
use AuronConsultingOSS\Docker\Generator;
use Cocur\Slugify\Slugify;

/**
 * Builder for generator. If not provided, it will spawn and inject default dependencies.
 *
 * @package   AuronConsultingOSS\Docker\Generator
 * @copyright Auron Consulting Ltd
 */
class Builder
{
    /**
     * Location for
     */
    const DEFAULT_TEMPLATE_LOCATION = __DIR__ . PATH_SEPARATOR . '..' . PATH_SEPARATOR . 'Template';

    /**
     * @var AbstractArchiver
     */
    private $archiver;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var Slugify
     */
    private $slugify;

    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * Builds and returns a Generator. Will spawn all dependencies also, if not already supplied by consumer.
     *
     * @return Generator
     */
    public function build() : Generator
    {
        if ($this->archiver === null) {
            $this->archiver = new ZipArchiver();
        }

        if ($this->twig === null) {
            $loader     = new \Twig_Loader_Filesystem(self::DEFAULT_TEMPLATE_LOCATION);
            $this->twig = new \Twig_Environment($loader);
        }

        if ($this->slugify === null) {
            $this->slugify = new Slugify();
        }

        return new Generator($this->archiver, $this->twig, $this->slugify);
    }

    /**
     * @param AbstractArchiver $archiver
     *
     * @return Builder
     */
    public function setArchiver(AbstractArchiver $archiver) : self
    {
        $this->archiver = $archiver;

        return $this;
    }

    /**
     * @param \Twig_Environment $twig
     *
     * @return Builder
     */
    public function setTwig(\Twig_Environment $twig) : self
    {
        $this->twig = $twig;

        return $this;
    }
}
