<?php
namespace AuronConsultingOSS\Docker\Entity;

class Project
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var NginxOptions
     */
    protected $nginxOptions;

    /**
     * @var MySQLOptions
     */
    protected $mysqlOptions;

    /**
     * @var PhpOptions
     */
    protected $phpOptions;

    /**
     * @var MemcachedOptions
     */
    protected $memcachedOptions;
}
