<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\EquipmentRepository;
use App\Repository\ErgonomicRepository;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RoomController extends AbstractController
{
    #[Route('/rooms', name: 'app_rooms_all', methods: 'GET')]
    public function all(RoomRepository $roomRepository, 
        EquipmentRepository $equipmentRepository,
        ErgonomicRepository $ergonomicRepository,
        Request $request): Response
    {
        $capacity = $request->query->get('capacity');
        $equipmentIds = $request->query->all('equipment');
        $ergonomicIds = $request->query->all('ergonomics');
        
        $rooms = $roomRepository->findBySearchCriteria($capacity, $equipmentIds, $ergonomicIds);
        $equipments = $equipmentRepository->findAll();
        $ergonomics = $ergonomicRepository->findAll();


        return $this->render('room/all.html.twig', [
            'rooms' => $rooms,
            'equipments' => $equipments,
            'ergonomics' => $ergonomics,
        ]);
    }

    #[Route('/rooms/{id}', name: 'app_room_show', methods: 'GET')]
    public function show(Room $room): Response
    {
        return $this->render('room/show.html.twig', [
            'room' => $room,
        ]);
    }
}