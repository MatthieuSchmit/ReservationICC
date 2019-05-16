<?php

namespace App\DataFixtures;

use App\Entity\ArtistTypeShow;
use App\Entity\Show;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ShowFixture extends Fixture {

    public function load(ObjectManager $manager) {

        $faker = Faker\Factory::create('fr_FR');

        // Shows
        for ($i=0;$i<100;$i++) {
            $show = new Show();
            $show->setSlug($faker->slug(2,true));
            $show->setTitle($faker->text(50));
            $show->setPosterUrl($faker->url);
            $show->setLocation($this->getReference('location_' . rand(0,19)));
            $show->setBookable($faker->boolean);
            $show->setPrice($faker->randomFloat());

            $manager->persist($show);

            $this->addReference('show_' . $i, $show);
        }
        $manager->flush();


        // ArtisteTypeShow
        for($i=0;$i<100;$i++) {
            for($j=0;$j<rand(3,7);$j++) {
                $ats = new ArtistTypeShow();
                $ats->setArtistType($this->getReference('artistType_' . rand(0,49)));
                $ats->setShowId($this->getReference('show_' . $i));

                $manager->persist($ats);
            }
        }
        $manager->flush();


    }
}
