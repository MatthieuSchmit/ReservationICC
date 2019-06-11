<?php

namespace App\Controller;

use App\Entity\ArtistType;
use App\Entity\ArtistTypeShow;
use App\Entity\Location;
use App\Entity\Show;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends AbstractController {

    /**
     * @Route("/show", name="show")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index() {
        $shows = $this->getDoctrine()->getRepository(Show::class)->findAll();
        return $this->render('show/index.html.twig', [
            'shows' => $shows,
        ]);
    }

    /**
     * @Route("/show/{slug}", name="show_getshow")
     * @param Show $show
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Show $show){
        return $this->render('show/info.html.twig', [
            'show' => $show
        ]);
    }

    /**
     * @Route("/admin/show/add", name="show_add")
     * @IsGranted("ROLE_ADMIN")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function add() {
        $locations = $this->getDoctrine()->getRepository(Location::class)->findAll();
        $cast = $this->getDoctrine()->getRepository(ArtistType::class)->findAll();
        return $this->render('show/add.html.twig', [
            'locations' => $locations,
            'casts' => $cast,
        ]);
    }

    /**
     * @Route(
     *     path="/admin/show/store",
     *     name="show_store",
     *     methods={"POST"},
     * )
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $source = $request->get('source') ?? '';
        if($source == 'theatreContemporain') {
            $slug = $request->get('object');
            $show = $doctrine->getRepository(Show::class)->findBy(['slug' => $slug]);
            if(count($show) > 0) {
                return new Response('Show already existing !', 204);
            }
        }

        $show = new Show();

        $location = $doctrine->getRepository(Location::class)->find($request->get('location'));
        $show->setLocation($location);

        $show->setSlug($request->get('slug'));
        $show->setTitle($request->get('title'));
        $show->setPosterUrl($request->get('posterUrl'));
        $show->setCoverImage($request->get('posterUrl'));
        $show->setBookable(true);
        $show->setPrice($request->get('price'));
        $show->setDescription($request->get('description'));

        $em->persist($show);

        // Cast
        $casts = $request->get('casts');
        foreach ($casts as $cast) {
            $artistType = $doctrine->getRepository(ArtistType::class)->find($cast);
            $artistTypeShow = new ArtistTypeShow();
            $artistTypeShow->setShowId($show);
            $artistTypeShow->setArtistType($artistType);
            $em->persist($artistTypeShow);
        }

        $em->flush();

        return new Response('Show Created !', 201);

    }
}
