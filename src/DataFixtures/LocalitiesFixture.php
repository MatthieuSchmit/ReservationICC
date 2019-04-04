<?php

namespace App\DataFixtures;

use App\Entity\Locality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;
use Doctrine\Common\Persistence\ObjectManager;

class LocalitiesFixture extends Fixture
{
    public function load(ObjectManager $manager)

    {
        $faker = Faker\Factory::create('fr_FR');

        for($i=0; $i<100;$i++)
        {

            $Localities = new Locality();
            $Localities->setLocality($faker->city);
            $Localities->setPostalCode($faker->postcode);
            $manager->persist($Localities);
        }






        $manager->flush();
    }
}
