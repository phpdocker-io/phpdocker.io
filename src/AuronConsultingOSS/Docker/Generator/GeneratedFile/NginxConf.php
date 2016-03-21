<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

/**
 * nginx.conf file
 *
 * @package   AuronConsultingOSS\Docker\Generator\GeneratedFile
 * @copyright Auron Consulting Ltd
 */
class NginxConf extends Base
{
    /**
     * @inheritdoc
     */
    public function getFilename() : string
    {
        return 'docker' . DIRECTORY_SEPARATOR . 'nginx.conf';
    }
}
