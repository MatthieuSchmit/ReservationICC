<?php

namespace App\DataFixtures;

use App\Entity\Representation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ZRepresentationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i=0;$i<20;$i++) {
            $show = rand(0,20);
            $date = $faker->dateTime();

            $representation = new Representation();
            $representation->setDate($date);
            $representation->setShowId($this->getReference('show_' .  $show));
            $representation->setLocation($this->getReference('location_' . rand(0,19) ));



            $manager->persist($representation);

            $this->addReference('representation_' . $i, $representation);

        }

        $manager->flush();
    }
}
