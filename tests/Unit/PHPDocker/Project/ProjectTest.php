<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project;

use App\PHPDocker\Project\Project;
use App\PHPDocker\Project\ServiceOptions\Elasticsearch;
use App\PHPDocker\Project\ServiceOptions\GlobalOptions;
use App\PHPDocker\Project\ServiceOptions\Nginx;
use App\PHPDocker\Project\ServiceOptions\Php;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ProjectTest extends TestCase
{
    #[Test]
    public function nginxOptionsArePresentAndEnabledByDefault(): void
    {
        $project = $this->createProject();

        self::assertTrue($project->hasNginx());
        self::assertInstanceOf(Nginx::class, $project->getNginxOptions());
        self::assertTrue($project->getNginxOptions()->isEnabled());
    }

    #[Test]
    public function elasticsearchOptionsArePresentDisabledByDefaultAndReflectEnabledState(): void
    {
        $project = $this->createProject();

        self::assertFalse($project->hasElasticsearch());
        self::assertInstanceOf(Elasticsearch::class, $project->getElasticsearchOptions());

        $project = $this->createProject(
            elasticsearchOptions: new Elasticsearch(enabled: true),
        );

        self::assertTrue($project->hasElasticsearch());
    }

    private function createProject(?Elasticsearch $elasticsearchOptions = null): Project
    {
        return new Project(
            new Php('8.4', [], false, 'index.php'),
            new GlobalOptions(8000, './', '/application'),
            nginxOptions: new Nginx(),
            elasticsearchOptions: $elasticsearchOptions,
        );
    }
}
