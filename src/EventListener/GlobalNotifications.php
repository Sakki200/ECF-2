<?php

namespace App\EventListener;

use App\Repository\ReservationRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class GlobalNotifications
{
    private $res;
    private $security;

    public function __construct(ReservationRepository $res, Security $security)
    {
        $this->res = $res;
        $this->security = $security;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // Vérifier si l'utilisateur est admin
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $reservationsPending = $this->res->findBy(['is_validated' => "pending"]);
            $lastReservations = $this->res->findBy(['is_validated' => "pending"], ['updated_at' => 'DESC'], 3);
            // Ajouter des informations dans la requête
            $request->attributes->set('reservationsPending', $reservationsPending);
            $request->attributes->set('lastReservations', $lastReservations);
        }
    }
}
