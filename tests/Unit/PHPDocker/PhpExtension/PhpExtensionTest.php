<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\PhpExtension;

use App\PHPDocker\PhpExtension\PhpExtension;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class PhpExtensionTest extends TestCase
{
    #[Test]
    public function itIsAFinalReadonlyValueObject(): void
    {
        $reflection = new ReflectionClass(PhpExtension::class);

        self::assertTrue($reflection->isFinal());
        self::assertTrue($reflection->isReadOnly());
    }

    #[Test]
    public function itExposesNameAndPackagesFromConstructor(): void
    {
        $extension = new PhpExtension('Xdebug', ['php8.4-xdebug']);

        self::assertSame('Xdebug', $extension->getName());
        self::assertSame(['php8.4-xdebug'], $extension->getPackages());
    }
}
