<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Assert\Assertion;
use Behat\MinkExtension\Context\MinkContext;
use ZipArchive;

final class DefaultContext extends MinkContext
{
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

        Assertion::true($this->isZipFile($response));
    }

    private function isZipFile(string $data): bool
    {
        $fn = sprintf('%s', tempnam('/tmp', 'zip_test_'));
        file_put_contents(filename: $fn, data: $data);

        try {
            $zipFile = new ZipArchive();

            return $zipFile->open($fn);
        } finally {
            @unlink($fn);
        }
    }
}
