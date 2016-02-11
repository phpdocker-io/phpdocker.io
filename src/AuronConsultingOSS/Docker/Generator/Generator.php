<?php
namespace AuronConsultingOSS\Docker\Generator;

use AuronConsultingOSS\Docker\Archiver\AbstractArchiver;
use AuronConsultingOSS\Docker\Entity\Project;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;
use AuronConsultingOSS\Docker\PhpExtension\AvailableExtensions;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;
use Michelf\MarkdownExtra;

/**
 * Generator
 *
 * @package   AuronConsultingOSS\Docker
 * @copyright Auron Consulting Ltd
 */
class Generator
{
    const WORKDIR_PATTERN = '/var/www/%s';

    const VM_IP_ADDRESS_PATTERN = '192.168.33.%d';

    /**
     * @var AbstractArchiver
     */
    protected $archiver;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var MarkdownExtra
     */
    protected $markdownExtra;

    public function __construct(AbstractArchiver $archiver, \Twig_Environment $twig, MarkdownExtra $markdownExtra)
    {
        $this->archiver      = $archiver;
        $this->twig          = $twig;
        $this->markdownExtra = $markdownExtra;
    }

    /**
     * Generates all the files from the Project, and returns as an archive file.
     *
     * @param Project $project
     *
     * @return ArchiveInterface
     */
    public function generate(Project $project) : ArchiveInterface
    {
        $this->archiver
            ->setReadme($this->getReadme($project))
            ->setReadmeHtml($this->getReadmeHtml($project))
            ->setVagrantFile($this->getVagrantFile($project))
            ->setDockerCompose($this->getDockerCompose($project))
            ->setPhpDockerConf($this->getPhpDockerConf($project))
            ->setNginxDockerConf($this->getNginxDockerConf($project))
            ->setNginxConf($this->getNginxConf($project));

        return $this->archiver->getArchive($project->getProjectNameSlug());
    }

    /**
     * Generates the Readme file.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getReadme(Project $project) : string
    {
        static $readme;

        if ($readme === null) {
            $data = [
                'webserverPort' => $project->getBasePort(),
                'mailhogPort'   => $project->getBasePort() + 1,
                'vmIpAddress'   => $this->getVmIpAddress(),
            ];

            $readme = $this->twig->render('README.md.twig', array_merge($data, $this->getHostnameDataBlock($project)));
        }

        return $readme;
    }

    /**
     * Returns the HTML readme.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getReadmeHtml(Project $project) : string
    {
        static $readmeHtml;

        if ($readmeHtml === null) {
            $readme = $this->getReadme($project);

            // CONVERT TO HTML
            $readmeHtml = $this->markdownExtra->transform($readme);
        }

        return $this->twig->render('README.html.twig', ['text' => $readmeHtml]);;
    }

    /**
     * Generates the vagrant file, and returns as a string of its contents.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getVagrantFile(Project $project) : string
    {
        $data = [
            'projectName'     => $project->getName(),
            'projectNameSlug' => $project->getProjectNameSlug(),
            'phpDockerFolder' => AbstractArchiver::BASE_FOLDER_NAME,
            'vmIpAddress'     => $this->getVmIpAddress(),
        ];

        return $this->twig->render('vagrantfile.twig', $data);
    }

    /**
     * Works out the workdir based on the Project.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getWorkdir(Project $project)
    {
        static $workdir;

        if ($workdir === null) {
            $workdir = sprintf(self::WORKDIR_PATTERN, $project->getProjectNameSlug());
        }

        return $workdir;
    }

    /**
     * Generates the docker-compose file, and returns as a string of its contents.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getDockerCompose(Project $project) : string
    {
        $data = [
            'projectName'     => $project->getName(),
            'projectNameSlug' => $project->getProjectNameSlug(),
            'workdir'         => $this->getWorkdir($project),
            'mailhog'         => $project->hasMailhog(),
            'mailhogPort'     => $project->getBasePort() + 1,
            'webserverPort'   => $project->getBasePort(),
            'memcached'       => $project->hasMemcached(),
            'redis'           => $project->hasRedis(),
            'mysql'           => $project->getMysqlOptions(),
        ];

        // Get hostnames
        $data = array_merge($data, $this->getHostnameDataBlock($project));

        // Render and return
        $header   = $this->twig->render('docker-compose-header.twig');
        $rendered = $this->twig->render('docker-compose.yml.twig', $data);

        return $header . ltrim($rendered);
    }

    /**
     * Returns the docker file for php-fpm.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getPhpDockerConf(Project $project) : string
    {
        $phpOptions  = $project->getPhpOptions();
        $packages    = [];

        // Extensions to add
        $extensions = array_merge(
            AvailableExtensions::getMandatoryPhpExtensions(),
            $phpOptions->getExtensions()
        );

        foreach ($extensions as $extension) {
            /** @var PhpExtension $extension */
            $packages = array_merge($packages, $extension->getPackages());
        }

        $packages = array_unique($packages);


        dump($packages);
        $data = [
            'projectNameSlug'   => $project->getProjectNameSlug(),
            'workdir'           => $this->getWorkdir($project),
            'extensionPackages' => $packages,
            'isSymfonyApp'      => $phpOptions->isSymfonyApp(),
        ];

        return $this->twig->render('dockerfile-php-fpm.conf.twig', $data);
    }

    /**
     * Generates and returns the dockerfile for the webserver.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getNginxDockerConf(Project $project) : string
    {
        $data = [
            'projectName' => $project->getName(),
            'workdir'     => $this->getWorkdir($project),
        ];

        return $this->twig->render('dockerfile-nginx.conf.twig', $data);
    }

    /**
     * Generates and returns the nginx.conf file.
     *
     * @param Project $project
     *
     * @return string
     */
    private function getNginxConf(Project $project) : string
    {
        $data = [
            'isSymfonyApp'   => $project->getPhpOptions()->isSymfonyApp(),
            'projectName'    => $project->getName(),
            'workdir'        => $this->getWorkdir($project),
            'phpFpmHostname' => $project->getHostnameForService($project->getPhpOptions()),
        ];

        return $this->twig->render('nginx.conf.twig', $data);
    }

    /**
     * Returns a data block with hostnames for all configured services.
     *
     * @param Project $project
     *
     * @return array
     */
    private function getHostnameDataBlock(Project $project)
    {
        static $hostnameDataBlock = [];

        if (count($hostnameDataBlock) === 0) {
            $hostnameDataBlock = [
                'webserverHostname' => $project->getHostnameForService($project->getNginxOptions()),
                'phpFpmHostname'    => $project->getHostnameForService($project->getPhpOptions()),
                'mysqlHostname'     => $project->hasMysql() ? $project->getHostnameForService($project->getMysqlOptions()) : null,
                'memcachedHostname' => $project->hasMemcached() ? $project->getHostnameForService($project->getMemcachedOptions()) : null,
                'redisHostname'     => $project->hasRedis() ? $project->getHostnameForService($project->getRedisOptions()) : null,
                'mailhogHostname'   => $project->hasMailhog() ? $project->getHostnameForService($project->getMailhogOptions()) : null,
            ];
        }

        return $hostnameDataBlock;
    }

    /**
     * Calculates a random IP address based on a pattern.
     *
     * @return string
     */
    private function getVmIpAddress() : string
    {
        static $vmIpAddress;

        if ($vmIpAddress === null) {
            $vmIpAddress = sprintf(self::VM_IP_ADDRESS_PATTERN, random_int(1, 255));
        }

        return $vmIpAddress;
    }
}
