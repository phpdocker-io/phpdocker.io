<?php
namespace AppBundle\Controller;

use AppBundle\Entity\PhpOptions;
use AppBundle\Entity\Project;
use AppBundle\Form\ProjectType;
use AuronConsultingOSS\Docker\Project\Factory as ProjectFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * Docker environment builder controller.
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class BuilderController extends AbstractController
{
    /**
     * Form and form processor for creating a project.
     *
     * @param Request $request
     *
     * @return BinaryFileResponse|Response
     */
    public function createAction(Request $request)
    {
        // Set up form
        $project = ProjectFactory::create($this->container->get('slugifier'), new Project());
        $form    = $this->createForm(ProjectType::class, $project, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {
            // Fix PHP extensions per version before sending to generator
            $project = $this->fixPhpExtensionGeneratorExpectation($project);

            // Generate zip file with docker project
            $generator = $this->container->get('docker_generator');
            $zipFile   = $generator->generate($project);

            // Generate file download & cleanup
            $response = new BinaryFileResponse($zipFile->getTmpFilename());
            $response
                ->prepare($request)
                ->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $zipFile->getFilename())
                ->deleteFileAfterSend(true);

            return $response;
        }

        return $this->render('AppBundle:Builder:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Add php extensions to project based on version on the property the generator expects
     * as phpExtensions56/70 do not exist from its point of view.
     *
     * @param Project $project
     *
     * @return Project
     */
    private function fixPhpExtensionGeneratorExpectation(Project $project) : Project
    {
        if ($project->getPhpOptions()->getVersion() === PhpOptions::PHP_VERSION_56) {
            $project->getPhpOptions()->setPhpExtensions($project->getPhpOptions()->getPhpExtensions56());
        } else {
            $project->getPhpOptions()->setPhpExtensions($project->getPhpOptions()->getPhpExtensions70());
        }

        return $project;
    }
}
