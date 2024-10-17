<?php

namespace App\Controller\Admin;

use App\Entity\Room;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RoomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Room::class;
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
            ->setHelp('index', 'This is the Room management section. Here you can add, edit, and delete Rooms.')
            ->setHelp('new', 'Use this form to add a new Room.')
            ->setHelp('edit', 'You can modify the details of the Room here.')
            ->setHelp('detail', 'This page shows the details of a specific Room.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnDetail(),
            TextField::new('name')
            ->setLabel('Title')
            ->setHelp('Enter a name for the Room'),
            NumberField::new('capacity')
            ->setLabel('Capacity')
            ->setHelp('Enter a max capacity for the Room'),
            NumberField::new('floor')
            ->setLabel('Floor')
            ->setHelp('Enter the floor of the Room'),
            NumberField::new('door_number')
            ->setLabel('Door Number')
            ->setHelp('Enter the number of the Room'),
            TextField::new('image')
            ->setLabel('Image')
            ->setHelp('Enter the image of the Room, write like this : room_0.jpg'),
            BooleanField::new('is_backup')
            ->setLabel('Backup')
            ->setHelp('Check if the room is a backup Room'),
        ];
    }

}
