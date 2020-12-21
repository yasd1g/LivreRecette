<?php

namespace App\Repository;

use App\Entity\Recipe;
use App\Entity\RecipeSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function selectAllRecipes(RecipeSearch $search)
    {

        $query = $this->selectAllRecipesQuery();

        if ($search->getCategory()){
            $query = $query->andWhere('r.category = :cat')
                           ->setParameter('cat', $search->getCategory());
        }

        if ($search->getDifficulty()){
            $query = $query->andWhere('r.difficulty <= :diff')
                ->setParameter('diff', $search->getDifficulty());
        }

        if ($search->getQ()){
            $query = $query
                ->andWhere('r.title LIKE :text')
                ->setParameter('text', "%{$search->getQ()}%");
        }

        return $query
            ->getQuery()
      ;
    }

    public function selectAllRecipesQuery()
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ;


    }

    public function findBestRecipes($limit)
    {
        return $this->createQueryBuilder('r')
            ->select('r as recipe', 'AVG(c.rating) as avgRatings')
            ->join('r.comments','c')
            ->groupBy('r')
            ->orderBy('avgRatings', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

    }

    // /**
    //  * @return Recipe[] Returns an array of Recipe objects
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
    public function findOneBySomeField($value): ?Recipe
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
