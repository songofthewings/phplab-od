<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Search;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture {
	public function load( ObjectManager $manager ) {
		$faker = Factory::create();

		for ( $i = 0; $i < 5; $i ++ ) {
			$user = new User();
			$user->setName( $faker->userName );
			$user->setPassword( $faker->password );
			$user->setEmail( $faker->email );
			$user->setFavourite( $faker->words( $nb = 10, $asText = false ) );
			$manager->persist( $user );
		}
		for ( $i = 0; $i < 150; $i ++ ) {
			$search = new Search();
			$search->setWord( $faker->word );
			$search->getSearchCount( $faker->randomDigit );
			$manager->persist( $search );
		}
		$manager->flush();
	}
}
