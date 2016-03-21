<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

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
        return 'docker' . DIRECTORY_SEPARATOR . 'Dockerfile.php-fpm.conf';
    }
}
