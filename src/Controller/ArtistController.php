<?php

namespace App\Controller;

use App\Entity\Artist;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArtistController extends AbstractController {

    /**
     * @Route("/artist", name="artist")
     */
    public function index() {

        $artists = $this->getDoctrine()->getRepository(Artist::class)->findAll();

        return $this->render('artist/home.html.twig', [
            'controller_name' => 'ArtistController',
            'artists' => $artists
        ]);
    }
}
