<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation_verif', methods: ['GET', 'POST'])]
    public function verif(int $id, Request $request, RoomRepository $rr, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ReservationType::class); // Chargement du formulaire
        $form = $form->handleRequest($request); // Traitement des données soumises

        $room = $rr->findOneById($id);
        $user = $this->getUser();

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération des données du formulaire : date, heure de début et de fin de la réservation
            $ChosenDate = $form->get('date_reservation')->getData();
            $ChosenStart = $form->get('start')->getData();
            $ChosenEnd = $form->get('end_reservation')->getData();

            $sameDays = $rr->findAllByDate($ChosenDate); // Récupération des réservations existantes pour la même date
            $timeSlot = []; // Tableau pour stocker les créneaux horaires choisis
            $interrupt = false; // Variable pour détecter les conflits de réservation

            // Remplir le tableau des créneaux horaires choisis (plage de temps)
            foreach (range($ChosenStart, $ChosenEnd - 1) as $number) {
                array_push($timeSlot, $number);
            }

            // Vérification de conflits de réservation sur la même plage horaire
            foreach ($sameDays as $day) {
                $start = $day->getStart(); // Heure de début d'une réservation existante
                $end = $day->getEndReservation(); // Heure de fin d'une réservation existante

                // Parcourir les créneaux choisis pour vérifier si l'un d'eux est déjà réservé
                foreach ($timeSlot as $time) {
                    if ($start <= $time && $end > $time) { // Si un conflit est détecté
                        $interrupt = true; // On marque qu'il y a un conflit
                        break 2; // Sortir des deux boucles (éviter des calculs inutiles)
                    }
                }
            }

            // Si un conflit de réservation est détecté
            if ($interrupt === true) {
                $this->addFlash('error', 'Il y a conflit de réservation avec une autre réservation.');
                return $this->redirectToRoute('app_room_show', ['id' => $id]);
            } else {
                $reservation = new Reservation();
                $reservation
                    ->setUser($user)
                    ->setRoom($room)
                    ->setValidated(false)
                    ->setStart($ChosenDate)
                    ->setEndReservation($ChosenStart)
                    ->setDateReservation($ChosenEnd);

                $em->persist($reservation);
                $em->flush();

                $this->addFlash('success', 'Votre réservation a bien été prise en compte, un administrateur la validera prochainement.');
                return $this->redirectToRoute('app_room_show', ['id' => $id]);
            }
        }

        // Si le formulaire n'est pas soumis ou n'est pas encore valide, rendre le formulaire
        return $this->render('reservation/verif.html.twig', [
            'room' => $room,
            'formReservation' => $form // Affichage du formulaire dans la vue
        ]);
    }
}
