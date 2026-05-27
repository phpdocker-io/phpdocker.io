<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\MySQL;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MySQLTest extends TestCase
{
    #[Test]
    public function defaultVersionIs80(): void
    {
        $mysql = new MySQL();
        self::assertSame('8.0', $mysql->getVersion());
    }

    #[Test]
    public function constructorWithVersion57Succeeds(): void
    {
        $mysql = new MySQL(version: '5.7');
        self::assertSame('5.7', $mysql->getVersion());
    }

    #[Test]
    public function constructorWithVersion56Succeeds(): void
    {
        $mysql = new MySQL(version: '5.6');
        self::assertSame('5.6', $mysql->getVersion());
    }

    #[Test]
    public function constructorWithVersion55Succeeds(): void
    {
        $mysql = new MySQL(version: '5.5');
        self::assertSame('5.5', $mysql->getVersion());
    }

    #[Test]
    public function constructorWithInvalidVersionThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new MySQL(version: 'invalid');
    }

    #[Test]
    public function getExternalPortReturnsBasePortPlusOffset2(): void
    {
        $mysql = new MySQL();
        self::assertSame(10002, $mysql->getExternalPort(10000));
    }

    #[Test]
    public function getChoicesContainsAllExpectedVersions(): void
    {
        $choices = MySQL::getChoices();
        self::assertArrayHasKey('8.0', $choices);
        self::assertArrayHasKey('5.7', $choices);
        self::assertArrayHasKey('5.6', $choices);
        self::assertArrayHasKey('5.5', $choices);
    }
}
