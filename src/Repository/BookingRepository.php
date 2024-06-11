<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    public function deleteBooking(string $date): array
    {   
        return $this->createQueryBuilder('b')
            ->delete()
            ->Where('b.date < :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
        ;   
    }

    public function findBookingIfFull(string $schedulesOpen, string $schedulesClose): array
    {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.numberOfGuests)')
            ->andWhere('b.date BETWEEN :schedulesOpen AND :schedulesClose')
            ->setParameter('schedulesOpen', $schedulesOpen)
            ->setParameter('schedulesClose', $schedulesClose)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
    //     * @return Booking[] Returns an array of Booking objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Booking
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
