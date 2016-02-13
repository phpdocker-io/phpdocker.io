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

            // If human, compose and send message
            if ($this->checkRecaptcha($request) === true) {
                $this->sendmessage($contactRequest);
                return $this->render('AppBundle:Pages:contact-success.html.twig');
            }

            $form->addError(new FormError('We failed to verify you are human'));
        }

        return $this->render('AppBundle:Pages:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Actually send contact request email.
     *
     * @param ContactRequest $contactRequest
     */
    private function sendmessage(ContactRequest $contactRequest)
    {
        $messageBody = $this->renderView('AppBundle:emails:contact-email.html.twig', [
            'senderName'  => $contactRequest->getSenderName(),
            'senderEmail' => $contactRequest->getSenderEmail(),
            'message'     => $contactRequest->getMessage(),
        ]);

        $message = \Swift_Message::newInstance();
        $message
            ->setSubject('PHPDocker.io - Contact request')
            ->setFrom($contactRequest->getSenderEmail() ?? 'automaton@phpdocker.io')
            ->setTo($this->container->getParameter('email_to'))
            ->setBody($messageBody, 'text/html');

        $this->container->get('mailer')->send($message);
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
