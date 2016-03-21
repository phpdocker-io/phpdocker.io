<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

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
        return 'docker' . DIRECTORY_SEPARATOR . 'Dockerfile.nginx.conf';
    }
}
