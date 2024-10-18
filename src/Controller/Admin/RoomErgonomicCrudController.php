<?php

namespace App\Controller\Admin;

use App\Entity\RoomErgonomic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomErgonomicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RoomErgonomic::class;
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
            AssociationField::new('room')
            ->setLabel('Room')
            ->setHelp('Choose the Room where you want to add Ergonomics'),
            AssociationField::new('ergonomic')
            ->setLabel('Ergonomic')
            ->setHelp('Choose the Ergonomic where you want to add to the Room'),
        ];
    }
}
