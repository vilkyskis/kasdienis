<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security as ORM_SECURITY;

/**
 * @ORM_SECURITY("has_role('ROLE_ADMIN')")
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     */
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('comment/index.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/new", name="comment_new", methods={"GET","POST"})
     */
    public function new(Request $request,$id): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment,array(
            'postid' => $id,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('comment_index');
        }

        return $this->render('comment/new.html.twig', [
            'comment' => $comment,'postid' => $id,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(Comment $comment): Response
    {
        return $this->render('comment/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/edit", name="comment_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('comment_index', [
                'id' => $comment->getId(),
            ]);
        }

        return $this->render('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}/like", name="comment_like", methods={"GET","POST"})
     */
    public function likePost(Comment $comment,Request $request): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $user = $this->security->getUser();
        //$userID = $user->getId();
        $form->handleRequest($request);
        
        if($comment->addLikedBy($user)){
            $comment->setLikedCount($comment->getLikedCount()+1);
        } else {
            $comment->removeLikedBy($user);
            $comment->setLikedCount($comment->getLikedCount()-1);
        }
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('post_show', [
            'id' => $comment->getPost()->getId(),
        ]);
    }

    /**
     * @ORM_SECURITY("has_role('ROLE_USER')")
     * @Route("/{id}", name="comment_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Comment $comment): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('comment_index');
    }
}
