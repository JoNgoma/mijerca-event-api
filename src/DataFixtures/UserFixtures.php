<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Person;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $personRepo = $manager->getRepository(Person::class);
        $userRepo = $manager->getRepository(User::class);

        $usersData = [
            [
                'phone' => '0898464570',
                'roles' => ['ROLE_ADMIN'],
            ],
            [
                'phone' => '0811721417',
                'roles' => ['ROLE_NOYAU', 'ROLE_DECANAL', 'ROLE_DIOCESE'],
            ],
            [
                'phone' => '0811721418',
                'roles' => ['ROLE_NOYAU', 'ROLE_DECANAL'],
            ],
            [
                'phone' => '0811721419',
                'roles' => ['ROLE_NOYAU'],
            ],
        ];

        foreach ($usersData as $data) {
            $person = $personRepo->findOneBy(['phoneNumber' => $data['phone']]);

            if (!$person) {
                dump("⚠️ Person not found for phone:", $data['phone']);
                continue;
            }

            // Vérifie si un User existe déjà pour cette Person
            $existingUser = $userRepo->findOneBy(['person' => $person]);
            if ($existingUser) {
                dump("ℹ️ User already exists for:", $person->getFullName(), "(", $person->getPhoneNumber(), ")");
                continue;
            }

            $user = new User();
            $user->setUsername($person->getPhoneNumber());
            $user->setRoles($data['roles']);
            $user->setPassword(
                $this->passwordHasher->hashPassword($user, 'mijerca2025')
            );
            $user->setPerson($person);

            $manager->persist($user);

            dump("✅ User created:", $person->getFullName(), "(", $person->getPhoneNumber(), ")");
        }

        $manager->flush();
        dump("🎉 All User fixtures loaded!");
    }

    public function getDependencies(): array
    {
        return [
            PersonFixtures::class,
        ];
    }
}
