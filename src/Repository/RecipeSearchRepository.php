<?php

namespace App\Repository;

use App\Entity\RecipeSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecipeSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecipeSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecipeSearch[]    findAll()
 * @method RecipeSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeSearch::class);
    }

    // /**
    //  * @return RecipeSearch[] Returns an array of RecipeSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecipeSearch
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
