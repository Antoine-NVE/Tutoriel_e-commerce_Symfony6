<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 20; $i++) {
            $product = new Products();
            $product->setName($faker->text(15));
            $product->setDescription($faker->text());
            $product->setSlug($this->slugger->slug($product->getName())->lower());
            $product->setPrice($faker->numberBetween(900, 150000));
            $product->setStock($faker->numberBetween(0, 10));

            $category = $this->getReference("cat-" . [2, 3, 4, 6, 7, 8][rand(0, 5)]);
            $product->setCategories($category);

            $this->setReference("prod-" . $i + 1, $product);

            $manager->persist($product);
        }

        $product = new Products();
        $product->setName("Joli écran");
        $product->setDescription("Un très joli écran qui sert à afficher des choses");
        $product->setSlug($this->slugger->slug($product->getName())->lower());
        $product->setPrice($faker->numberBetween(900, 150000));
        $product->setStock($faker->numberBetween(0, 10));

        $category = $this->getReference("cat-3");
        $product->setCategories($category);

        $this->setReference("prod-21", $product);

        $manager->persist($product);

        $manager->flush();
    }
}
