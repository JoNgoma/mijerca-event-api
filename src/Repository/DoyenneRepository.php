<?php

namespace App\Repository;

use App\Entity\Doyenne;
use App\Entity\Sector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Doyenne>
 */
class DoyenneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doyenne::class);
    }

    /**
     * Trouver toutes les doyennés d’un secteur
     *
     * @return Doyenne[]
     */
    public function findBySector(Sector $sector): array
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.sector = :sector')
            ->setParameter('sector', $sector)
            ->orderBy('d.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouver une doyenné par son nom
     */
    public function findOneByName(string $name): ?Doyenne
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
