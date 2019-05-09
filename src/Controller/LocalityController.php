<?php

namespace App\Controller;

use App\Entity\Locality;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LocalityController extends AbstractController
{
    /**
     * @Route("/locality", name="locality")
     */
    public function index() {

        $localities = $this->getDoctrine()->getRepository(Locality::class)->findAll();



        return $this->render('locality/index.html.twig', [
            'localities'=>$localities,
        ]);
    }
}
