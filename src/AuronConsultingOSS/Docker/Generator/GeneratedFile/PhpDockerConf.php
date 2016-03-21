<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

use AuronConsultingOSS\Docker\Interfaces\string;

/**
 * PHP docker config
 *
 * @package   AuronConsultingOSS\Docker\Generator\GeneratedFile
 * @copyright Auron Consulting Ltd
 */
class PhpDockerConf extends Base
{
    /**
     * @inheritdoc
     */
    public function getFilename() : string
    {
        return DIRECTORY_SEPARATOR . 'Dockerfile.php-fpm.conf';
    }
}
