<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Docker environment builder controller.
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class BuilderController extends Controller
{
    use ContainerAwareTrait;

    /**
     * @Route("/build-environment", name="homepage")
     */
    public function createAction(Request $request)
    {
        // Set up form
        $project = new Project();
        $form    = $this->createForm(ProjectType::class, $project, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            // Generate zip file with docker project
            $generator = $this->container->get('docker_generator');
            $zipFile   = $generator->generate($project);

            // Generate file download & cleanup
            $response = new BinaryFileResponse($zipFile->getTmpFilename());
            $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipFile->getFilename());
            $response->deleteFileAfterSend(true);

            return $response;
        }

        return $this->render('AppBundle:Builder:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
