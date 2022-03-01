<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $post = new Post();
            $post->setTitle($faker->title);
            $post->setDescription($faker->text);
            $post->setCreatedAt($faker->dateTime());
            $post->setUpdatedAt($faker->dateTime());
            $manager->persist($post);
        }

        $manager->flush();
    }
}
