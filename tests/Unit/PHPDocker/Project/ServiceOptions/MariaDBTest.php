<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\MariaDB;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class MariaDBTest extends TestCase
{
    #[Test]
    public function defaultVersionIs110(): void
    {
        $mariadb = new MariaDB();
        self::assertSame('11.0', $mariadb->getVersion());
    }

    #[Test]
    public function setVersionTo104Succeeds(): void
    {
        $mariadb = new MariaDB();
        $mariadb->setVersion('10.4');
        self::assertSame('10.4', $mariadb->getVersion());
    }

    #[Test]
    public function setVersionWithInvalidVersionThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new MariaDB())->setVersion('invalid');
    }

    #[Test]
    public function getExternalPortReturnsBasePortPlusOffset3(): void
    {
        $mariadb = new MariaDB();
        self::assertSame(10003, $mariadb->getExternalPort(10000));
    }

    #[Test]
    public function getChoicesContainsAllExpectedVersions(): void
    {
        $choices = MariaDB::getChoices();
        self::assertArrayHasKey('11.0', $choices);
        self::assertArrayHasKey('10.11', $choices);
        self::assertArrayHasKey('10.10', $choices);
        self::assertArrayHasKey('10.9', $choices);
        self::assertArrayHasKey('10.8', $choices);
        self::assertArrayHasKey('10.7', $choices);
        self::assertArrayHasKey('10.6', $choices);
        self::assertArrayHasKey('10.5', $choices);
        self::assertArrayHasKey('10.4', $choices);
    }
}
