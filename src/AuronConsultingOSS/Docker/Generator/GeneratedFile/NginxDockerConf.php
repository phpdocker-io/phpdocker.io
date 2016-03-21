<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

use AuronConsultingOSS\Docker\Interfaces\string;

/**
 * Docker conf for nginx
 *
 * @package   AuronConsultingOSS\Docker\Generator\GeneratedFile
 * @copyright Auron Consulting Ltd
 */
class NginxDockerConf extends Base
{
    /**
     * @inheritdoc
     */
    public function getFilename() : string
    {
        return DIRECTORY_SEPARATOR . 'Dockerfile.nginx.conf';
    }
}
