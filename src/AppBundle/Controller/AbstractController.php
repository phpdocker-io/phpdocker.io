<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Base controller
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class AbstractController extends Controller implements ContainerAwareInterface
{
    /**
     * Implements ContainerAwareInterface
     */
    use ContainerAwareTrait;

    /**
     * Validates any recaptcha response.
     *
     * @param Request $request
     *
     * @return bool
     */
    protected function checkRecaptcha(Request $request)
    {
        return $this->container
            ->get('recaptcha_validator')
            ->verify($request->get('g-recaptcha-response'));
    }
}
