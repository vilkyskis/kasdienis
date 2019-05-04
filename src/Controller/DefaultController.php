<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Form\Post2Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(PostRepository $postRepository,TopicRepository $topicRepository)
    {
        return $this->render('index/homepage.html.twig', [
            'controller_name' => 'DefaultController',
            'posts' => $postRepository->findAll(),
            'topics' => $topicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/upvote", name="default_post_upvote", methods={"GET","POST"})
     */
    public function upvote(Post $post,Request $request): Response
    {
        $form = $this->createForm(Post2Type::class, $post);
        $form->handleRequest($request);
        $post->setUpvotes($post->getUpvotes()+1);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('default');
    }
}
