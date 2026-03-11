<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Project\ServiceOptions;

use App\PHPDocker\Project\ServiceOptions\Elasticsearch;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ElasticsearchTest extends TestCase
{
    #[Test]
    public function defaultVersionIs654(): void
    {
        $es = new Elasticsearch();
        self::assertSame('6.5.4', $es->getVersion());
    }

    #[Test]
    public function setVersionTo56Succeeds(): void
    {
        $es = new Elasticsearch();
        $es->setVersion('5.6');
        self::assertSame('5.6', $es->getVersion());
    }

    #[Test]
    public function setVersionWithInvalidVersionThrowsInvalidArgumentException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        (new Elasticsearch())->setVersion('invalid');
    }

    #[Test]
    public function getExternalPortReturnsNullAsNoOffsetDefined(): void
    {
        $es = new Elasticsearch();
        self::assertNull($es->getExternalPort(10000));
    }

    #[Test]
    public function getChoicesContainsExpectedVersions(): void
    {
        $choices = Elasticsearch::getChoices();
        self::assertArrayHasKey('6.5.4', $choices);
        self::assertArrayHasKey('5.6', $choices);
    }
}
