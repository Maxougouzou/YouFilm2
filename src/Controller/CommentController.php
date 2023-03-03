<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Form\Type\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{

    #[Route('/movies/{id}/comments', name: 'app_create_comment')]
    public function createComment(Request $request, Movie $movie, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(CommentType::class);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setMovieId($movie);
            $comment->setUserId($this->getUser());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('movie_show', ['id' => $movie->getId()]);
        }

        return $this->render('comment/comment.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
            'user' => $user

        ]);

    }
    #[Route('/comments/delete/{id}', name: 'app_delete_comment')]
    public function deleteComment(Request $request, EntityManagerInterface $entityManager, Comment $comment): Response
    {
        $movie = $comment->getMovieId();
        if (!$movie) {
            // Le commentaire n'est associé à aucun film, renvoie une erreur ou redirige vers une autre page.
            throw new \Exception('Comment is not associated with any movie.');
        }

        $movieId = $movie->getId(); // Récupère l'identifiant du film associé au commentaire

        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Comment deleted successfully');

        return $this->redirectToRoute('movie_show', ['id' => $movieId]);
    }

    #[Route('/comments/edit/{id}', name: 'app_edit_comment')]
    public function editComment(Request $request, EntityManagerInterface $entityManager, Comment $comment): Response
    {
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Comment edited successfully');

            return $this->redirectToRoute('movie_show', ['id' => $comment->getMovieId()->getId()]);
        }

        return $this->render('comment/edit.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment,
            'movie'=>$comment->getMovieId(),
            'user' => $user
        ]);
    }









}

