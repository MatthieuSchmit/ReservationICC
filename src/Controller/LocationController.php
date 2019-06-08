<?php

namespace App\Controller;

use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController {

    /**
     * @Route("/location/{slug}", name="location")
     *
     */
    public function index(Location $location) {

        return $this->render('location/index.html.twig', [
            'location' => $location,
        ]);
    }
}
