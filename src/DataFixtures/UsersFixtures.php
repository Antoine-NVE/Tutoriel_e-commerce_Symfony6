<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin->setEmail("admin@demo.fr");
        $admin->setLastname("Gambier");
        $admin->setFirstname("Benoit");
        $admin->setAddress("12 rue du Port");
        $admin->setZipcode("75001");
        $admin->setCity("Paris");
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, "admin"));
        $admin->setRoles(["ROLE_ADMIN"]);

        $manager->persist($admin);

        $faker = Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 5; $i++) {
            $user = new Users();
            $user->setEmail($faker->email());
            $user->setLastname($faker->lastName());
            $user->setFirstname($faker->firstName());
            $user->setAddress($faker->streetAddress());
            $user->setZipcode($faker->postcode());
            $user->setCity($faker->city());
            $user->setPassword($this->passwordEncoder->hashPassword($user, "secret"));

            $manager->persist($user);
        }

        $manager->flush();
    }
}
