<?php

namespace App\Controller;

use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController {

    /**
     * @Route("/location/{slug}", name="location")
     */
    public function index() {

        $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();

        return $this->render('location/index.html.twig', [
            'locations' => $locations,
        ]);
    }
}
