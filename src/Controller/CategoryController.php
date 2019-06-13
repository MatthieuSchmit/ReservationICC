<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_index")
     */
    public function index()
    {
        $cat = $this->getDoctrine()->getRepository(Category::class)->findAll();
        return $this->render('category/index.html.twig', [
            'cats' => $cat,
        ]);
    }


    /**
     * @Route("/category/{slug}", name="category_show")
     *
     * @return Response
     */
    public function show(Category $cat){

        return $this->render('category/show.html.twig', [
            'category' => $cat
        ]);
    }

}
