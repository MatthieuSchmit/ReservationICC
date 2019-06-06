<?php

namespace App\DataFixtures;

use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LocationFixture extends Fixture {

    public function load(ObjectManager $manager) {

        $faker = Faker\Factory::create('fr_FR');

        for($i=0;$i<20;$i++) {
            $locality = rand(0,99);

            $location = new Location();
            $location->setSlug('lorem');
            $location->setDesignation($faker->domainName);
            $location->setAddress($faker->address);
            $location->setWebsite($faker->url);
            $location->setPhone($faker->phoneNumber);
            $location->setLocality($this->getReference('locality_' . $locality));

            $manager->persist($location);

            $this->addReference('location_' . $i, $location);

        }

        $manager->flush();
    }
}