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

namespace AppBundle\Controller;

use AppBundle\Entity\ContactRequest;
use AppBundle\Form\ContactRequestType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for simpler pages.
 *
 * @package AppBundle\Controller
 * @author  Luis A. Pabon Flores
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
            ->getRepository('AppBundle:ORM\Post')
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
     * @param \AppBundle\Entity\ContactRequest $contactRequest
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
