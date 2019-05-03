<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TopicRepository;

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
}
