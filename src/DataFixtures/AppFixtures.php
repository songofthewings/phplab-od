<?php

namespace App\DataFixtures;

use App\Entity\Search;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {
	public function load( ObjectManager $manager ) {
		$faker = Factory::create();

		for ( $i = 0; $i < 60; $i ++ ) {
			$search = new Search();
			$search->setWord( $faker->word );
			$search->setSearchCount( $faker->randomDigitNot(0) );
			$manager->persist( $search );
		}
		$manager->flush();
	}
}
