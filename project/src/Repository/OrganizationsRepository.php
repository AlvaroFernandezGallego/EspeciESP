<?php

namespace App\Repository;

use App\Entity\Organizations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Organizations>
 */
class OrganizationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Organizations::class);
    }

    public function findByRegionName(string $regionName): array
    {
        return $this->createQueryBuilder('o')
            ->join('o.region', 'r')
            ->andWhere('r.name = :name')
            ->setParameter('name', $regionName)
            ->getQuery()
            ->getResult();
    }
}