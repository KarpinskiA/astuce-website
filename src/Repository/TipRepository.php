<?php

namespace App\Repository;

use App\Entity\Tip;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tip>
 */
class TipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tip::class);
    }

    /**
     * Finds detailed information about a specific tip by its slug
     * 
     * @param int $id The unique id of the tip
     * @return array|null Returns an array containing the tip and its related data, or null if not found
     */
    public function findDetailOfOneTip(int $id): ?array
    {
        // This query fetches a single tip with all its related entities
        $result = $this->createQueryBuilder('t')
            ->andWhere('t.id = :id')
            ->setParameter('id', $id)
            ->leftJoin('t.quantities', 'q')
            ->addSelect('q')
            ->leftJoin('q.ingredient', 'ing')
            ->addSelect('ing')
            ->leftJoin('t.materials', 'm')
            ->addSelect('m')
            ->leftJoin('t.steps', 's')
            ->addSelect('s')
            ->leftJoin('t.instructions', 'i')
            ->addSelect('i')
            ->leftJoin('t.user', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getOneOrNullResult();

        // If no tip is found, return null
        if (!$result) {
            return null;
        }

        // Prepare the data to be sent to the view
        $ingredientQuantities = array_map(
            function ($quantity) {
                return [
                    'quantity' => $quantity->getQuantity(),
                    'unit' => $quantity->getUnit(),
                    'name' => $quantity->getIngredient()->getName()
                ];
            },
            $result->getQuantities()->toArray()
        );

        return [
            'tip' => $result,
            'ingredientQuantities' => $ingredientQuantities,
        ];
    }

    //    /**
    //     * @return Tip[] Returns an array of Tip objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tip
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
