<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

use AuronConsultingOSS\Docker\Interfaces\string;

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
        return DIRECTORY_SEPARATOR . 'nginx.conf';
    }
}
