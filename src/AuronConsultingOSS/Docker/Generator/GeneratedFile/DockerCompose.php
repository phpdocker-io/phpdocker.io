<?php
namespace AuronConsultingOSS\Docker\Generator\GeneratedFile;

use AuronConsultingOSS\Docker\Interfaces\string;

/**
 * Docker compose file.
 *
 * @package   AuronConsultingOSS\Docker\Generator\GeneratedFile
 * @copyright Auron Consulting Ltd
 */
class DockerCompose extends Base
{
    /**
     * @inheritdoc
     */
    public function getFilename() : string
    {
        return 'docker-compose.yml';
    }
}
