<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture {

    // To encode user's password
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {

        // Faker => Crée des données bidons
        // Ici, des données en FR
        // $faker = Faker\Factory::create('fr_FR');

        $users = [
            ['login' => 'admin', 'password' => 'admin', 'roles' => ['ROLE_ADMIN'], 'firstname' => 'John', 'lastname' => 'Doe', 'email' => 'john@doe.me', 'language' => 'FR']
        ];

        foreach ($users as $u) {
            $user = new User();
            $user->setLogin($u['login']);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $u['password']));
            $user->setRoles($u['roles']);
            $user->setFirstname($u['firstname']);
            $user->setLastname($u['lastname']);
            $user->setEmail($u['email']);
            $user->setLanguage($u['language']);

            $manager->persist($user);
        }

        $manager->flush();

    }
}
