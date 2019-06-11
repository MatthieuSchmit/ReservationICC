<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {

    /**
     * @Route("/admin", name="admin")
     */
    public function index() {
        return $this->render('admin/index.html.twig', []);
    }

    /**
     * @Route("/admin/show", name="admin_add_show")
     * @IsGranted("ROLE_ADMIN")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addShow() {
        return $this->render('admin/addShow.html.twig', []);
    }

}
