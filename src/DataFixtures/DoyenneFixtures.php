<?php

namespace App\DataFixtures;

use App\Entity\Doyenne;
use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DoyenneFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sectorRepo = $manager->getRepository(Sector::class);

        $kinEst = $sectorRepo->findOneBy(['name' => 'KIN EST']);
        $kinCentre = $sectorRepo->findOneBy(['name' => 'KIN CENTRE']);
        $kinOuest = $sectorRepo->findOneBy(['name' => 'KIN OUEST']);

        // Vérification que tous les secteurs existent
        if (!$kinEst || !$kinCentre || !$kinOuest) {
            throw new \Exception("Un ou plusieurs secteurs n'existent pas. Veuillez d'abord charger SectorFixtures.");
        }

        $doyennesData = [
            ['name' => 'Saint Noé Mawaggali', 'sector' => $kinEst],
            ['name' => 'Saint Raphaël', 'sector' => $kinCentre],
            ['name' => 'Saint Joseph', 'sector' => $kinOuest],
        ];

        foreach ($doyennesData as $data) {
            $exists = $manager->getRepository(Doyenne::class)->findOneBy([
                'name' => $data['name'],
                'sector' => $data['sector'],
            ]);

            if (!$exists) {
                $doyenne = new Doyenne();
                $doyenne->setName($data['name']);
                $doyenne->setSector($data['sector']);
                $manager->persist($doyenne);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SectorFixtures::class,
        ];
    }
}
