<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $disabledHours = $options['disabled_hours'];

        $builder
            ->add('date_reservation', DateType::class, [
                'label' => 'Date de réservation:',
                'widget' => 'single_text',
                'attr' => [
                    'required' => true,
                    'class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300', // Classes Tailwind
                ],
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-700 mb-1' // Style de label
                ]
            ])
            ->add('start', ChoiceType::class, [
                'choices'  => [
                    '9h' => 9,
                    '10h' => 10,
                    '11h' => 11,
                    '12h' => 12,
                    '13h' => 13,
                    '14h' => 14,
                    '15h' => 15,
                    '16h' => 16,
                    '17h' => 17,
                    '18h' => 18,
                    '19h' => 19,
                ],
                'placeholder' => 'Sélectionnez une heure',
                'label' => 'Heure de début:',
                'attr' => [
                    'required' => true,
                    'class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300',
                ],
                'choice_attr' => function ($value) use ($disabledHours) {
                    return in_array($value, $disabledHours) ? ['disabled' => 'true', 'class' => 'text-gray-400 bg-gray-200 cursor-not-allowed'] : [];
                },
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-700 mb-1'
                ]
            ])
            ->add('end_reservation', ChoiceType::class, [
                'choices'  => [
                    '10h' => 10,
                    '11h' => 11,
                    '12h' => 12,
                    '13h' => 13,
                    '14h' => 14,
                    '15h' => 15,
                    '16h' => 16,
                    '17h' => 17,
                    '18h' => 18,
                    '19h' => 19,
                    '20h' => 20
                ],
                'placeholder' => 'Sélectionnez une heure',
                'label' => 'Heure de fin:',
                'attr' => [
                    'required' => true,
                    'class' => 'block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300',
                ],
                'choice_attr' => function ($value) use ($disabledHours) {
                    return in_array($value - 1, $disabledHours) ? ['disabled' => 'true', 'class' => 'text-gray-400 bg-gray-200 cursor-not-allowed'] : [];
                },
                'label_attr' => [
                    'class' => 'block text-sm font-medium text-gray-700 mb-1'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Réserver',
                'attr' => [
                    'class' => 'bg-orange-300 text-white font-bold py-2 px-4 rounded hover:bg-orange-500 transition ease-in-out duration-300 mt-6',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'disabled_hours' => [], // Définir l'option pour le tableau d'heures
        ]);
    }
}
