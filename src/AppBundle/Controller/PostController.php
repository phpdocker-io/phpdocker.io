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

use AppBundle\Entity\ORM\Post;
use AppBundle\Entity\ORM\PostComment;
use AppBundle\Form\PostCommentType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller for posts and post comments
 *
 * @package AppBundle\Controller
 * @author  Luis A. Pabon Flores
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
            ->getRepository('AppBundle:ORM\Post')
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
