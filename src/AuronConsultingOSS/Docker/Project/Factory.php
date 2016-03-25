<?php
namespace AuronConsultingOSS\Docker\Project;

use AuronConsultingOSS\Docker\Interfaces\SlugifierInterface;

/**
 * Factory to create projects.
 *
 * @package AuronConsultingOSS\Docker\Entity
 * @author  Luis A. Pabon Flores
 */
class Factory
{
    /**
     * Creates a new project. You can supply a pre-made Project (for instance if you already have one handy, like
     * a children implementation), or if not a new, base Project is created.
     *
     * @param SlugifierInterface $slugifier
     * @param Project|null       $project
     *
     * @return Project
     */
    public static function create(SlugifierInterface $slugifier, Project $project = null) : Project
    {
        if ($project === null) {
            $project = new Project();
        }

        $project->setSlugifier($slugifier);

        return $project;
    }
}
