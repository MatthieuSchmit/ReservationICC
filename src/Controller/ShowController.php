<?php

namespace App\Controller;

use App\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController {

    /**
     * @Route("/show", name="show")
     */
    public function index() {
        $shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
        return $this->render('show/index.html.twig', [
            'shows' => $shows,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="show_getshow")
     *
     * @return Response
     */
    public function show(Show $show){

        return $this->render('show/info.html.twig', [
            'show' => $show
        ]);
    }
}
