<?php

namespace App\Controller;

use App\Repository\AttractionsRepository;
use App\Repository\HotelRepository;
use App\Repository\RestaurantRepository;
use App\Repository\SoireeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PagesRenduController extends AbstractController
{
    /**
     * @Route("/pages/attractions", name="pageToutesAttractions")
     */
    public function attractions(AttractionsRepository $attractionsRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $attractions = $paginatorInterface->paginate(
            $attractionsRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('pages_rendu/pageAttractions.html.twig', [
            "attractions" => $attractions,
        ]);
    }

        /**
     * @Route("/pages/restaurants", name="pageToutRestaurants")
     */
    public function restaurants(RestaurantRepository $restaurantRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $restaurants = $paginatorInterface->paginate(
            $restaurantRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('pages_rendu/pageRestaurants.html.twig', [
            "restaurants" => $restaurants,
        ]);
    }

        /**
     * @Route("/pages/hotels", name="pageToutHotels")
     */
    public function hotels(HotelRepository $hotelRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $hotels = $paginatorInterface->paginate(
            $hotelRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('pages_rendu/pageHotels.html.twig', [
            "hotels" => $hotels,
        ]);
    }

        /**
     * @Route("/pages/soirees", name="pageToutesSoirees")
     */
    public function soirees(SoireeRepository $soireeRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $soirees = $paginatorInterface->paginate(
            $soireeRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('pages_rendu/pageSoirees.html.twig', [
            "attractions" => $soirees,
        ]);
    }
}
