<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\NotationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminUserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="adminUsers")
     */
    public function index(UserRepository $userRepository, NotationRepository $notationRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $users = $paginatorInterface->paginate(
            $userRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $notation = $notationRepository->findAll();

        return $this->render('admin/admin_user/admin.html.twig', [
            "users" => $users,
            "notation" => $notation,
        ]);
    }

    /**
     * @Route("/admin/users/{id}", name="suppUsers", methods="SUP")
     */
    public function suppression(User $users, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$users->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($users);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("adminUsers");
        }
    }
}
