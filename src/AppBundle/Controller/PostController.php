<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use AppBundle\Entity\PostComment;
use AppBundle\Form\PostCommentType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for posts and post comments
 *
 * @package   AppBundle\Controller
 * @copyright Auron Consulting Ltd
 */
class PostController extends AbstractController
{
    /**
     * Single post page.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showPostAction(Request $request)
    {
        $post = $this
            ->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findOneBy(['slug' => $request->get('slug'), 'active' => true]);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        // Post comment form generation and processing
        $postCommentForm = $this->postCommentFormProcessor($request, $post);

        return $this->render('AppBundle:Post:post.html.twig', ['post' => $post, 'form' => $postCommentForm->createView()]);
    }

    /**
     * Generates and processes the post comment form
     *
     * @param Request $request
     * @param Post    $post
     *
     * @return FormInterface
     */
    private function postCommentFormProcessor(Request $request, Post $post) : FormInterface
    {
        // Comments form
        $postComment = new PostComment();
        $form        = $this->createForm(PostCommentType::class, $postComment, ['method' => Request::METHOD_POST]);

        // Process form
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid() === true) {

            // If human, persist
            if ($this->checkRecaptcha($request) === true) {
                $em = $this->getDoctrine()->getManager();
                $postComment->setPost($post);
                $em->persist($postComment);
                $em->flush();

                // Add success message
                $request
                    ->getSession()
                    ->getFlashBag()
                    ->add('commentForm', true);
            } else {
                $form->addError(new FormError('We failed to verify you are human'));
            }
        }

        return $form;
    }
}
