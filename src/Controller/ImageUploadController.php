<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
class ImageUploadController extends AbstractController
{
    #[Route('/uploadimage', name: 'upload_image')]
    public function uploadImage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $image->getFile();

            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            $file->move($this->getParameter('images_directory'), $fileName);

            $image->setImage($fileName);
            $image->setCreationDate(new \DateTime());

            //$entityManager = $entityManager->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('/home');
        }

        return $this->render('upload_image.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}
