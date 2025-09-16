<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Paroisse;
use App\Entity\Doyenne;
use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PersonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $sectorRepo = $manager->getRepository(Sector::class);
        $doyenneRepo = $manager->getRepository(Doyenne::class);
        $paroisseRepo = $manager->getRepository(Paroisse::class);

        // 🔹 Récupération des références
        $sector = $sectorRepo->findOneBy(['name' => 'KIN EST']);
        $doyenne = $doyenneRepo->findOneBy(['name' => 'Saint Noé Mawaggali']);
        $paroisse = $paroisseRepo->findOneBy(['name' => 'Paroisse Saint Noé Mawaggali']);

        // 🔹 Debug pour vérifier qu’on a bien récupéré les entités
        if (!$sector || !$doyenne || !$paroisse) {
            dump($sector, $doyenne, $paroisse);
            throw new \Exception("⚠️ Assurez-vous que le secteur, la doyenné et la paroisse existent avant de créer les personnes.");
        }

        $peopleData = [
            [
                'fullName' => 'Josué Ngoma',
                'phoneNumber' => '0898464570',
                'gender' => 'Frère',
                'isDicoces' => false,
                'isDecanal' => false,
                'isNoyau' => false,
            ],
            [
                'fullName' => 'Divine Kangala',
                'phoneNumber' => '0811721417',
                'gender' => 'Soeur',
                'isDicoces' => true,
                'isDecanal' => true,
                'isNoyau' => true,
            ],
            [
                'fullName' => 'Bénie Kangala',
                'phoneNumber' => '0811721418',
                'gender' => 'Soeur',
                'isDicoces' => false,
                'isDecanal' => true,
                'isNoyau' => true,
            ],
            [
                'fullName' => 'Chadrack Aasa',
                'phoneNumber' => '0811721419',
                'gender' => 'Frère',
                'isDicoces' => false,
                'isDecanal' => false,
                'isNoyau' => true,
            ],
        ];

        foreach ($peopleData as $data) {
            $exists = $manager->getRepository(Person::class)->findOneBy(['phoneNumber' => $data['phoneNumber']]);
            if (!$exists) {
                    $person = new Person();
                    $person->setFullName($data['fullName'])
                        ->setPhoneNumber($data['phoneNumber'])
                        ->setGender($data['gender'])
                        ->setIsDicoces($data['isDicoces'])
                        ->setIsDecanal($data['isDecanal'])
                        ->setIsNoyau($data['isNoyau'])
                        ->setDoyenne($doyenne)
                        ->setParoisse($paroisse)
                        ->setSector($sector);

                    $manager->persist($person);
                }

            // 🔹 Debug pour vérifier que l’entité est bien persistée
            dump("Persisting person:", $person->getFullName());
        }

        $manager->flush();

        // 🔹 Debug final après flush
        dump("✅ Person fixtures loaded successfully!");
    }

    public function getDependencies(): array
    {
        return [
            SectorFixtures::class,
            DoyenneFixtures::class,
            ParoisseFixtures::class,
        ];
    }
}
