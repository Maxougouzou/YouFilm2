<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Reaction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReactionController extends AbstractController
{
    #[Route('/favorite', name: 'movies_favorite')]
    public function fav(EntityManagerInterface $entityManager, Request $request){
        $movie_id = $request->query->get('id');
        $user = $this->getUser();

        $movie = $entityManager->getRepository(Movie::class)->find($movie_id);
        $reaction = $entityManager->getRepository(Reaction::class);
        $favoriteReaction = $reaction->findOneBy(['type' => 'favorite', 'user_id' => $user->getId(), 'movie_id' => $movie->getId()]); // récupérer la réaction "favorite" de l'utilisateur pour le film sélectionné

        if ($favoriteReaction === null) {
            // Si la réaction "favorite" n'existe pas, ajoute nouvelle réaction "favorite"
            $favoriteReaction = new Reaction();
            $favoriteReaction->setType('favorite');
            $favoriteReaction->setMovieId($movie);
            $favoriteReaction->setUserId($user);
            $entityManager->persist($favoriteReaction);
        } else {
            // Si la réaction "favorite" existe déjà, supprime la réaction
            $entityManager->remove($favoriteReaction);
        }
        $entityManager->flush();

        return $this->redirectToRoute('movie_show', ['id' => $movie_id]);
    }



}