<?php

namespace App\Repository;

use App\Entity\PurshaseStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PurshaseStatus>
 *
 * @method PurshaseStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurshaseStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurshaseStatus[]    findAll()
 * @method PurshaseStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurshaseStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurshaseStatus::class);
    }

    public function findOneByName($value): ?PurshaseStatus
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return PurshaseStatus[] Returns an array of PurshaseStatus objects
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

    //    public function findOneBySomeField($value): ?PurshaseStatus
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
