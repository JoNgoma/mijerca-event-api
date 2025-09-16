<?php

namespace App\Repository;

use App\Entity\Paroisse;
use App\Entity\Sector;
use App\Entity\Doyenne;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Paroisse>
 */
class ParoisseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Paroisse::class);
    }

    /**
     * Trouver toutes les paroisses par secteur
     *
     * @return Paroisse[]
     */
    public function findBySector(Sector $sector): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sector = :sector')
            ->setParameter('sector', $sector)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouver toutes les paroisses par doyenne
     *
     * @return Paroisse[]
     */
    public function findByDoyenne(Doyenne $doyenne): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.doyenne = :doyenne')
            ->setParameter('doyenne', $doyenne)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouver une paroisse par son nom (insensible à la casse)
     */
    public function findOneByName(string $name): ?Paroisse
    {
        return $this->createQueryBuilder('p')
            ->andWhere('LOWER(p.name) = :name')
            ->setParameter('name', strtolower($name))
            ->getQuery()
            ->getOneOrNullResult();
    }
}
