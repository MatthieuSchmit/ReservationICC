<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\ArtistType;
use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArtistTypeFixture extends Fixture {

    public function load(ObjectManager $manager) {

        // Types
        $types = ['Auteur', 'Acteur', 'Producteur', 'Metteur en scene'];
        foreach ($types as $key=>$type) {
            $t = new Type();
            $t->setType($type);
            $manager->persist($t);
            $this->addReference('type_' . $key, $t);
        }

        // Add to artist
        for ($i=0;$i<50;$i++) {

            $at = new ArtistType();
            $at->setArtist($this->getReference( 'artist_' . $i));
            $at->setType($this->getReference('type_' . rand(0,3)));

            $manager->persist($at);

        }

        $manager->flush();
    }
}
