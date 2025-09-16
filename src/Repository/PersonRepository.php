<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Person>
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * Persiste et éventuellement flush une personne
     */
    public function save(Person $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Supprime et éventuellement flush une personne
     */
    public function remove(Person $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Trouver une personne par son numéro de téléphone
     */
    public function findOneByPhoneNumber(string $phoneNumber): ?Person
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.phoneNumber = :phone')
            ->setParameter('phone', $phoneNumber)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Retourne toutes les personnes d'un secteur
     *
     * @return Person[]
     */
    public function findBySector($sector): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.sector = :sector')
            ->setParameter('sector', $sector)
            ->orderBy('p.fullName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne toutes les personnes d'une doyenné
     *
     * @return Person[]
     */
    public function findByDoyenne($doyenne): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.doyenne = :doyenne')
            ->setParameter('doyenne', $doyenne)
            ->orderBy('p.fullName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Retourne toutes les personnes d'une paroisse
     *
     * @return Person[]
     */
    public function findByParoisse($paroisse): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.paroisse = :paroisse')
            ->setParameter('paroisse', $paroisse)
            ->orderBy('p.fullName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
