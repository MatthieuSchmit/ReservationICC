<?php

namespace App\Controller;

use App\Entity\Type;
use App\Form\NewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TypeController extends AbstractController {

    /**
     * @Route("/type", name="type")
     */
    public function index(Request $request) {

        $form = $this->createForm(NewType::class);
        $types = $this->getDoctrine()->getRepository(Type::class)->findAll();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $type = new Type();
            $type->setType($data->getType());

            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            //return $this->redirectToRoute('artist_info', ['id' => $type->getId()]);
        }

        return $this->render('type/index.html.twig', [
            'form' => $form->createView(),
            'types' => $types,
        ]);

    }


    /**
     * @Route(
     *     path="/type/store",
     *     name="type_store"
     * )
     */
    public function store() {
        // TODO
    }

}
