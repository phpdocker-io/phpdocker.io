<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ContactRequest;
use AppBundle\Form\ContactRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Simple, flat pages
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class PagesController extends Controller implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * Homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        return $this->render('AppBundle:Pages:home.html.twig');
    }

    /**
     * ContactRequest page
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactRequestAction(Request $request)
    {
        // Set up form
        $contactRequest = new ContactRequest();
        $form           = $this->createForm(ContactRequestType::class, $contactRequest, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            if ($this->checkRecaptcha($request) === true) {
                return $this->render('AppBundle:Pages:contact-success.html.twig');
            }

            $form->addError(new FormError('We failed to verify you are human'));
        }

        return $this->render('AppBundle:Pages:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Validates the recaptcha response.
     *
     * @param Request $request
     *
     * @return bool
     */
    private function checkRecaptcha(Request $request)
    {
        return $this->container
            ->get('recaptcha_validator')
            ->verify($request->get('g-recaptcha-response'));
    }
}
