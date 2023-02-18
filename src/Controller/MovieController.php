<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Entity\User;
use App\Form\Type\CommentType;
use App\Form\Type\RegisterType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class MovieController extends AbstractController
{

    #[Route('/movies/{id}', name: "movie_show")]
    public function show($id, EntityManagerInterface $entityManager, CommentRepository $commentRepository, Request $request)
    {
        $movie = $entityManager->getRepository(Movie::class)->find($id);

        $user = $entityManager->getRepository(User::class)->findAll();

        $comments = $commentRepository->findBy(['movie_id' => $movie->getId()]);


            return $this->render('movie/index.html.twig', [
                'movie' => $movie,
                'comments' => $comments,
            ]);
        }
}
