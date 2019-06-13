<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Form\NewArtistType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     *     requirements={"id"="\d+"}
     * )
     * @param Artist $data
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function info(Artist $data) {
        return $this->render('artist/info.html.twig', [
            'artist' => $data,
        ]);
    }

    /**
     * @Route(
     *     name="artist_add",
     *     path="/artist/add",
     * )
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function add(Request $request) {
        $form = $this->createForm(NewArtistType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $artist = new Artist();
            $artist->setFirstname($data->getFirstname());
            $artist->setLastname($data->getLastname());

            $em = $this->getDoctrine()->getManager();
            $em->persist($artist);
            $em->flush();
            return $this->redirectToRoute('artist_info', ['id' => $artist->getId()]);
        }

        return $this->render('artist/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
