<?php

namespace App\Controller;



use App\Entity\Representation;
use App\Entity\RepresentationUser;
use App\Entity\Show;
use App\Form\RepresentationType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepresentationUserController extends AbstractController
{
    /**
     * @Route("/book/{id}", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book($id, Request $request, ObjectManager $manager)
    {
        $rep =$this->getDoctrine()->getRepository(Representation::class)->find($id);

        $booking = new RepresentationUser();
        $form = $this->createForm(representationType::class, $booking);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();

            $booking->setUser($user)
                    ->setRepresentation($rep)
                    ->setPlace($form->getData()->getPlace());

            $manager->persist($booking);
            $manager->flush();

            return $this->redirectToRoute('booking_show', ['id' => $booking->getId()]);
        }

        return $this->render('representationUser/representation.html.twig', [
            'rep' => $rep,
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher la page d'une réservation
     *
     * @Route("/booking/{id}", name="booking_show")
     *
     *
     * @return Response
     */
    public function show(RepresentationUser $booking){

        return $this->render('representationUser/book.html.twig', [
            'booking' => $booking
        ]);
    }
}
