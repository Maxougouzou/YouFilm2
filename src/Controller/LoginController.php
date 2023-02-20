<?php

namespace App\Controller;

use App\Form\Type\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_user_login')]
    public function login(): Response
    {
        $form = $this->createForm(LoginType::class);

        return $this->render('login.html.twig',['form' => $form->createView()]);
    }

    #[Route('/logout', name: 'app_user_logout')]
    public function logout(): Response
    {

    }


}