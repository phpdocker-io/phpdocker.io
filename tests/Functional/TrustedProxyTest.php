<?php
declare(strict_types=1);
/*
 * Copyright 2021 Luis Alberto Pabón Flores
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 */

namespace App\Tests\Functional;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Verifies that the generator rate limiter isolates clients by their forwarded
 * IP only when the request arrives from a trusted proxy.
 *
 * .env.test sets SYMFONY_TRUSTED_PROXIES=192.0.2.0/24 and the test config limits
 * the generator to three requests per minute.
 */
class TrustedProxyTest extends WebTestCase
{
    private const TRUSTED_PEER = '192.0.2.11';

    private KernelBrowser $client;

    /**
     * Resets the static trusted-proxy state so it cannot leak between tests.
     */
    protected function tearDown(): void
    {
        Request::setTrustedProxies([], -1);

        parent::tearDown();
    }

    #[Test]
    public function trustedPeerGetsDistinctBucketPerForwardedClient(): void
    {
        $this->createClientWithRemoteAddr(self::TRUSTED_PEER);

        // The limiter cache pool survives kernel resets and test runs, so use
        // unique client IPs to avoid collisions with other tests or runs.
        $clientA = $this->randomClientIp();
        $clientB = $this->randomClientIp();
        self::assertNotSame($clientA, $clientB);

        for ($i = 1; $i <= 3; ++$i) {
            $this->submitGeneration(clientIp: $clientA);
            self::assertResponseIsSuccessful();
        }

        // Fourth request from the same forwarded client exceeds the limit.
        $this->submitGeneration(clientIp: $clientA);
        self::assertResponseStatusCodeSame(429);

        // A different forwarded client through the same trusted peer has its
        // own bucket and is still allowed.
        $this->submitGeneration(clientIp: $clientB);
        self::assertResponseIsSuccessful();
    }

    #[Test]
    public function untrustedPeerCannotSpoofForwardedClientToEvadeLimit(): void
    {
        $this->createClientWithRemoteAddr($this->randomUntrustedIp());

        // Spoof a different X-Forwarded-For on every request. As the peer is not
        // trusted, the limiter must key on REMOTE_ADDR, so all four requests
        // share one bucket and the fourth is rejected.
        for ($i = 1; $i <= 3; ++$i) {
            $this->submitGeneration(clientIp: $this->randomClientIp());
            self::assertResponseIsSuccessful();
        }

        $this->submitGeneration(clientIp: $this->randomClientIp());
        self::assertResponseStatusCodeSame(429);
    }

    #[Test]
    public function onlyForwardedForProtoAndPortAreTrusted(): void
    {
        $this->createClientWithRemoteAddr(self::TRUSTED_PEER);

        self::assertSame(['192.0.2.0/24'], Request::getTrustedProxies());
        self::assertSame(
            Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_PORT,
            Request::getTrustedHeaderSet(),
        );
    }

    private function createClientWithRemoteAddr(string $remoteAddr): void
    {
        $this->client = static::createClient(
            options: [
                'environment' => 'test',
                'debug'       => false,
            ],
            server: ['REMOTE_ADDR' => $remoteAddr],
        );
    }

    /**
     * Performs a valid, CSRF-protected generation POST claiming the given client IP.
     */
    private function submitGeneration(string $clientIp): void
    {
        $this->client->request('GET', '/');
        $this->client->submitForm(
            'Generate project archive',
            ['project[globalOptions][basePort]' => '8000'],
            serverParameters: ['HTTP_X_FORWARDED_FOR' => $clientIp],
        );
    }

    private function randomClientIp(): string
    {
        return sprintf('198.51.100.%d', random_int(1, 254));
    }

    private function randomUntrustedIp(): string
    {
        return sprintf('203.0.113.%d', random_int(1, 254));
    }
}
