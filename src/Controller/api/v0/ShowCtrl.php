<?php
/**
 * Created by PhpStorm.
 * User: Matthieu
 * Date: 2019-06-09
 * Time: 13:29
 */

namespace App\Controller\api\v0;


use App\Entity\Show;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShowCtrl extends AbstractController {

    /**
     * @Route (
     *     name="v0_get_all_shows",
     *     path="/api/v0/shows",
     *     methods={"GET"},
     *     defaults={
     *         "_controller"="\App\Controller\api\v0\ShowCtrl::getAll",
     *         "_api_resource_class"="App\Entity\Show",
     *         "_api_collection_operation_name"="getAllShows"
     *     },
     * )
     * @return object[]
     */
    public function getAll() {
        return $this->getDoctrine()->getRepository(Show::class)->findAll();
    }

    /**
     * @Route (
     *     name="v0_get_one_show",
     *     path="api/v0/shows/{id}",
     *     methods={"GET"},
     *     requirements={"id"="\d+"},
     *     defaults={
     *         "_controller"="\App\Controller\api\v0\ShowCtrl::getOne",
     *         "_api_resource_class"="App\Entity\Show",
     *         "_api_item_operation_name"="getOneShow"
     *     },
     * )
     * @param Show $data
     * @return Show
     */
    public function getOne(Show $data) {
        return $data;
    }

}
