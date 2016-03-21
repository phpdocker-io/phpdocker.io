<?php
namespace AuronConsultingOSS\Docker\Project;

use Cocur\Slugify\Slugify;

/**
 * Factory to create projects.
 *
 * @package   AuronConsultingOSS\Docker\Entity
 * @copyright Auron Consulting Ltd
 */
class Factory
{
    /**
     * Creates a new project. You can supply a pre-made Project (for instance if you already have one handy, like
     * a children implementation), or if not a new, base Project is created.
     *
     * @param Project|null $project
     * @param Slugify|null $slugify
     *
     * @return Project
     */
    public static function create(Project $project = null, Slugify $slugify = null) : Project
    {
        if ($slugify === null) {
            $slugify = new Slugify();
        }

        if ($project === null) {
            $project = new Project();
        }

        $project->setSlugifier($slugify);

        return $project;
    }
}
