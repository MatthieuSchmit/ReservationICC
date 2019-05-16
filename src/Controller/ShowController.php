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
     * @Route(
     *     path="/show/{id}",
     *     name="show_info",
     *     methods={"GET"},
     *     requirements={"id"="\d+"}
     * )
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getShow($id) {
        $show = $this->getDoctrine()->getRepository(Show::class)->find($id);
        return $this->render('show/info.html.twig', [
            'show' => $show
        ]);
    }
}
