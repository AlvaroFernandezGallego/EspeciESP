<?php

namespace App\Repository;

use App\Entity\Species;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Species>
 */
class SpeciesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Species::class);
        
    }

    public function findByFilters(string $search = '', array $categoryIds = [], array $statusIds = [])
    {
        $qb = $this->createQueryBuilder('s')
            ->leftJoin('s.category', 'c')
            ->leftJoin('s.status', 'st')
            ->addSelect('c', 'st');

        if ($search !== '') {
            $qb->andWhere('s.scientificName LIKE :search OR s.commonName LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        if (!empty($categoryIds)) {
            $qb->andWhere('c.id IN (:categoryIds)')
                ->setParameter('categoryIds', $categoryIds);
        }

        if (!empty($statusIds)) {
            $qb->andWhere('st.id IN (:statusIds)')
                ->setParameter('statusIds', $statusIds);
        }

        return $qb->getQuery()->getResult();
    }
}
