<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categorie/{name}', name: 'app_category')]

    public function category(Category $category, EntityManagerInterface $entityManager):Response
    {

        $movies = $entityManager->getRepository(Movie::class)->findAll();

        return $this->render('category/category.html.twig', [
            'category' => $category,
            'movies' =>$movies
        ]);

    }



}