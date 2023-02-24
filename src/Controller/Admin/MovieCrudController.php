<?php

namespace App\Controller\Admin;

use App\Entity\Movie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MovieCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Movie::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextareaField::new('description'),
            DateTimeField::new('creationDate'),
            AssociationField::new('category')
                ->setFormTypeOption('choice_label', 'name'),
            ImageField::new('thumbnail')
                ->setBasePath('images/')
                ->setUploadDir('public/images'),
            ImageField::new('video')
                ->setBasePath('images/')
                ->setUploadDir('public/images'),
            ImageField::new('illustration')
                ->setBasePath('images/')
                ->setUploadDir('public/images')
        ];
    }

}
