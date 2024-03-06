<?php

namespace App\DataFixtures;

use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 100; $i++) {
            $image = new Images();
            $image->setName("/tmp/" . $this->slugger->slug($faker->text(25))->lower() . ".png");
            $product = $this->getReference("prod-" . rand(1, 20));
            $image->setProducts($product);
            $manager->persist($image);
        }

        for ($i = 0; $i < 3; $i++) {
            $image = new Images();
            $image->setName("ecran0" . $i + 1 . ".jpg");
            $product = $this->getReference("prod-21");
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ProductsFixtures::class];
    }
}
