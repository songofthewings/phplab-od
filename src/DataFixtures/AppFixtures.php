<?php

namespace App\DataFixtures;

use App\Entity\TagCloud;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 50; $i++) {
            $tag = new TagCloud();
            $tag->setName('word '.$i);
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
