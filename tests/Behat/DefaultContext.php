<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the demo
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DefaultContext implements Context
{
    private Response $response;

    public function __construct(private KernelInterface $kernel)
    {
    }

    /**
     * @Then /^the response code should be (\d+)$/
     */
    public function theResponseCodeShouldBe(int $arg1)
    {
        if ($this->response === null) {
            throw new RuntimeException('No response received');
        }

        Assertion::same($this->response->getStatusCode(), $arg1);
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

        Assertion::true($this->response->headers->has('location'));
        Assertion::same($this->response->headers->get('location'), $url);
    }
}
