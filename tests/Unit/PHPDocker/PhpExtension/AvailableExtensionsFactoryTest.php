<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\PhpExtension;

use App\PHPDocker\PhpExtension\AvailableExtensionsFactory;
use App\PHPDocker\PhpExtension\Php82AvailableExtensions;
use App\PHPDocker\PhpExtension\Php83AvailableExtensions;
use App\PHPDocker\PhpExtension\Php84AvailableExtensions;
use App\PHPDocker\PhpExtension\Php85AvailableExtensions;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AvailableExtensionsFactoryTest extends TestCase
{
    #[Test]
    public function createReturnsPhp82InstanceForVersion82(): void
    {
        self::assertInstanceOf(Php82AvailableExtensions::class, AvailableExtensionsFactory::create('8.2'));
    }

    #[Test]
    public function createReturnsPhp83InstanceForVersion83(): void
    {
        self::assertInstanceOf(Php83AvailableExtensions::class, AvailableExtensionsFactory::create('8.3'));
    }

    #[Test]
    public function createReturnsPhp84InstanceForVersion84(): void
    {
        self::assertInstanceOf(Php84AvailableExtensions::class, AvailableExtensionsFactory::create('8.4'));
    }

    #[Test]
    public function createReturnsPhp85InstanceForVersion85(): void
    {
        self::assertInstanceOf(Php85AvailableExtensions::class, AvailableExtensionsFactory::create('8.5'));
    }

    #[Test]
    public function createThrowsForUnsupportedVersion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        AvailableExtensionsFactory::create('7.4');
    }

    #[Test]
    public function createThrowsForEmptyVersion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        AvailableExtensionsFactory::create('');
    }
}
