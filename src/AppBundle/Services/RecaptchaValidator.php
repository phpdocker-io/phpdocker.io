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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Recaptcha token verifier
 *
 * @package AppBundle\Services
 * @author  Luis A. Pabon Flores
 */
class RecaptchaValidator implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var string
     */
    private $serviceSecret;

    /**
     * @var string
     */
    private $serviceEndpoint;

    /**
     * Provides the secret key and endpoint required to actually verify a token with
     * reCAPTCHA.
     *
     * @param string $serviceSecret
     * @param string $serviceEndpoint
     */
    public function __construct(string $serviceSecret, string $serviceEndpoint)
    {
        $this->serviceSecret   = $serviceSecret;
        $this->serviceEndpoint = $serviceEndpoint;
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
            'secret'   => $this->serviceSecret,
            'response' => $token,
            'remoteip' => $this->container->get('request_stack')->getMasterRequest()->getClientIp(),
        ];

        $response = $this->container
            ->get('guzzle')
            ->post($this->serviceEndpoint, ['form_params' => $data])
            ->getBody()
            ->getContents();

        return json_decode($response, true)['success'] ?? false;
    }
}
