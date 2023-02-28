<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Movie;
use App\Entity\Reaction;
use App\Entity\User;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{

    #[Route('/movies/{id}', name: "movie_show")]
    public function show($id, EntityManagerInterface $entityManager, CommentRepository $commentRepository, Request $request)
    {
        $movie = $entityManager->getRepository(Movie::class)->find($id);

        $user = $this->getUser();

        $reaction = $entityManager->getRepository(Reaction::class)->findOneBy(['movie_id' => $movie, 'user_id'=>$user]);;

        $comments = $commentRepository->findBy(['movie_id' => $movie->getId()]);


            return $this->render('movie/index.html.twig', [
                'movie' => $movie,
                'comments' => $comments,
                'reaction'=>$reaction,
            ]);
        }

        #[Route('movies',name:'app_all_movie')]
        public function allMovie(EntityManagerInterface $entityManager):Response
        {
            $category = $entityManager->getRepository(Category::class)->findAll();
            $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render('movie/allmovie.html.twig', [
            'category' => $category,
            'movies' => $movies
        ]);
        }

    #[Route('/favoritefilm',name:'app_favorite_movie')]
    public function favoriteMovie(EntityManagerInterface $entityManager):Response
    {
        $category = $entityManager->getRepository(Category::class)->findAll();
        $movies = $entityManager->getRepository(Movie::class)->findAll();
        $reactions = $entityManager->getRepository(Reaction::class)->findAll();

        return $this->render('movie/favorite.html.twig', [
            'category' => $category,
            'movies' => $movies,
            'reactions' => $reactions,
        ]);
    }


}
