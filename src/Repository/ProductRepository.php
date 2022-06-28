<?php

namespace App\Repository;

use App\Entity\Product;
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

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Product[] Returns an array of Product objects
    */
   public function showByCategory($id): array
   {
       return $this->createQueryBuilder('product')
           ->andWhere('product.category = :id')
           ->setParameter('id', $id)
           ->orderBy('product.id', 'ASC')
           ->getQuery()
           ->getResult()
       ;
   }

   public function searchByName($name)
   {
       return $this->createQueryBuilder('product')
           ->andWhere('product.name LIKE :name')
           ->setParameter('name','%'. $name. '%')
           ->orderBy('product.id', 'DESC')
            ->getQuery()
            ->getResult()
       ;
   }
}
