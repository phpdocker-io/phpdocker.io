<?php
namespace AuronConsultingOSS\Docker\PhpExtension;

/**
 * Factory to specific PHP extensions list based on php version.
 *
 * @package   AuronConsultingOSS\Docker\PhpExtension
 * @copyright Auron Consulting Ltd
 */
class AvailableExtensionsFactory
{
    /**
     * PHP 7.0.x
     */
    const PHP_VERSION_70 = '7.0.x';

    /**
     * PHP 5.6.x
     */
    const PHP_VERSION_56 = '5.6.x';

    /**
     * Supported PHP versions
     */
    const SUPPORTED_VERSIONS = [
        self::PHP_VERSION_56 => Php56AvailableExtensions::class,
        self::PHP_VERSION_70 => Php70AvailableExtensions::class,
    ];

    /**
     * Returns an instance to the appropriate class for extensions for a given php version.
     *
     * @param string $phpVersion
     *
     * @return mixed
     */
    public static function create(string $phpVersion)
    {
        if (array_key_exists($phpVersion, self::SUPPORTED_VERSIONS) === false) {
            throw new \InvalidArgumentException(sprintf('PHP version specified (%s) is unsupported', $phpVersion));
        }

        $className = self::SUPPORTED_VERSIONS[$phpVersion];

        return $className::create();
    }
}
