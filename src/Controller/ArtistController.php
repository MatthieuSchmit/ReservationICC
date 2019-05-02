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

        return $this->render('artist/index.html.twig', [
            'controller_name' => 'ArtistController',
            'artists' => $artists
        ]);
    }

    /**
     * @Route(
     *     name="artist_info",
     *     path="/artist/{id}",
     *     methods={"GET"},
     * )
     * @param $id
     */
    public function info($id) {
        $artist = $this->getDoctrine()->getRepository(Artist::class)->findOrFail($id);
        return $this->render('artist/info.html.twig', [
            'artist' => $artist,
        ]);
    }
}
