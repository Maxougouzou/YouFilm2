<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Reaction;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{

    #[Route('/movies/{id}', name: "movie_show")]
    public function show($id, EntityManagerInterface $entityManager, CommentRepository $commentRepository, Request $request)
    {
        $movie = $entityManager->getRepository(Movie::class)->find($id);

        $user = $entityManager->getRepository(User::class)->findAll();

        $reaction = $entityManager->getRepository(Reaction::class)->findOneBy(['movie_id' => $movie]);;

        $comments = $commentRepository->findBy(['movie_id' => $movie->getId()]);


            return $this->render('movie/index.html.twig', [
                'movie' => $movie,
                'comments' => $comments,
                'reaction'=>$reaction,
            ]);
        }
}
