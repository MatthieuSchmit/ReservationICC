<?php

namespace App\Controller;

use App\Entity\Representation;
use App\Entity\Show;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepresentationController extends AbstractController
{
    /**
     * @Route("/representation", name="representation")
     */
    public function index()
    {
        return $this->render('representation/index.html.twig', [
            'controller_name' => 'RepresentationController',
        ]);
    }

    /**
     * @Route(
     *     path="/admin/representation/store",
     *     name="representation_store",
     *     methods={"POST"},
     * )
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function store(Request $request) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $show = $doctrine->getRepository(Show::class)->find($request->get('show_id'));

        $representation = new Representation();
        $representation->setDate(new \DateTime($request->get('date')));
        $representation->setShowId($show);
        $representation->setLocation($show->getLocation());
        $em->persist($representation);
        $em->flush();

        return new Response('Representation Created !', 201);
    }
}
