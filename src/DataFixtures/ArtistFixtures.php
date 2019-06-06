<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ArtistFixtures extends Fixture {

    public function load(ObjectManager $manager) {

        $faker = Faker\Factory::create('fr_FR');

        for($i=0; $i<50;$i++)  {
            $artist = new Artist();
            $artist->setFirstname($faker->firstName);
            $artist->setLastname($faker->lastName);
            $manager->persist($artist);

            $this->addReference('artist_' . $i, $artist);

        }

        $manager->flush();
    }
}
