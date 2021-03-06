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
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as ORM_SECURITY;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("{_locale}/post")
 */
class PostController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
     * @ORM_SECURITY("has_role('ROLE_USER')")
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
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/like", name="post_like", methods={"GET","POST"})
     */
    public function likePost(Post $post,Request $request): Response
    {
        $form = $this->createForm(Post2Type::class, $post);
        $user = $this->security->getUser();
        //$userID = $user->getId();
        $form->handleRequest($request);
        
        if($post->addLikedBy($user)){
            $post->setUpvotes($post->getUpvotes()+1);
        } else {
            $post->removeLikedBy($user);
            $post->setUpvotes($post->getUpvotes()-1);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('post_show', [
            'id' => $post->getId(),
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/new/{topic_id}", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request,$topic_id,TopicRepository $topics): Response
    {
        $post = new Post();
        $form = $this->createForm(Post2Type::class, $post,array('topic' => $topics->find($topic_id)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $file = $request->files->get('post2')['image'];
            if($file){
                $uploads_dir = $this->getParameter('image_upload_dir');
                $filename = md5(uniqid()).'.'.$file->guessExtension();
                try{
                    $file->move(
                        $uploads_dir,
                        $filename
                    );
                }catch(FileException $ex){

                }
                $post->setImage($filename);
            }

            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('default');
        }

        return $this->render('post/new.html.twig', [
            'post' => $post,'topic_id' => $topic_id,'topics' => $topics->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET","POST"})
     */
    public function show(Post $post,Request $request,$id,TopicRepository $topicRepository): Response
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
            'post' => $post,'comment' => $comment,  'topics' => $topicRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    
    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/edit/{topic}", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post,$topic, TopicRepository $topics,$id): Response
    {
        $form = $this->createForm(Post2Type::class, $post,array('topic' => $topics->find($topic)));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('default', [
                'id' => $post->getId(),
            ]);
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,'topic_id' => $topic,'topics' => $topics->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $likes = $post->getComments();
            foreach($likes as $like){ 
                $post->removeComment($like);
            }
            $entityManager->remove($post);

            $entityManager->flush();
        }

        return $this->redirectToRoute('default');
    }
}
