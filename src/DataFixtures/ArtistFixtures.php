<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtistFixtures extends Fixture {

    public function load(ObjectManager $manager) {

        $artists = [
            ['firstname' => 'Bob', 'lastname' => 'Paddington'],
            ['firstname' => 'John', 'lastname' => 'Doe'],
            ['firstname' => 'James', 'lastname' => 'Smith']
        ];

        foreach ($artists as $artist) {
            $a = new Artist();
            $a->setFirstname($artist['firstname']);
            $a->setLastname($artist['lastname']);
            $manager->persist($a);
        }

        $manager->flush();
    }
}
