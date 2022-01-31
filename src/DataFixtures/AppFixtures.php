<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\Category;
use Bluemmb\Faker\PicsumPhotosProvider;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    protected $faker;

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 5; $i++) {
            $category = new Category;
            $this->faker = Factory::create();
            $category->setName($this->faker->word())
                ->setDescription($this->faker->text());
            $manager->persist($category);
        }

        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $this->faker = Factory::create();
            $this->faker->addProvider(new PicsumPhotosProvider($this->faker));
            $product->setName($this->faker->name($gender = null))
                ->setDescription($this->faker->text())
                ->setPrice($this->faker->randomDigit())
                ->setImage($this->faker->imageUrl(500, 500, true))
                ->setCategory($category);
            $manager->persist($product);
        }


        for ($i = 0; $i < 3; $i++) {
            $user = new User();
            $this->faker = Factory::create();
            $user->setEmail($this->faker->email())
                ->setRoles(['ROLE_USER'])
                ->setPassword($this->faker->password())
                ->setFirstname($this->faker->firstName())
                ->setLastname($this->faker->lastName())
                ->setAddress($this->faker->address())
                ->setPhoneNumber($this->faker->phoneNumber())
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($user);
        }

        $manager->flush();
    }
}
