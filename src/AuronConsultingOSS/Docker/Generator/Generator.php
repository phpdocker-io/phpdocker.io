<?php
namespace AuronConsultingOSS\Docker\Generator;

use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;
use AuronConsultingOSS\Docker\Project\Project;
use AuronConsultingOSS\Docker\Zip\Archiver;
use Michelf\MarkdownExtra;

/**
 * Docker environment generator based on a Project.
 *
 * @package   AuronConsultingOSS\Docker
 * @copyright Auron Consulting Ltd
 */
class Generator
{
    const WORKDIR_PATTERN = '/var/www/%s';

    const VM_IP_ADDRESS_PATTERN = '192.168.33.%d';

    const BASE_ZIP_FOLDER = 'phpdocker';

    /**
     * @var Archiver
     */
    protected $zipArchiver;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var MarkdownExtra
     */
    protected $markdownExtra;

    public function __construct(Archiver $archiver, \Twig_Environment $twig, MarkdownExtra $markdownExtra)
    {
        $this->zipArchiver   = $archiver;
        $this->twig          = $twig;
        $this->markdownExtra = $markdownExtra;

        $this->zipArchiver->setBaseFolder(self::BASE_ZIP_FOLDER);
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
        $this->zipArchiver
            ->addFile($this->getReadmeMd($project))
            ->addFile($this->getReadmeHtml($project))
            ->addFile($this->getVagrantFile($project))
            ->addFile($this->getDockerCompose($project))
            ->addFile($this->getPhpDockerConf($project))
            ->addFile($this->getNginxDockerConf($project))
            ->addFile($this->getNginxConf($project));

        return $this->zipArchiver->generateArchive(sprintf('%s.zip', $project->getProjectNameSlug()));
    }

    /**
     * Generates the Readme file in Markdown format.
     *
     * @param Project $project
     *
     * @return GeneratedFile\ReadmeMd
     */
    private function getReadmeMd(Project $project) : GeneratedFile\ReadmeMd
    {
        static $readme;

        if ($readme === null) {
            $data = [
                'webserverPort' => $project->getBasePort(),
                'mailhogPort'   => $project->getBasePort() + 1,
                'vmIpAddress'   => $this->getVmIpAddress(),
            ];

            $readme = new GeneratedFile\ReadmeMd($this->twig->render('README.md.twig', array_merge($data, $this->getHostnameDataBlock($project))));
        }

        return $readme;
    }

    /**
     * Returns the HTML readme, converted off Markdown.
     *
     * @param Project $project
     *
     * @return GeneratedFile\ReadmeHtml
     */
    private function getReadmeHtml(Project $project) : GeneratedFile\ReadmeHtml
    {
        static $readmeHtml;

        if ($readmeHtml === null) {
            $readmeHtml = $this->markdownExtra->transform($this->getReadmeMd($project)->getContents());
        }

        return new GeneratedFile\ReadmeHtml($this->twig->render('README.html.twig', ['text' => $readmeHtml]));
    }

    /**
     * Generates the vagrant file.
     *
     * @param Project $project
     *
     * @return GeneratedFile\Vagrantfile
     */
    private function getVagrantFile(Project $project) : GeneratedFile\Vagrantfile
    {
        $data = [
            'projectName'     => $project->getName(),
            'projectNameSlug' => $project->getProjectNameSlug(),
            'phpDockerFolder' => self::BASE_ZIP_FOLDER,
            'vmIpAddress'     => $this->getVmIpAddress(),
            'mailhog'         => $project->hasMailhog(),
            'mailhogPort'     => $project->getBasePort() + 1,
            'webserverPort'   => $project->getBasePort(),
        ];

        return new GeneratedFile\Vagrantfile($this->twig->render('vagrantfile.twig', $data));
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
     * @return GeneratedFile\DockerCompose
     */
    private function getDockerCompose(Project $project) : GeneratedFile\DockerCompose
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

        return new GeneratedFile\DockerCompose($header . ltrim($rendered));
    }

    /**
     * Returns the docker file for php-fpm.
     *
     * @param Project $project
     *
     * @return GeneratedFile\PhpDockerConf
     */
    private function getPhpDockerConf(Project $project) : GeneratedFile\PhpDockerConf
    {
        $phpOptions = $project->getPhpOptions();
        $packages   = [];

        // Resolve extension packages to install
        foreach ($phpOptions->getExtensions() as $extension) {
            /** @var PhpExtension $extension */
            $packages = array_merge($packages, $extension->getPackages());
        }

        $data = [
            'projectNameSlug'   => $project->getProjectNameSlug(),
            'workdir'           => $this->getWorkdir($project),
            'extensionPackages' => array_unique($packages),
            'isSymfonyApp'      => $phpOptions->isSymfonyApp(),
        ];

        return new GeneratedFile\PhpDockerConf($this->twig->render('dockerfile-php-fpm.conf.twig', $data));
    }

    /**
     * Generates and returns the dockerfile for the webserver.
     *
     * @param Project $project
     *
     * @return GeneratedFile\NginxDockerConf
     */
    private function getNginxDockerConf(Project $project) : GeneratedFile\NginxDockerConf
    {
        $data = [
            'projectName' => $project->getName(),
            'workdir'     => $this->getWorkdir($project),
        ];

        return new GeneratedFile\NginxDockerConf($this->twig->render('dockerfile-nginx.conf.twig', $data));
    }

    /**
     * Generates and returns the nginx.conf file.
     *
     * @param Project $project
     *
     * @return GeneratedFile\NginxConf
     */
    private function getNginxConf(Project $project) : GeneratedFile\NginxConf
    {
        $data = [
            'isSymfonyApp'   => $project->getPhpOptions()->isSymfonyApp(),
            'projectName'    => $project->getName(),
            'workdir'        => $this->getWorkdir($project),
            'phpFpmHostname' => $project->getHostnameForService($project->getPhpOptions()),
        ];

        return new GeneratedFile\NginxConf($this->twig->render('nginx.conf.twig', $data));
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
