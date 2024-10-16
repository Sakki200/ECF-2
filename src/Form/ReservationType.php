<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reservation', DateType::class, [
                'label' => 'Date de réservation:',
                'attr' => [
                    'required' => true,
                    'class' => '',
                ],
            ])
            ->add('start', TimeType::class, [
                'label' => 'Heure de début:',
                'disabled' => true,  // Désactivé par défaut
                'attr' => [
                    'required' => true,
                    'class' => '',
                ],
            ])
            ->add('end_reservation', TimeType::class, [
                'label' => 'Heure de fin:',
                'disabled' => true,  // Désactivé par défaut
                'attr' => [
                    'required' => true,
                    'class' => '',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Réserver',
                'attr' => [
                    'class' => '',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
