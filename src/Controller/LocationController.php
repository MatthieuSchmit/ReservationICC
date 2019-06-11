<?php

namespace App\Controller;

use App\Entity\Location;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    /**
     * @Route("/location", name="all_location")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listLocations() {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();
        return $this->render('location/list.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     * @Route("admin/location/add", name="create_location")
     * @IsGranted("ROLE_ADMIN")
     */
    public function add() {
        return $this->render('location/add.html.twig', []);
    }
}
