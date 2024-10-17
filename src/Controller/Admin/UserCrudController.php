<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            // ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setHelp('index', 'This is the User management section. Here you can add, edit, and delete Users.')
            ->setHelp('new', 'Use this form to add a new User.')
            ->setHelp('edit', 'You can modify the details of the user here.')
            ->setHelp('detail', 'This page shows the details of a specific User.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('username')
                ->setLabel('Username')
                ->setHelp('Enter a username'),
            EmailField::new('email')
                ->setLabel('Email')
                ->setHelp('Enter an email'),
            TextField::new('password')
                ->setLabel('Password')
                ->setHelp('Enter a password')
                ->onlyOnForms()
                ->setRequired($pageName === Crud::PAGE_NEW), // Only required when creating new users
            ChoiceField::new('roles')
                ->setLabel('Roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ])
                ->allowMultipleChoices()
                ->renderExpanded(), // To show as checkboxes
            BooleanField::new('isVerified')
                ->setLabel('Verified')
                ->setHelp('Check if the user\'s email is verified'),
        ];
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
