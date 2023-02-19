<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Image;
use App\Form\ImageType;

class ImageUploadController extends AbstractController
{
    #[Route('/uploadimage')]
    public function uploadImage(Request $request)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('file')->getData();


            // Generate a unique name for the file before saving it
            $imageName = md5(uniqid()) . '.' . $imageFile->guessExtension();

            // Move the file to the directory where images are stored
            try {
                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // Update the "Image" property of the Image entity
            $image->setImage($fileName);

            // Set the "CreationDate" property of the Image entity
            $image->setCreationDate(new \DateTime('now'));

            // Save the Image entity to the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('upload_image.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
