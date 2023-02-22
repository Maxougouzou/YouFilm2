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

        ]);

    }}