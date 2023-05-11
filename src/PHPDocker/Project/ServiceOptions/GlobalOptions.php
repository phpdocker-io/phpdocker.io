<?php
declare(strict_types=1);

namespace App\PHPDocker\Project\ServiceOptions;

final class GlobalOptions extends Base
{

    public function __construct(private readonly int $basePort, private readonly string $appPath, private readonly string $dockerWorkingDir)
    {
    }

    public function getBasePort(): int
    {
        return $this->basePort;
    }

    public function getAppPath(): ?string
    {
        return $this->appPath;
    }

    public function getDockerWorkingDir(): ?string
    {
        return $this->dockerWorkingDir;
    }
}
