<?php

namespace App\EventListener;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, entity: User::class)]
class UserPasswordHasher
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function prePersist(User $user): void
    {
        $this->hashPassword($user);
    }

    public function preUpdate(User $user): void
    {
        $this->hashPassword($user);
    }

    private function hashPassword(User $user): void
{
    $password = $user->getPassword();
    if ($password === null) {
        return;
    }

    // 🔹 Ne pas re-hasher si déjà hashé (commence par $2y$ pour bcrypt)
    if (str_starts_with($password, '$2y$')) {
        return;
    }

    $hashedPassword = $this->hasher->hashPassword($user, $password);
    $user->setPassword($hashedPassword);
}
}