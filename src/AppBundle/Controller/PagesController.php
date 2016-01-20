<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Simple, flat pages
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class PagesController extends Controller
{
    public function homeAction()
    {
        return $this->render('AppBundle:Pages:home.html.twig');
    }
}
