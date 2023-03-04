<?php

namespace App\Controller;

use App\Entity\Category;
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
        $category = $entityManager->getRepository(Category::class)->findAll();
        $user = $this->getUser();

        return $this->render('home.html.twig', [
            'movies' => $movies,
            'category'=> $category,
            'user'=>$user
        ]);
    }



}