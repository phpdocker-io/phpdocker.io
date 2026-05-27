<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\Base;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{
    private Base $service;

    protected function setUp(): void
    {
        $this->service = new class extends Base {};
    }

    #[Test]
    public function isEnabledReturnsFalseByDefault(): void
    {
        self::assertFalse($this->service->isEnabled());
    }

    #[Test]
    public function constructorWithEnabledTrueReturnsTrue(): void
    {
        $service = new class(true) extends Base {};

        self::assertTrue($service->isEnabled());
    }

    #[Test]
    public function getExternalPortReturnsNullWhenNoOffset(): void
    {
        self::assertNull($this->service->getExternalPort(10000));
    }
}
