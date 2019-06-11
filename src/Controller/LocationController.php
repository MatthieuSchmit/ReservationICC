<?php

namespace App\Controller;

use App\Entity\Locality;
use App\Entity\Location;
use App\Form\LocationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route(
     *     name="create_location",
     *     path="/admin/location/add",
     * )
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function add(Request $request) {
        $form = $this->createForm(LocationType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $location = new Location();
            $location->setCoverImage($data->getCoverImage());
            $location->setDescription($data->getDescription());
            $location->setSlug(str_replace(' ', '-', $data->getDesignation()));
            $location->setAddress($data->getAddress());
            $location->setDesignation($data->getDesignation());
            $location->setPhone($data->getPhone());
            $location->setWebsite($data->getWebsite());

            $l = $this->getDoctrine()->getRepository(Locality::class)->findAll()[0];
            $location->setLocality($l);


            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();
            return $this->redirectToRoute('location', ['slug' => $location->getSlug()]);
        }

        return $this->render('location/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
