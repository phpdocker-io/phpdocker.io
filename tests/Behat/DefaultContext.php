<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Assert\Assertion;
use Behat\MinkExtension\Context\MinkContext;
use ZipArchive;

final class DefaultContext extends MinkContext
{
    private ?ZipArchive $lastZip = null;
    private ?string $lastZipTmpFile = null;

    /**
     * @Then /^the response code should be (\d+)$/
     */
    public function theResponseCodeShouldBe(int $responseCode)
    {
        Assertion::same($this->getSession()->getStatusCode(), $responseCode);
    }

    /**
     * @When /^I load "([^"]*)"$/
     */
    public function iLoad(string $path)
    {
        // Ensure we do not follow any redirects so that we can test them
        $this->getSession()->getDriver()->getClient()->followRedirects(false);

        $this->getSession()->visit($path);
    }

    /**
     * @Then /^it should permanently redirect to "([^"]*)"$/
     */
    public function itShouldPermanentlyRedirectTo(string $url)
    {
        $headers = $this->getSession()->getResponseHeaders();

        Assertion::same($this->getSession()->getStatusCode(), 301);
        Assertion::keyExists($headers, 'location');
        Assertion::same($headers['location'][0], $url);
    }

    /**
     * @Given /^I should receive a zip file named "([^"]*)"$/
     */
    public function iShouldReceiveAZipFileNamed(string $zipFilename)
    {
        $response = $this->getSession()->getDriver()->getContent();
        $headers  = $this->getSession()->getResponseHeaders();

        $expectedZipHeaders = [
            "content-type"        => ["application/zip"],
            "content-disposition" => [sprintf("attachment; filename=%s", $zipFilename)],
        ];

        Assertion::eqArraySubset($headers, $expectedZipHeaders);

        $tmpFile = sprintf('%s', tempnam('/tmp', 'zip_test_'));
        file_put_contents(filename: $tmpFile, data: $response);

        $zip    = new ZipArchive();
        $result = $zip->open($tmpFile);

        Assertion::true($result);

        $this->lastZip        = $zip;
        $this->lastZipTmpFile = $tmpFile;
    }

    /** @AfterScenario */
    public function cleanUpZip(): void
    {
        if ($this->lastZip !== null) {
            $this->lastZip->close();
            $this->lastZip = null;
        }

        if ($this->lastZipTmpFile !== null) {
            @unlink($this->lastZipTmpFile);
            $this->lastZipTmpFile = null;
        }
    }

    /**
     * @Then /^the zip should contain the file "([^"]*)"$/
     */
    public function theZipShouldContainTheFile(string $path): void
    {
        Assertion::notNull($this->lastZip, 'No zip file available. Did you call "I should receive a zip file named" first?');
        Assertion::true(
            $this->lastZip->locateName($path) !== false,
            sprintf('File "%s" not found in zip archive', $path),
        );
    }

    /**
     * @Then /^the zip file "([^"]*)" should contain "([^"]*)"$/
     */
    public function theZipFileShouldContain(string $path, string $content): void
    {
        Assertion::notNull($this->lastZip, 'No zip file available. Did you call "I should receive a zip file named" first?');
        $fileContent = $this->lastZip->getFromName($path);
        Assertion::string($fileContent, sprintf('File "%s" not found in zip archive', $path));
        Assertion::contains($fileContent, $content, sprintf('File "%s" does not contain "%s"', $path, $content));
    }

    /**
     * @Then /^the zip file "([^"]*)" should not contain "([^"]*)"$/
     */
    public function theZipFileShouldNotContain(string $path, string $content): void
    {
        Assertion::notNull($this->lastZip, 'No zip file available. Did you call "I should receive a zip file named" first?');
        $fileContent = $this->lastZip->getFromName($path);
        Assertion::string($fileContent, sprintf('File "%s" not found in zip archive', $path));
        Assertion::notContains($fileContent, $content, sprintf('File "%s" should not contain "%s"', $path, $content));
    }
}
