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

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GeneratorTest extends WebTestCase
{
    private KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient(options: [
            'environment' => 'test',
            'debug'       => false,
        ]);
    }

    /**
     * @test
     */
    public function generatorRedirectsToHome(): void
    {
        $this->client->request(method: 'GET', uri: '/generator');

        self::assertResponseRedirects(expectedLocation: 'http://localhost/', expectedCode: 301);
    }

    /**
     * @test
     */
    public function generatorLoads(): void
    {
        $this->client->request(method: 'GET', uri: '/');

        self::assertResponseIsSuccessful();
    }
}
