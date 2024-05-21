<?php

namespace App\Repository;

use App\Entity\PictureDishes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PictureDishes>
 */
class PictureDishesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PictureDishes::class);
    }

    public function findPictureName(int $dishesId)  // : array
    {
        $requete = $this->createQueryBuilder('p')
            ->select('p.name AS name')
            ->andWhere('p.dishes = :dishesId')
            ->setParameter('dishesId', $dishesId)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;

        return $requete;
    }

    //    /**
    //     * @return PictureDishes[] Returns an array of PictureDishes objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PictureDishes
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
