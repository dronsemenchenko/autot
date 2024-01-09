<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\City;
use App\Entity\Storage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // остатки на всех складах
    public function getAvailableList(): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, sum(s.amount)')
            ->join('p.productInStorages', 's')
            ->where('s.amount > 0')
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    // остатки на всех складах в городе
    public function getAvailableListByCity(City $city): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, sum(s.amount)')
            ->join('p.productInStorages', 's')
            ->join('s.storage', 'ss')
            ->where('s.amount > 0')
            ->andWhere('ss.city = :city')
            ->setParameter('city', $city)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function getAvailableListByStorage(Storage $storage): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.id, p.name, sum(s.amount)')
            ->join('p.productInStorages', 's')
            ->where('s.amount > 0')
            ->andWhere('s.storage = :storage')
            ->setParameter('storage', $storage)
            ->groupBy('p.id')
            ->getQuery()
            ->getResult();
    }

    public function findOneByName($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
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

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
