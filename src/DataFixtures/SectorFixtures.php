<?php

namespace App\DataFixtures;

use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectorFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sectors = ['KIN EST', 'KIN CENTRE', 'KIN OUEST'];

    foreach ($sectors as $name) {
        $exists = $manager->getRepository(Sector::class)->findOneBy(['name' => $name]);

        if (!$exists) {
            $sector = new Sector();
            $sector->setName($name);
            $manager->persist($sector);
        }
    }

        $manager->flush();
    }
}


// Pour charger les data de Sector dans la bd faire
// php bin/console doctrine:fixtures:load --append

