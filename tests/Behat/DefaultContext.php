<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class DefaultContext implements Context
{
    private Response $response;

    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @Then /^the response code should be (\d+)$/
     */
    public function theResponseCodeShouldBe(int $responseCode)
    {
        if ($this->response === null) {
            throw new RuntimeException('No response received');
        }

        Assertion::same($this->response->getStatusCode(), $responseCode);
    }

    /**
     * @When /^I load "([^"]*)"$/
     */
    public function iLoad(string $path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then /^it should permanently redirect to "([^"]*)"$/
     */
    public function itShouldPermanentlyRedirectTo(string $url)
    {
        if ($this->response === null) {
            throw new RuntimeException('No response received');
        }

        Assertion::same($this->response->getStatusCode(), 301);
        Assertion::true($this->response->headers->has('location'));
        Assertion::same($this->response->headers->get('location'), $url);
    }
}
