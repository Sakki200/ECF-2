<?php

namespace App\Controller\Admin;

use App\Entity\Ergonomic;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ErgonomicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ergonomic::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setHelp('index', 'This is the Ergonomic management section. Here you can add, edit, and delete ergonomic options.')
            ->setHelp('new', 'Use this form to add a new Ergonomic option. You need to go AddErgonomicInRoom to add or modify Ergonomic in a choosen Room')
            ->setHelp('edit', 'You can modify the details of the Ergonomic here.')
            ->setHelp('detail', 'This page shows the details of a specific Ergonomic option.');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('name')
                ->setLabel('Name')
                ->setHelp('Enter a Name'),
        ];
    }
}
