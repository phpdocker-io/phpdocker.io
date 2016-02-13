<?php
namespace AppBundle\Controller;

use AppBundle\Entity\ContactRequest;
use AppBundle\Form\ContactRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Simple, flat pages
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class PagesController extends Controller
{
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
     */
    public function contactRequestAction(Request $request)
    {
        // Set up form
        $contactRequest = new ContactRequest();
        $form    = $this->createForm(ContactRequestType::class, $contactRequest, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {

        }

        return $this->render('AppBundle:Pages:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
