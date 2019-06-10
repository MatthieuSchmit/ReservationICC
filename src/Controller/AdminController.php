<?php

namespace App\Controller;

use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {

    /**
     * @Route("/admin/shows", name="admin_shows_index")
     */
    public function index(ShowRepository $repo) {


        return $this->render('admin/show/shows.html.twig', [
            'shows' => $repo->findAll()
        ]);
    }
}
