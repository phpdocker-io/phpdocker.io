<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Docker environment builder controller.
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class BuilderController extends Controller
{
    /**
     * @Route("/build-environment", name="homepage")
     */
    public function createAction(Request $request)
    {
        // just setup a fresh $task object (remove the dummy data)
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project, ['method' => Request::METHOD_POST]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            dump($project);
            //return $this->redirectToRoute('task_success');
        } elseif ($form->isValid() === false) {
            dump($form);
        }

        return $this->render('AppBundle:Builder:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
