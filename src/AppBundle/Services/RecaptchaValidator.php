<?php
/**
 * Copyright 2016 Luis Alberto Pabon Flores
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
 */

namespace AppBundle\Services;

use GuzzleHttp\Client as Guzzle;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Recaptcha token verifier
 *
 * @package AppBundle\Services
 * @author  Luis A. Pabon Flores
 */
class RecaptchaValidator
{
    /**
     * @var Guzzle
     */
    private $guzzle;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var string
     */
    private $secret;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * Provides the secret key and endpoint required to actually verify a token with
     * reCAPTCHA.
     *
     * @param Guzzle       $guzzle
     * @param RequestStack $requestStack
     * @param string       $secret
     * @param string       $endpoint
     */
    public function __construct(Guzzle $guzzle, RequestStack $requestStack, string $secret, string $endpoint)
    {
        $this->guzzle       = $guzzle;
        $this->requestStack = $requestStack;
        $this->secret       = $secret;
        $this->endpoint     = $endpoint;
    }

    /**
     * Verifies the token against recaptcha.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify(string $token): bool
    {
        $data = [
            'secret'   => $this->secret,
            'response' => $token,
            'remoteip' => $this->requestStack->getMasterRequest()->getClientIp(),
        ];

        $response = $this->guzzle
            ->post($this->endpoint, ['form_params' => $data])
            ->getBody()
            ->getContents();

        return json_decode($response, true)['success'] ?? false;
    }
}
