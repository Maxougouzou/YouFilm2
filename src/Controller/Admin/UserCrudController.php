<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username'),
            EmailField::new('email'),
            BooleanField::new('isBanned')->onlyOnIndex(),
            CollectionField::new('roles')
        ];
    }
   public function configureActions(Actions $actions): Actions
    {
        $banUser = Action::new('banUser', "Bannir l'utilisateur")
            ->linkToCrudAction('banUser')
            ->displayIf(function (User $user) {
                return !$user->getIsBanned();
            });

        $unbanUser = Action::new('unbanUser', "Débannir l'utilisateur")
            ->linkToCrudAction('unbanUser')
            ->displayIf(function (User $user) {
                return $user->getIsBanned();
            });

        return $actions
            ->add(Crud::PAGE_INDEX, $banUser)
            ->add(Crud::PAGE_INDEX, $unbanUser);
    }

    public function banUser(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $id = $context->getRequest()->query->get('entityId');
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setIsBanned(true);
        $entityManager->flush();

        $this->addFlash('success', sprintf("L'utilisateur %s a été banni ", $user->getUsername()));

        return $this->redirectToRoute('admin', [
            'action' => 'index',
            'entity' => $context->getEntity()->getName(),
        ]);
    }

    public function unbanUser(AdminContext $context, EntityManagerInterface $entityManager)
    {
        $id = $context->getRequest()->query->get('entityId');
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setIsBanned(false);
        $entityManager ->flush();


        $this->addFlash('success', sprintf("L'utilisateur %s a été débanni", $user->getUsername()));

        return $this->redirectToRoute('admin', [
            'action' => 'index',
            'entity' => $context->getEntity()->getName(),
        ]);
    }
}
