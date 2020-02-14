<?php

namespace App\Controller;

use App\Entity\Attractions;
use App\Entity\Hotel;
use App\Entity\Notation;
use App\Entity\Restaurant;
use App\Entity\Soiree;
use App\Entity\User;
use App\Form\NotationType;
use App\Form\UserType;
use App\Repository\AttractionsRepository;
use App\Repository\HotelRepository;
use App\Repository\NotationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\SoireeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class GlobalController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(AttractionsRepository $attractionsRepository, 
                            RestaurantRepository $restaurantRepository, 
                            HotelRepository $hotelRepository ,
                            SoireeRepository $soireeRepository,
                            UserRepository $userRepository,
                            Request $request, 
                            PaginatorInterface $paginatorInterface
    )

    {
        $attractions = $paginatorInterface->paginate(
            $attractionsRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $restaurants = $paginatorInterface->paginate(
            $restaurantRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $hotels = $paginatorInterface->paginate(
            $hotelRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $soirees = $paginatorInterface->paginate(
            $soireeRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $users = $this->getUser();

        return $this->render('global/index.html.twig', [
            "attractions" => $attractions, 
            "restaurants" => $restaurants,
            "hotels" => $hotels,
            "soirees" => $soirees,
            "users" => $users,
        ]);
    }

    /**
     * @Route("/attractions/{id}", name="attractions")
     */
    public function attractions(Attractions $attractions, NotationRepository $notationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface)
    {

        $notation = $notationRepository->findBy(['idAttractions' => $attractions]);
        $user = $userRepository->findAll();


        $notations = new Notation;
        $form = $this->createForm(NotationType::class, $notations);
        $form->handleRequest($request);
        $UserEnCours = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $notations->setIdAttractions($attractions);
            $notations->setIdUser($this->getUser());
            $entityManagerInterface->persist($notations);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('attractions', ['id' => $attractions->getId()]);
        }

        return $this->render('global/fiche/attractions.html.twig', [
            "attractions" => $attractions,
            "notation" => $notation, 
            "user" => $user,
            "form" => $form->createView(),
            "UserEnCours" => $UserEnCours,
        ]);
    }


       /**
     * @Route("/restaurants/{id}", name="restaurants")
     */
    public function restaurants(Restaurant $restaurants, NotationRepository $notationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $notation = $notationRepository->findBy(['restaurant' => $restaurants]);
        $user = $userRepository->findAll();


        $notations = new Notation;
        $form = $this->createForm(NotationType::class, $notations);
        $form->handleRequest($request);
        $UserEnCours = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $notations->setRestaurant($restaurants);
            $notations->setIdUser($this->getUser());
            $entityManagerInterface->persist($notations);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('restaurants', ['id' => $restaurants->getId()]);
        }

        return $this->render('global/fiche/restaurants.html.twig', [
            "restaurants" => $restaurants,
            "notation" => $notation, 
            "user" => $user,
            "form" => $form->createView(),
            "UserEnCours" => $UserEnCours,
        ]);
    }

       /**
     * @Route("/hotels/{id}", name="hotels")
     */
    public function hotels(Hotel $hotels, NotationRepository $notationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $notation = $notationRepository->findBy(['hotel' => $hotels]);
        $user = $userRepository->findAll();


        $notations = new Notation;
        $form = $this->createForm(NotationType::class, $notations);
        $form->handleRequest($request);
        $UserEnCours = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $notations->setHotel($hotels);
            $notations->setIdUser($this->getUser());
            $entityManagerInterface->persist($notations);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('hotels', ['id' => $hotels->getId()]);
        }

        return $this->render('global/fiche/hotels.html.twig', [
            "hotels" => $hotels,
            "notation" => $notation, 
            "user" => $user,
            "form" => $form->createView(),
            "UserEnCours" => $UserEnCours,
        ]);
    }

       /**
     * @Route("/soirees/{id}", name="soirees")
     */
    public function soirees(Soiree $soirees, NotationRepository $notationRepository, UserRepository $userRepository, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        $notation = $notationRepository->findBy(['soiree' => $soirees]);
        $user = $userRepository->findAll();


        $notations = new Notation;
        $form = $this->createForm(NotationType::class, $notations);
        $form->handleRequest($request);
        $UserEnCours = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $notations->setSoiree($soirees);
            $notations->setIdUser($this->getUser());
            $entityManagerInterface->persist($notations);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('soirees', ['id' => $soirees->getId()]);
        }

        return $this->render('global/fiche/soirees.html.twig', [
            "soirees" => $soirees,
            "notation" => $notation, 
            "user" => $user,
            "form" => $form->createView(),
            "UserEnCours" => $UserEnCours,
        ]);
    }
    
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $entityManagerInterface, UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $user = new User;
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordcrypt = $userPasswordEncoderInterface->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordcrypt);
            $user->setRoles('ROLE_USER');
            $entityManagerInterface->persist($user);
            $entityManagerInterface->flush();
            return $this->redirectToRoute("accueil");
        }

        return $this->render('global/inscription.html.twig', [
            "form" => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/notations/{id}", name="suppNotations", methods="SUP")
     */
    public function suppression(Notation $notations, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$notations->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($notations);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("accueil");
        }
    }

        /**
     * @Route("/connexion", name="login")
     */
    public function login(AuthenticationUtils $util)
    {
        return $this->render('global/connexion.html.twig', [
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError(),
        ]);
    }

            /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }
}
