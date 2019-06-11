<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index() {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route(
     *     name="user_profile",
     *     path="/profile",
     *     methods={"GET"},
     * )
     */
    public function profile() {
        return $this->render('user/profile.html.twig', []);
    }

    /**
     * @Route(
     *     name="user_profile_admin",
     *     path="/profile/{id}",
     *     requirements={"id"="\d+"},
     *     methods={"GET"},
     * )
     * @IsGranted("ROLE_ADMIN")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAdmin($id) {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        // TODO : use $user in profile.html.twig !!!
        return $this->render('user/profile.html.twig', [
            'user' => $user,
        ]);
    }
}
