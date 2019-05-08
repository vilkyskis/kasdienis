<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as ORM_SECURITY;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;
use App\Form\Post2Type;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

class DefaultController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
     * @ORM_SECURITY("has_role('ROLE_USER')")
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

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/like", name="default_post_like", methods={"GET","POST"})
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

        return $this->redirectToRoute('default');
    }
}
