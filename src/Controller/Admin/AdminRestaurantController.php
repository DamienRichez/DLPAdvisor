<?php

namespace App\Controller\Admin;

use App\Entity\Restaurant;
use App\Form\RestaurantType;
use App\Repository\NotationRepository;
use App\Repository\RestaurantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminRestaurantController extends AbstractController
{
    /**
     * @Route("/admin/restaurants", name="adminRestaurants")
     */
    public function index(RestaurantRepository $restaurantRepository, NotationRepository $notationRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $restaurants = $paginatorInterface->paginate(
            $restaurantRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $notation = $notationRepository->findAll();

        return $this->render('admin/admin_restaurant/admin.html.twig', [
            "restaurants" => $restaurants,
            "notation" => $notation,
        ]);
    }

       /**
     * @Route("/admin/restaurants/creation", name="creationRestaurants")
     * @Route("/admin/restaurants/{id}", name="modifRestaurants", methods="GET|POST")
     */
    public function attractions(Restaurant $restaurants = null, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if (!$restaurants) {
            $restaurants = new Restaurant;
        }

        $form = $this->createForm(RestaurantType::class, $restaurants);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif=$restaurants->getId() !== null;
            $entityManagerInterface->persist($restaurants);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectué" : "L'ajout a été effectué");
            return $this->redirectToRoute("adminRestaurants");
        }

        return $this->render('admin/admin_restaurant/adminRestaurants.html.twig', [
            "restaurants" => $restaurants,
            "form"=> $form->createView(),
            "isModification"=> $restaurants->getId() !== null,
        ]);
    }

            /**
     * @Route("/admin/restaurants/{id}", name="suppRestaurants", methods="SUP")
     */
    public function suppression(Restaurant $restaurant, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$restaurant->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($restaurant);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("adminRestaurants");
        }
    }
}
