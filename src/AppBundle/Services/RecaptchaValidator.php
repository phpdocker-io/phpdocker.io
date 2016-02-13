<?php
namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Recaptcha token verifier
 *
 * @package   AppBundle\Services
 * @copyright Auron Consulting Ltd
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
    public function verify(string $token) : bool
    {
        $data = [
            'secret'   => $this->serviceSecret,
            'response' => $token,
            'remoteip' => 'foo',
        ];

        $response = $this->container
            ->get('guzzle')
            ->post($this->serviceEndpoint, ['form_params' => $data])
            ->getBody()
            ->getContents();

        return json_decode($response, true)['success'] ?? false;
    }
}
