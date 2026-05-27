<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\PhpExtension;

use App\PHPDocker\PhpExtension\Exception\NotFoundException;
use App\PHPDocker\PhpExtension\Php84AvailableExtensions;
use App\PHPDocker\PhpExtension\PhpExtension;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BaseAvailableExtensionsTest extends TestCase
{
    private Php84AvailableExtensions $extensions;

    protected function setUp(): void
    {
        $this->extensions = new Php84AvailableExtensions();
    }

    #[Test]
    public function getAllReturnsPhpExtensionInstancesIndexedByName(): void
    {
        $all = $this->extensions->getAll();

        self::assertNotEmpty($all);
        self::assertArrayHasKey('Xdebug', $all);
        self::assertContainsOnlyInstancesOf(PhpExtension::class, $all);
        self::assertSame('Xdebug', $all['Xdebug']->getName());
        self::assertContains('php8.4-xdebug', $all['Xdebug']->getPackages());
    }

    #[Test]
    public function getAllIsIdempotent(): void
    {
        $first  = $this->extensions->getAll();
        $second = $this->extensions->getAll();
        self::assertSame($first, $second);
    }

    #[Test]
    public function isAvailableReturnsTrueForKnownExtension(): void
    {
        self::assertTrue($this->extensions->isAvailable('Xdebug'));
    }

    #[Test]
    public function isAvailableReturnsFalseForUnknownExtension(): void
    {
        self::assertFalse($this->extensions->isAvailable('nonexistent-ext'));
    }

    #[Test]
    public function getPhpExtensionReturnsCorrectExtension(): void
    {
        $ext = $this->extensions->getPhpExtension('Xdebug');

        self::assertInstanceOf(PhpExtension::class, $ext);
        self::assertSame('Xdebug', $ext->getName());
        self::assertContains('php8.4-xdebug', $ext->getPackages());
    }

    #[Test]
    public function getPhpExtensionThrowsForUnknownExtension(): void
    {
        $this->expectException(NotFoundException::class);
        $this->extensions->getPhpExtension('nonexistent-ext');
    }

    #[Test]
    public function getOptionalReturnsArrayOfPhpExtensionObjects(): void
    {
        $optional = $this->extensions->getOptional();

        self::assertNotEmpty($optional);
        foreach ($optional as $ext) {
            self::assertInstanceOf(PhpExtension::class, $ext);
        }
    }
}
