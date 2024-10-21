<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlanningController extends AbstractController
{
    #[Route('/planning', name: 'app_planning')]
    public function show(ReservationRepository $res, RoomRepository $rr): Response
    {
        if (isset($_GET['date'])) {
            $date = $_GET['date'] . ' 00:00:00';
        } else {
            $date = new \DateTime;
            $date = $date->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        }
        $validatedReservations = $res->findBy(['date_reservation' => new \DateTime($date), 'is_validated' => 'validated']);

        return $this->render('planning/show.html.twig', ['validatedReservations' => $validatedReservations, 'allRooms' => $rr->findAll(), 'date' => $date]);
    }
}
