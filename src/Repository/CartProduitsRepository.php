<?php

namespace App\Repository;

use App\Entity\CartProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CartProduit|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartProduit|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartProduit[]    findAll()
 * @method CartProduit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartProduitsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CartProduit::class);
    }

//    /**
//     * @return CartProduit[] Returns an array of CartProduit objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartProduit
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
