<?php

namespace App\Controller\Admin;

use App\Entity\Equipment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Equipment::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setHelp('index', 'This is the Equipment management section. Here you can add, edit, and delete equipment items.')
            ->setHelp('new', 'Use this form to add a new Equipment item. You need to go AddEquipmentInRoom to add or modify equipments in a choosen Room')
            ->setHelp('edit', 'You can modify the details of the Equipment here.')
            ->setHelp('detail', 'This page shows the details of a specific Equipment item.');
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
            BooleanField::new('is_software')
                ->setLabel('Software')
                ->setHelp('Check if the equipment is a software'),
        ];
    }
}