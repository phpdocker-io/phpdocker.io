<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ContactRequest;
use AppBundle\Form\ContactRequestType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for simpler pages.
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class PagesController extends AbstractController
{
    /**
     * Homepage
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $posts = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findBy(['active' => true], ['id' => 'DESC']);

        return $this->render('AppBundle:Pages:home.html.twig', ['posts' => $posts]);
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
                $this->sendMessage($contactRequest);

                return $this->render('AppBundle:Pages:contact-success.html.twig');
            }

            $form->addError(new FormError('We failed to verify you are human'));
        }

        return $this->render('AppBundle:Pages:contact.html.twig', ['form' => $form->createView()]);
    }

    /**
     * Actually send contact request email.
     *
     * @param ContactRequest $contactRequest
     */
    private function sendMessage(ContactRequest $contactRequest)
    {
        $messageBody = $this->renderView('AppBundle:emails:contact-email.html.twig', [
            'senderEmail' => $contactRequest->getSenderEmail(),
            'message'     => $contactRequest->getMessage(),
        ]);

        $message = \Swift_Message::newInstance();
        $message
            ->setSubject('PHPDocker.io - Contact request')
            ->setFrom('automaton@phpdocker.io')
            ->setReplyTo($contactRequest->getSenderEmail())
            ->setTo($this->container->getParameter('email_to'))
            ->setBody($messageBody, 'text/html');

        $this->container->get('mailer')->send($message);
    }
}
