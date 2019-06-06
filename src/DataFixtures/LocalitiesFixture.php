<?php

namespace App\DataFixtures;

use App\Entity\Locality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Doctrine\Common\Persistence\ObjectManager;

class LocalitiesFixture extends Fixture {

    public function load(ObjectManager $manager) {

        $faker = Faker\Factory::create('fr_FR');

        for($i=0; $i<100;$i++) {
            $locality = new Locality();
            $locality->setLocality($faker->city);
            $locality->setPostalCode($faker->postcode);
            $manager->persist($locality);

            $this->addReference('locality_' . $i, $locality);
        }

        $manager->flush();
    }
}
