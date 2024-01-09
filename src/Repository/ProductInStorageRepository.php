<?php

namespace App\Repository;

use App\Entity\ProductInStorage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductInStorage>
 *
 * @method ProductInStorage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductInStorage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductInStorage[]    findAll()
 * @method ProductInStorage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductInStorageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductInStorage::class);
    }

    public function findOneByStorageAndProduct(string $product, string $storage): ?ProductInStorage
    {
        return $this->createQueryBuilder('c')
            ->join('c.product', 'p')
            ->join('c.storage', 's')
            ->andWhere('p.name = :product')
            ->andWhere('s.name = :storage')
            ->setParameter('product', $product)
            ->setParameter('storage', $storage)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // остатки на всех складах
    public function getAvailableList(): array
    {
        return $this->createQueryBuilder('ps')
            ->select('ps.id, p.id as product_id, p.name, ps.amount')
            ->join('ps.product', 'p')
            ->where('ps.amount > 0')
            ->getQuery()
            ->getResult();
    }

    public function save(ProductInStorage $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProductInStorage[] Returns an array of ProductInStorage objects
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

//    public function findOneBySomeField($value): ?ProductInStorage
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
