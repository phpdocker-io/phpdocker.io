<?php
declare(strict_types=1);

namespace App\PHPDocker\Project\ServiceOptions;

final class WorkingDir extends Base
{

    public function __construct(private string $localWorkingDir, private string $dockerWorkingDir)
    {
    }

    public function getLocalWorkingDir(): ?string
    {
        return $this->localWorkingDir;
    }

    public function setLocalWorkingDir(string $localWorkingDir = '.'): self
    {
        $this->localWorkingDir = $localWorkingDir;

        return $this;
    }

    public function getDockerWorkingDir(): ?string
    {
        return $this->dockerWorkingDir;
    }

    public function setDockerWorkingDir(string $dockerWorkingDir = '/application'): self
    {
        $this->dockerWorkingDir = $dockerWorkingDir;

        return $this;
    }
}
