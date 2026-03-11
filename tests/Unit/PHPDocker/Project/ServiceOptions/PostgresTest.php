<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\Postgres;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PostgresTest extends TestCase
{
    #[Test]
    public function defaultVersionIs15(): void
    {
        $postgres = new Postgres();
        self::assertSame('15', $postgres->getVersion());
    }

    #[Test]
    public function setVersionTo96Succeeds(): void
    {
        $postgres = new Postgres();
        $postgres->setVersion('9.6');
        self::assertSame('9.6', $postgres->getVersion());
    }

    #[Test]
    public function setVersionWithInvalidVersionThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Postgres())->setVersion('invalid');
    }

    #[Test]
    public function getExternalPortReturnsBasePortPlusOffset4(): void
    {
        $postgres = new Postgres();
        self::assertSame(10004, $postgres->getExternalPort(10000));
    }

    #[Test]
    public function getChoicesContainsAllExpectedVersions(): void
    {
        $choices = Postgres::getChoices();
        self::assertArrayHasKey('15', $choices);
        self::assertArrayHasKey('14', $choices);
        self::assertArrayHasKey('13', $choices);
        self::assertArrayHasKey('12', $choices);
        self::assertArrayHasKey('11', $choices);
        self::assertArrayHasKey('10', $choices);
        self::assertArrayHasKey('9.6', $choices);
    }
}
