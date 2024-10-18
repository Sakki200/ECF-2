<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findByDate($date, $room): array
    {
        return $this->createQueryBuilder('r')
            ->where('r.date_reservation = :d')
            ->andWhere('r.room = :room')
            ->andWhere('r.is_validated = :valid')
            ->setParameter('d', $date)
            ->setParameter('room', $room)
            ->setParameter('valid', false)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
