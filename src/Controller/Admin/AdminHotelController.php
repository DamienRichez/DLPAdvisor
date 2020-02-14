<?php

namespace App\Controller\Admin;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use App\Repository\NotationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminHotelController extends AbstractController
{
    /**
     * @Route("/admin/hotels", name="adminHotels")
     */
    public function index(HotelRepository $HotelRepository, NotationRepository $notationRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $hotels = $paginatorInterface->paginate(
            $HotelRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $notation = $notationRepository->findAll();

        return $this->render('admin/admin_hotel/admin.html.twig', [
            "hotels" => $hotels,
            "notation" => $notation,
        ]);
    }

           /**
     * @Route("/admin/hotels/creation", name="creationHotels")
     * @Route("/admin/hotels/{id}", name="modifHotels", methods="GET|POST")
     */
    public function attractions(Hotel $hotels = null, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if (!$hotels) {
            $hotels = new Hotel;
        }

        $form = $this->createForm(HotelType::class, $hotels);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif=$hotels->getId() !== null;
            $entityManagerInterface->persist($hotels);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectué" : "L'ajout a été effectué");
            return $this->redirectToRoute("adminHotels");
        }

        return $this->render('admin/admin_hotel/adminHotels.html.twig', [
            "hotels" => $hotels,
            "form"=> $form->createView(),
            "isModification"=> $hotels->getId() !== null,
        ]);
    }

            /**
     * @Route("/admin/hotels/{id}", name="suppHotels", methods="SUP")
     */
    public function suppression(Hotel $hotels, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$hotels->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($hotels);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("adminHotels");
        }
    }
}
