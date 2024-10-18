<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

// #[IsGranted('IS_AUTHENTICATED_FULLY')]
class ReservationController extends AbstractController
{
    #[Route('/reservation/{id}', name: 'app_reservation_verif', methods: ['GET', 'POST'])]
    public function verif(int $id, Request $request, RoomRepository $rr, ReservationRepository $res, EntityManagerInterface $em): Response|RedirectResponse
    {
        $user = $this->getUser();
        $room = $rr->findOneById($id);
        $timesTaken = []; // Tableau pour stocker les créneaux horaires déjà pris

        if (isset($_GET['date'])) {
            $chosenDate = \DateTime::createFromFormat('Y-m-d', $_GET['date']) ?? ""; // Récupération de la date dans l'url
            $sameDays = $res->findByDate($chosenDate->setTime(0, 0, 0), $room); // Récupération des réservations existantes pour la même date
            foreach ($sameDays as $day) {
                $start = $day->getStart(); // Heure de début d'une réservation existante
                $end = $day->getEndReservation(); // Heure de fin d'une réservation existante

                // Remplir le tableau des créneaux horaires déjà pris
                foreach (range($start, $end - 1) as $number) {
                    array_push($timesTaken, $number);
                }
            }
        }        
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation, [
            'disabled_hours' => $timesTaken ?? [],
        ]); // Chargement du formulaire
        $form = $form->handleRequest($request); // Traitement des données soumises

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération des données du formulaire : date, heure de début et de fin de la réservation
            $chosenStart = $form->get('start')->getData();
            $chosenEnd = $form->get('end_reservation')->getData();

            $currentUserSelectedTimes = []; // Tableau pour stocker les créneaux horaires choisis
            $interrupt = false; // Variable pour détecter les conflits de réservation

            // Remplir le tableau des créneaux horaires choisis (plage de temps)
            foreach (range($chosenStart, $chosenEnd - 1) as $number) {
                array_push($currentUserSelectedTimes, $number);
            }

            // Parcourir les créneaux choisis pour vérifier si l'un d'eux est déjà réservé
            foreach ($currentUserSelectedTimes as $time) {
                if (in_array($time, $timesTaken)) { // Si un conflit est détecté
                    $interrupt = true; // On marque qu'il y a un conflit
                    break; // Sortir des deux boucles (éviter des calculs inutiles)
            }

                // Si un conflit de réservation est détecté
                if ($interrupt === true) {
                    $this->addFlash('error', 'Il y a conflit de réservation avec une autre réservation.');
                    return $this->redirectToRoute('app_room_show', ['id' => $id]);
                } else {
                    $reservation
                        ->setUser($user)
                        ->setRoom($room)
                        ->setValidated(false);

                    $em->persist($reservation);
                    $em->flush();

                    $this->addFlash('success', 'Votre réservation a bien été prise en compte, un administrateur la validera prochainement.');
                    return $this->redirectToRoute('app_room_show', ['id' => $id]);
                }
            }
        }
        // Si le formulaire n'est pas soumis ou n'est pas encore valide, rendre le formulaire
        return $this->render('reservation/verif.html.twig', [
            'room' => $room,
            'formReservation' => $form // Affichage du formulaire dans la vue
        ]);
    }
}
