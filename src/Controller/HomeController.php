<?php

namespace App\Controller;

use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function Home(EntityManagerInterface $entityManager)
    {

        $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render('home.html.twig', [
            'movies' => $movies,
        ]);
    }



}