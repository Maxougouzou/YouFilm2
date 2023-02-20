<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    #[Route('/register', name: 'app_user_register')]
    public function newUser(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $hasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()&&$form->isValid()){
            $user=$form->getData();
            $user->setPassword($hasher->hashPassword($user, $user->getPlainPassword()));
            $user->setIsBanned(false);

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect('/login');
        }

        return $this->render('register.html.twig', array ('form'=>$form->createView()));
    }


}