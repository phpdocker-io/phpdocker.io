<?php
namespace AuronConsultingOSS\Docker;

use AuronConsultingOSS\Docker\Archive\AbstractArchiver;
use AuronConsultingOSS\Docker\Entity\Project;
use AuronConsultingOSS\Docker\Interfaces\ArchiveInterface;
use AuronConsultingOSS\Docker\PhpExtension\PhpExtension;
use Cocur\Slugify\Slugify;

/**
 * Generator
 *
 * @package   AuronConsultingOSS\Docker
 * @copyright Auron Consulting Ltd
 */
class Generator
{
    const WORKDIR_PATTERN = '/var/www/%s';

    /**
     * @var AbstractArchiver
     */
    protected $archiver;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var Slugify
     */
    protected $slugify;

    public function __construct(AbstractArchiver $archiver, \Twig_Environment $twig, Slugify $slugify)
    {
        $this->archiver = $archiver;
        $this->twig     = $twig;
        $this->slugify  = $slugify;
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
            ->setVagrantFile($this->getVagrantFile($project))
            ->setDockerCompose($this->getDockerCompose($project))
            ->setPhpDockerConf($this->getPhpDockerConf($project))
            ->setNginxDockerConf($this->getNginxDockerConf($project))
            ->setNginxConf($this->getNginxConf($project));

        return $this->archiver->getArchive();
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
            'projectNameSlug' => $this->getProjectNameSlug($project),
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
            $workdir = sprintf(self::WORKDIR_PATTERN, $project->getName());
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
            'projectNameSlug' => $this->getProjectNameSlug($project),
            'workdir'         => $this->getWorkdir($project),
            'mailcatcher'     => $project->hasMailcatcher(),
            'mailcatcherPort' => $project->getBasePort() + 1,
            'webserverPort'   => $project->getBasePort(),
            'memcached'       => $project->hasMemcached(),
            'mysql'           => $project->getMysqlOptions(),
        ];

        return $this->twig->render('docker-compose.yml.twig', $data);
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
        $phpOptions    = $project->getPhpOptions();
        $dependencies  = [];
        $customDists   = [];
        $stdExtensions = [];

        foreach ($phpOptions->getExtensions() as $extension) {
            /** @var PhpExtension $extension */
            $dependencies += $extension->getDependencies();

            $customDist = $extension->getCustomDist();
            if ($customDist !== null) {
                $customDists[] = $customDist;
            } else {
                $stdExtensions[] = $extension->getName();
            }
        }

        $data = [
            'projectName'   => $project->getName(),
            'workdir'       => $this->getWorkdir($project),
            'dependencies'  => $dependencies,
            'customDists'   => $customDists,
            'stdExtensions' => $stdExtensions,
            'isSymfonyApp'  => $phpOptions->isSymfonyApp(),
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
            'isSymfonyApp' => $project->getPhpOptions()->isSymfonyApp(),
            'projectName'  => $project->getName(),
            'workdir'      => $this->getWorkdir($project),
        ];

        return $this->twig->render('nginx.conf.twig', $data);
    }

    /**
     * Returns a
     *
     * @param Project $project
     *
     * @return string
     */
    private function getProjectNameSlug(Project $project) : string
    {
        static $slug;

        if ($slug === null) {
            $slug = $this->slugify->slugify($project->getName());
        }

        return $slug;
    }
}
