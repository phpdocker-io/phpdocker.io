<?php
namespace AuronConsultingOSS\Docker\Generator;

use AuronConsultingOSS\Docker\Archiver\OldZipArchiver;
use AuronConsultingOSS\Docker\Archiver\ZipArchiver;
use Michelf\MarkdownExtra;

/**
 * Factory for generator. If not provided, it will spawn and inject default dependencies.
 *
 * @package   AuronConsultingOSS\Docker\Generator
 * @copyright Auron Consulting Ltd
 */
class Factory
{
    /**
     * Location for
     */
    const DEFAULT_TEMPLATE_LOCATION = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Template';

    /**
     * Builds and returns a Generator. Will spawn all dependencies also, if not already supplied by consumer.
     *
     * @param ZipArchiver       $zipArchiver
     * @param \Twig_Environment $twig
     * @param MarkdownExtra     $markdownExtra
     *
     * @return Generator
     */
    public static function create(ZipArchiver $zipArchiver = null, \Twig_Environment $twig = null, MarkdownExtra $markdownExtra = null) : Generator
    {
        if ($zipArchiver === null) {
            $zipArchiver = new ZipArchiver();
        }

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(self::DEFAULT_TEMPLATE_LOCATION);
            $twig   = new \Twig_Environment($loader);
        }

        if ($markdownExtra === null) {
            $markdownExtra = new MarkdownExtra();
        }

        return new Generator($zipArchiver, $twig, $markdownExtra);
    }
}
