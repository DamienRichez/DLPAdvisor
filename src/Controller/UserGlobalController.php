<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserGlobalController extends AbstractController
{
    /**
     * @Route("/user/{id}", name="userProfil")
     */
    public function profile(User $users)
    {

        return $this->render('user_global/index.html.twig', [
            'users' => $users,
        ]);
    }

      /**
     * @Route("/user/modification/{id}", name="modifUsers", methods="GET|POST")
     */
    public function attractions(User $users, Request $request, EntityManagerInterface $entityManagerInterface)
    {

        $form = $this->createForm(UserType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif=$users->getId() !== null;
            $entityManagerInterface->persist($users);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectué" : "L'ajout a été effectué");
            return $this->redirectToRoute("userProfil");
        }

        return $this->render('user_global/modifUser.html.twig', [
            "users" => $users,
            "form"=> $form->createView(),
            "isModification"=> $users->getId() !== null,
        ]);
    }

    /**
     * @Route("/user/{id}", name="suppUsers", methods="SUP")
     */
    public function suppression(User $users, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$users->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($users);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("acceuil");
        }
    }

    public function user(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('base.html.twig', [
            'users' => $users,
        ]);
    }
}
