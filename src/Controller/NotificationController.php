<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
    public function show(ReservationRepository $res): Response
    {
        $reservationPending = $res->findBy(['is_validated' => false]);
        dd($reservationPending);

        return $this->render('notification/show.html.twig', ['reservationPending' => $reservationPending]);
    }
    #[Route('/notification/{id}', name: 'app_notification_validation')]
    public function validation(int $id, EntityManagerInterface $em, ReservationRepository $res): Response
    {
        $user = $this->getUser();
        $reservation = $res->findOneById($id);
        $reservation->setIsValidated(true);

        $notification = new Notification;
        $notification
            ->setUser($user)
            ->setContent("La réservation n°" . $reservation->getId() . " a été validé par " . $user->getUsername() . " pour la salle " . $reservation->getRoom()->getName())
        ;

        $em->persist($notification);
        $em->flush();

        return $this->redirectToRoute('app_notification');
    }
}
