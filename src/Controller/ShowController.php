<?php

namespace App\Controller;

use App\Entity\Artist;
use App\Entity\ArtistType;
use App\Entity\ArtistTypeShow;
use App\Entity\Category;
use App\Entity\Location;
use App\Entity\Show;
use App\Entity\Type;
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
        $cats= $this->getDoctrine()->getRepository(Category::class)->findAll();
        $cast = $this->getDoctrine()->getRepository(ArtistType::class)->findAll();
        return $this->render('show/add.html.twig', [
            'locations' => $locations,
            'category' => $cats,
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

        $casts = $request->get('casts') ?? [];
        $source = $request->get('source') ?? '';
        if($source == 'theatreContemporain') {
            $slug = $request->get('slug');
            $show = $doctrine->getRepository(Show::class)->findBy(['slug' => $slug]);
            if(count($show) > 0) {
                return new Response('Show already existing !', 204);
            }

            // CAST
            foreach ($request->get('authors') as $item) {
                $type = $doctrine->getRepository(Type::class)->findOneBy(['type' => 'Auteur']);
                $artist = $doctrine->getRepository(Artist::class)
                    ->findOneBy([
                        'firstname' => $item['firstname'],
                        'lastname' => $item['lastname'],
                    ]);
                if ($artist == null) {
                    $artist = new Artist();
                    $artist->setFirstname($item['firstname']);
                    $artist->setLastname($item['lastname']);
                    $em->persist($artist);
                }
                $artistType = new ArtistType();
                $artistType->setArtist($artist);
                $artistType->setType($type);
                $em->persist($artistType);
                $em->flush();
                $casts[] = $artistType->getId();
            }
            foreach ($request->get('directors') as $item) {
                $type = $doctrine->getRepository(Type::class)->findOneBy(['type' => 'Producteur']);
                $artist = $doctrine->getRepository(Artist::class)
                    ->findOneBy([
                        'firstname' => $item['firstname'],
                        'lastname' => $item['lastname'],
                    ]);
                if ($artist == null) {
                    $artist = new Artist();
                    $artist->setFirstname($item['firstname']);
                    $artist->setLastname($item['lastname']);
                    $em->persist($artist);
                }
                $artistType = new ArtistType();
                $artistType->setArtist($artist);
                $artistType->setType($type);
                $em->persist($artistType);
                $em->flush();
                $casts[] = $artistType->getId();
            }
            foreach ($request->get('actors') as $item) {
                $type = $doctrine->getRepository(Type::class)->findOneBy(['type' => 'Acteur']);
                $artist = $doctrine->getRepository(Artist::class)
                    ->findOneBy([
                        'firstname' => $item['firstname'],
                        'lastname' => $item['lastname'],
                    ]);
                if ($artist == null) {
                    $artist = new Artist();
                    $artist->setFirstname($item['firstname']);
                    $artist->setLastname($item['lastname']);
                    $em->persist($artist);
                }
                $artistType = new ArtistType();
                $artistType->setArtist($artist);
                $artistType->setType($type);
                $em->persist($artistType);
                $em->flush();
                $casts[] = $artistType->getId();
            }

        }

        $show = new Show();

        if ($source == 'theatreContemporain') {
            $location = $doctrine->getRepository(Location::class)->findAll()[0];
        } else {
            $location = $doctrine->getRepository(Location::class)->find($request->get('location'));
        }
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

    /**
     * @Route(
     *     path="/admin/show/update",
     *     name="show_update",
     *     methods={"POST"},
     * )
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) {
        $doctrine = $this->getDoctrine();
        $em = $doctrine->getManager();

        $show = $doctrine->getRepository(Show::class)->find($request->get('id'));
        $show->setTitle($request->get('title'));
        $show->setDescription($request->get('description'));
        $show->setPrice($request->get('price'));
        $show->setBookable($request->get('bookable'));
        $em->persist($show);
        $em->flush();

        return new Response('Show Updated !', 200);

    }

    /**
     * @Route(
     *     name="show_update_bookable",
     *     path="/admin/show/update/bookable",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @return Response
     */
    public function changeBookable(Request $request) {
        $show = $this->getDoctrine()->getRepository(Show::class)->find($request->get('id'));
        $show->setBookable(!$show->getBookable());

        $em = $this->getDoctrine()->getManager();
        $em->persist($show);
        $em->flush();

        return new Response(($show->getBookable()?'true':'false'), 200);

    }

}
