<?php

namespace App\Controller\Admin;

use App\Entity\RoomEquipment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomEquipmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RoomEquipment::class;
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
            ->setHelp('Choose the Room where you want to add Equipments'),
            AssociationField::new('equipment')
            ->setLabel('Equipment')
            ->setHelp('Choose the Equipment where you want to add to the Room'),
            NumberField::new('quantity')
            ->setLabel('Quantity')
            ->setHelp('Choose the number of this Equipment in this Room'),
        ];
    }
}
