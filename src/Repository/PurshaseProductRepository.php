<?php

namespace App\Repository;

use App\Entity\PurshaseProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PurshaseProduct>
 *
 * @method PurshaseProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurshaseProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurshaseProduct[]    findAll()
 * @method PurshaseProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurshaseProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurshaseProduct::class);
    }

    // used for test
    public function remove(PurshaseProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PurshaseProduct[] Returns an array of PurshaseProduct objects
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

//    public function findOneBySomeField($value): ?PurshaseProduct
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
