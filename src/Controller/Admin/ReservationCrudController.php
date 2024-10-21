<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReservationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reservation::class;
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
            ->setHelp('index', 'This is the Reservation management section. Here you can add, edit, and delete Reservations.')
            ->setHelp('new', 'Use this form to add a new Reservation.')
            ->setHelp('edit', 'You can modify the details of the Reservation here.')
            ->setHelp('detail', 'This page shows the details of a specific Reservation.');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IntegerField::new('id')
                ->onlyOnDetail(),
            IntegerField::new('start')
                ->setLabel('Début')
                ->setHelp('Choose an hour for the start of the reservation'),
            IntegerField::new('end_reservation')
                ->setLabel('Fin')
                ->setHelp('Choose an hour for the end of the reservation'),
            ChoiceField::new('is_validated')
                ->setLabel('Statut')
                ->setHelp('Validate this reservation if there is no Schedule conflict')
                ->setChoices([
                    'En attente' => 'pending',
                    'Validée' => 'validated',
                    'Refusée' => 'refused'
                ])
                ->renderAsBadges([
                    'pending' => 'warning',
                    'validated' => 'success',
                    'refused' => 'danger'
                ]),
            DateTimeField::new('date_reservation')
                ->setLabel('Date de réservation')
                ->setHelp('Choose the day of the reservation'),
            AssociationField::new('user')
                ->setLabel('Utilisateur')
                ->setHelp('Choose the User linked for this reservation'),
            AssociationField::new('room')
                ->setLabel('Salle')
                ->setHelp('Choose the Room for this reservation'),
        ];
    }
}
