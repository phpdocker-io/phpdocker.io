<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\PhpExtension\Exception\NotFoundException;
use App\PHPDocker\Project\ServiceOptions\Php;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PhpTest extends TestCase
{
    #[Test]
    public function constructorWithValidVersionSetsVersionAndEnablesService(): void
    {
        $php = new Php('8.4', [], false, 'public/index.php');
        self::assertSame('8.4', $php->getVersion());
        self::assertTrue($php->isEnabled());
    }

    #[Test]
    public function constructorWithHasGitTrueReturnsTrue(): void
    {
        $php = new Php('8.4', [], true, 'public/index.php');
        self::assertTrue($php->hasGit());
    }

    #[Test]
    public function constructorWithHasGitFalseReturnsFalse(): void
    {
        $php = new Php('8.4', [], false, 'public/index.php');
        self::assertFalse($php->hasGit());
    }

    #[Test]
    public function constructorWithKnownExtensionNameAddsExtension(): void
    {
        $php = new Php('8.4', ['Xdebug'], false, 'public/index.php');
        $extensions = $php->getExtensions();
        self::assertCount(1, $extensions);
        self::assertSame('Xdebug', $extensions[0]->getName());
    }

    #[Test]
    public function constructorWithUnknownExtensionNameThrowsNotFoundException(): void
    {
        $this->expectException(NotFoundException::class);
        new Php('8.4', ['nonexistent-ext'], false, 'public/index.php');
    }

    #[Test]
    public function constructorWithUnsupportedVersionThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Php('7.4', [], false, 'public/index.php');
    }

    #[Test]
    public function getSupportedVersionsContainsAllSupportedVersions(): void
    {
        $versions = Php::getSupportedVersions();
        self::assertContains('8.2', $versions);
        self::assertContains('8.3', $versions);
        self::assertContains('8.4', $versions);
        self::assertContains('8.5', $versions);
    }

    #[Test]
    public function getFrontControllerPathReturnsConstructorValue(): void
    {
        $php = new Php('8.4', [], false, 'public/index.php');
        self::assertSame('public/index.php', $php->getFrontControllerPath());
    }
}
