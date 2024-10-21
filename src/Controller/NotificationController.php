<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function show(ReservationRepository $res, RoomRepository $rr): Response
    {
        $reservationsPending = $res->findBy(['is_validated' => "pending"], ['updated_at' => 'DESC']);
        $reservationsValidated = $res->findBy(['is_validated' => "validated"]);

        return $this->render('notification/show.html.twig', [
            'reservationsPending' => $reservationsPending,
            'reservationsValidated' => $reservationsValidated,
            'allRooms' => $rr->findAll()
        ]);
    }
    #[Route('/notification/v/{id}', name: 'app_notification_validation')]
    public function validation(int $id, Request $request, EntityManagerInterface $em, ReservationRepository $res): Response
    {
        $user = $this->getUser();
        $reservation = $res->findOneById($id);
        $reservation->setValidated("validated");

        $notification = new Notification;
        $notification
            ->setUser($user)
            ->setReservation($reservation)
            ->setContent("La réservation n°" . $reservation->getId() . " a été validé par " . $user->getUsername() . " pour la salle " . $reservation->getRoom()->getName())
        ;
        $em->persist($notification);
        $em->flush();

        $url = $request->headers->get('referer');
        return $this->redirect($url);
    }
    #[Route('/notification/r/{id}', name: 'app_notification_refuse')]
    public function refuse(int $id, Request $request, EntityManagerInterface $em, ReservationRepository $res): Response
    {
        $user = $this->getUser();
        $reservation = $res->findOneById($id);
        $reservation->setValidated("refused");

        $notification = new Notification;
        $notification
            ->setUser($user)
            ->setReservation($reservation)
            ->setContent("La réservation n°" . $reservation->getId() . " a été refusé par " . $user->getUsername() . " pour la salle " . $reservation->getRoom()->getName())
        ;

        $em->persist($notification);
        $em->flush();

        $url = $request->headers->get('referer');
        return $this->redirect($url);
    }
}
