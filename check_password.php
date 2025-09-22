<?php
// check_password.php

require __DIR__ . '/vendor/autoload.php';

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\MigratingPasswordHasher;

// Crée un user factice avec le hash de la base
$user = new User();
$user->setPassword('$2y$13$HyFwSeKuldMRu/ERrHF75uNd.iEuUS7TbBdpBktZZjARz8ijDwJlu'); // hash en base

// Hasher factory Symfony par défaut
$factory = new PasswordHasherFactory([
    User::class => ['algorithm' => 'auto'],
]);

$hasher = new UserPasswordHasher($factory);

// Vérifie le mot de passe en clair
$plainPassword = 'mijerca2025';

if ($hasher->isPasswordValid($user, $plainPassword)) {
    echo "✅ Mot de passe correct\n";
} else {
    echo "❌ Mot de passe incorrect\n";
}
