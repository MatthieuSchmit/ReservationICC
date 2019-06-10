<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController {

    /**
     * @Route("/admin", name="admin")
     */
    public function index() {


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/show", name="admin_add_show")
     * @IsGranted("ROLE_ADMIN")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addShow() {
        return $this->render('admin/addShow.html.twig', []);
    }

    /**
     * @Route(
     *     path="/admin/show/store",
     *     name="admin_store_show",
     *     methods={"POST"},
     * )
     * @IsGranted("ROLE_ADMIN")
     *
     * @param Request $request
     */
    public function storeShows(Request $request) {

        $shows = $request->query->get('shows');

        var_dump($shows);die();

        foreach ($shows as $s) {
            $apiRequest = 'https://www.theatre-contemporain.net/api/spectacles/' . $s
                . '?k=b0c04bba8e0993d6f6f6a2004a68a4aeec91fb84';

            $apiCall = curl_init($apiRequest);
            $apiCallOptions = array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
            );
            curl_setopt_array($apiCall, $apiCallOptions);

            $show =  json_decode(curl_exec($apiCall));

            var_dump($show);die();
        }



    }

}
