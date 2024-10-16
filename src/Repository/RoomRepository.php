<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Room>
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    public function findBySearchCriteria(?int $capacity, array $equipmentIds, array $ergonomicIds)
    {
        $qb = $this->createQueryBuilder('r');
    
        if ($capacity !== null) {
            $qb->andWhere('r.capacity >= :capacity')
                ->setParameter('capacity', $capacity);
        }
    
        if (!empty($equipmentIds)) {
            $qb->leftJoin('r.roomEquipment', 're')
                ->leftJoin('re.equipment', 'e')
                ->andWhere('e.id IN (:equipmentIds)')
                ->setParameter('equipmentIds', $equipmentIds);
        }
    
        if (!empty($ergonomicIds)) {
            $qb->leftJoin('r.room_ergonomics', 'rerg')
                ->leftJoin('rerg.ergonomic', 'erg')
                ->andWhere('erg.id IN (:ergonomicIds)')
                ->setParameter('ergonomicIds', $ergonomicIds);
        }
    
        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Room[] Returns an array of Room objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Room
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
