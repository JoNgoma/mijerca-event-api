<?php

namespace App\DataFixtures;

use App\Entity\Paroisse;
use App\Entity\Doyenne;
use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ParoisseFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sectorRepo = $manager->getRepository(Sector::class);
        $doyenneRepo = $manager->getRepository(Doyenne::class);

        // 🔹 Récupération des secteurs
        $kinEst = $sectorRepo->findOneBy(['name' => 'KIN EST']);
        $kinCentre = $sectorRepo->findOneBy(['name' => 'KIN CENTRE']);
        $kinOuest = $sectorRepo->findOneBy(['name' => 'KIN OUEST']);

        // 🔹 Récupération des doyennés
        $doyenneNoe = $doyenneRepo->findOneBy(['name' => 'Saint Noé Mawaggali']);
        $doyenneRaphael = $doyenneRepo->findOneBy(['name' => 'Saint Raphaël']);
        $doyenneJoseph = $doyenneRepo->findOneBy(['name' => 'Saint Joseph']);

        if (!$doyenneNoe || !$doyenneRaphael || !$doyenneJoseph) {
            throw new \Exception("Les doyennés doivent être chargés avant les paroisses.");
        }

        // 🔹 Paroisses prédéfinies
        $paroissesData = [
            ['name' => 'Paroisse Saint Noé Mawaggali', 'doyenne' => $doyenneNoe, 'sector' => $kinEst],
            ['name' => 'Paroisse Saint Raphaël', 'doyenne' => $doyenneRaphael, 'sector' => $kinCentre],
            ['name' => 'Paroisse Saint Joseph', 'doyenne' => $doyenneJoseph, 'sector' => $kinOuest],
            ['name' => 'Paroisse Saint François Xavier', 'doyenne' => $doyenneJoseph, 'sector' => $kinOuest],
        ];

        foreach ($paroissesData as $data) {
            $exists = $manager->getRepository(Paroisse::class)->findOneBy([
                'name' => $data['name'],
                'doyenne' => $data['doyenne'],
                'sector' => $data['sector'],
            ]);

            if (!$exists) {
                $paroisse = new Paroisse();
                $paroisse->setName($data['name']);
                $paroisse->setDoyenne($data['doyenne']);
                $paroisse->setSector($data['sector']);
                $manager->persist($paroisse);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            DoyenneFixtures::class, // ⬅ assure que les doyennés sont chargés avant
            SectorFixtures::class,  // ⬅ si nécessaire
        ];
    }
}
