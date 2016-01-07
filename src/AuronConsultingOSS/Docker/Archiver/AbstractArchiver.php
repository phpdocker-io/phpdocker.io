<?php
namespace AuronConsultingOSS\Docker\Archive;

use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;

/**
 * File archiver, contains the basic file structure to create.
 *
 * @package   AuronConsultingOSS\Docker\Archive
 * @copyright Auron Consulting Ltd
 */
abstract class AbstractArchiver
{
    /**
     * File folders
     */
    const BASE_FOLDER_NAME             = 'phpdocker';
    const FILENAME_DOCKER_COMPOSE      = 'docker-compose.yml';
    const FILENAME_VAGRANT_FILE        = 'vagrant' . PATH_SEPARATOR . 'Vagrantfile';
    const FILENAME_PHP_FPM_DOCKER_CONF = 'docker' . PATH_SEPARATOR . '/Dockerfile.php-fpm.conf';
    const FILENAME_NGINX_DOCKER_CONF   = 'docker' . PATH_SEPARATOR . '/Dockerfile.nginx.conf';
    const FILENAME_NGINX_CONF          = 'docker' . PATH_SEPARATOR . '/nginx.conf';

    /**
     * @var string
     */
    protected $dockerCompose;

    /**
     * @var string
     */
    protected $vagrantFile;

    /**
     * @var string
     */
    protected $nginxDockerConf;

    /**
     * @var string
     */
    protected $phpDockerConf;

    /**
     * @var string
     */
    protected $nginxConf;

    /**
     * @var ArchiveInterface
     */
    protected $archive;

    /**
     * Adds a file to the archive.
     *
     * @param string $filename
     * @param string $contents
     *
     * @return AbstractArchiver
     */
    abstract protected function addFile(string $filename, string $contents) : self;

    /**
     * Actually generate and return archive.
     *
     * @return ArchiveInterface
     */
    abstract protected function generateArchive() : ArchiveInterface;

    /**
     * Adds all the files to the archive and returns.
     *
     * @return ArchiveInterface
     */
    public function getArchive() : ArchiveInterface
    {
        if ($this->archive === null) {
            $files = [
                self::FILENAME_DOCKER_COMPOSE      => $this->getDockerCompose(),
                self::FILENAME_PHP_FPM_DOCKER_CONF => $this->getPhpDockerConf(),
                self::FILENAME_NGINX_DOCKER_CONF   => $this->getNginxDockerConf(),
                self::FILENAME_NGINX_CONF          => $this->getNginxConf(),
                self::FILENAME_VAGRANT_FILE        => $this->getVagrantFile(),
            ];

            foreach ($files as $filename => $contents) {
                $this->addFile($this->prefixFilename($filename), $contents);
            }

            $this->archive = $this->generateArchive();
        }

        return $this->archive;
    }

    /**
     * Prefixes a filename with the base folder.
     *
     * @param string $filename
     *
     * @return string
     */
    private function prefixFilename(string $filename) : string
    {
        return sprintf('%s%s%s', self::BASE_FOLDER_NAME, PATH_SEPARATOR, $filename);
    }

    /**
     * @return string
     */
    public function getDockerCompose() : string
    {
        return $this->dockerCompose;
    }

    /**
     * @param string $dockerCompose
     *
     * @return AbstractArchiver
     */
    public function setDockerCompose(string $dockerCompose) : self
    {
        $this->dockerCompose = $dockerCompose;

        return $this;
    }

    /**
     * @return string
     */
    public function getVagrantFile() : string
    {
        return $this->vagrantFile;
    }

    /**
     * @param string $vagrantFile
     *
     * @return AbstractArchiver
     */
    public function setVagrantFile(string $vagrantFile) : self
    {
        $this->vagrantFile = $vagrantFile;

        return $this;
    }

    /**
     * @return string
     */
    public function getNginxDockerConf() : string
    {
        return $this->nginxDockerConf;
    }

    /**
     * @param string $nginxDockerConf
     *
     * @return AbstractArchiver
     */
    public function setNginxDockerConf(string $nginxDockerConf) : self
    {
        $this->nginxDockerConf = $nginxDockerConf;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhpDockerConf() : string
    {
        return $this->phpDockerConf;
    }

    /**
     * @param string $phpDockerConf
     *
     * @return AbstractArchiver
     */
    public function setPhpDockerConf(string $phpDockerConf) : self
    {
        $this->phpDockerConf = $phpDockerConf;

        return $this;
    }

    /**
     * @return string
     */
    public function getNginxConf() : string
    {
        return $this->nginxConf;
    }

    /**
     * @param string $nginxConf
     *
     * @return AbstractArchiver
     */
    public function setNginxConf(string $nginxConf) : self
    {
        $this->nginxConf = $nginxConf;

        return $this;
    }
}
