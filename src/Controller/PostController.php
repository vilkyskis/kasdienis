<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Form\Post2Type;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository,TopicRepository $topicRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
            'topics' => $topicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}/upvote", name="post_upvote", methods={"GET","POST"})
     */
    public function upvote(Post $post,Request $request): Response
    {
        $form = $this->createForm(Post2Type::class, $post);
        $form->handleRequest($request);
        $post->setUpvotes($post->getUpvotes()+1);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('post_show', [
            'id' => $post->getId(),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(Post2Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET","POST"})
     */
    public function show(Post $post,Request $request,$id): Response
    {
        // Get the post
        $comment = new Comment();
        $em = $this->getDoctrine()->getManager();
        $postToAdd = $em->getRepository(Post::class)->find($id);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            //Add data to new object
            $entityManager = $this->getDoctrine()->getManager();
            $comment->setPost($postToAdd);
            //$entityManager->setPost($postToAdd);
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show',array('id'=> $id));
        }


        return $this->render('post/show.html.twig', [
            'post' => $post,'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(Post2Type::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index', [
                'id' => $post->getId(),
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
