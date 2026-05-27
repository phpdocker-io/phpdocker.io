<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\Memcached;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MemcachedTest extends TestCase
{
    #[Test]
    public function getContainerNameSuffixReturnsMemcached(): void
    {
        self::assertSame('memcached', (new Memcached())->getContainerNameSuffix());
    }

    #[Test]
    public function isDisabledByDefaultAndCanBeEnabled(): void
    {
        $memcached = new Memcached();

        self::assertFalse($memcached->isEnabled());

        $memcached->setEnabled(true);

        self::assertTrue($memcached->isEnabled());
    }

    #[Test]
    public function getExternalPortReturnsNullAsNoOffsetDefined(): void
    {
        self::assertNull((new Memcached())->getExternalPort(8000));
    }
}
