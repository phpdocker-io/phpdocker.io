<?php
declare(strict_types=1);

namespace App\Tests\Unit\PHPDocker\Zip;

use App\PHPDocker\Interfaces\ArchiveInterface;
use App\PHPDocker\Interfaces\GeneratedFileInterface;
use App\PHPDocker\Zip\Archiver;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ZipArchive;

class ArchiverTest extends TestCase
{
    private function makeFile(string $filename, string $contents): GeneratedFileInterface
    {
        return new class ($filename, $contents) implements GeneratedFileInterface {
            public function __construct(
                private readonly string $filename,
                private readonly string $contents,
            ) {}

            public function getFilename(): string
            {
                return $this->filename;
            }

            public function getContents(): string
            {
                return $this->contents;
            }
        };
    }

    #[Test]
    public function generateArchiveReturnsArchiveWithCorrectFilename(): void
    {
        $archiver = new Archiver();
        $archive  = $archiver->generateArchive('test.zip');

        self::assertInstanceOf(ArchiveInterface::class, $archive);
        self::assertSame('test.zip', $archive->getFilename());
    }

    #[Test]
    public function generateArchiveReturnsTmpFilenamePointingToActualFile(): void
    {
        $archiver = new Archiver();
        $archiver->addFile($this->makeFile('placeholder.txt', 'content'));
        $archive = $archiver->generateArchive('test.zip');

        self::assertFileExists($archive->getTmpFilename());
    }

    #[Test]
    public function addFileWithBaseFolderPrefixesFilename(): void
    {
        $archiver = new Archiver();
        $archiver->setBaseFolder('myfolder');
        $archiver->addFile($this->makeFile('config.txt', 'content'));

        $archive = $archiver->generateArchive('out.zip');

        $zip = new ZipArchive();
        $zip->open($archive->getTmpFilename());
        self::assertNotFalse($zip->locateName('myfolder/config.txt'));
        $zip->close();
    }

    #[Test]
    public function addFileWithIgnorePrefixDoesNotApplyBaseFolder(): void
    {
        $archiver = new Archiver();
        $archiver->setBaseFolder('myfolder');
        $archiver->addFile($this->makeFile('readme.txt', 'content'), ignorePrefix: true);

        $archive = $archiver->generateArchive('out.zip');

        $zip = new ZipArchive();
        $zip->open($archive->getTmpFilename());
        self::assertNotFalse($zip->locateName('readme.txt'));
        self::assertFalse($zip->locateName('myfolder/readme.txt'));
        $zip->close();
    }

    #[Test]
    public function addFileWithoutBaseFolderDoesNotPrefix(): void
    {
        $archiver = new Archiver();
        $archiver->addFile($this->makeFile('app.php', 'content'));

        $archive = $archiver->generateArchive('out.zip');

        $zip = new ZipArchive();
        $zip->open($archive->getTmpFilename());
        self::assertNotFalse($zip->locateName('app.php'));
        $zip->close();
    }

    #[Test]
    public function addedFileCanBeReadBackFromZip(): void
    {
        $archiver = new Archiver();
        $archiver->addFile($this->makeFile('hello.txt', 'hello world'));

        $archive = $archiver->generateArchive('out.zip');

        $zip = new ZipArchive();
        $zip->open($archive->getTmpFilename());
        self::assertSame('hello world', $zip->getFromName('hello.txt'));
        $zip->close();
    }
}
