<?php

namespace App\Controller\Admin;

use App\Entity\Attractions;
use App\Form\AttractionsType;
use App\Repository\AttractionsRepository;
use App\Repository\NotationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/attractions", name="adminAttractions")
     */
    public function index(AttractionsRepository $attractionsRepository, NotationRepository $notationRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $attractions = $paginatorInterface->paginate(
            $attractionsRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $notation = $notationRepository->findAll();

        return $this->render('admin/admin_attractions/admin.html.twig', [
            "attractions" => $attractions,
            "notation" => $notation,
        ]);
    }
    

    /**
     * @Route("/admin/attractions/creation", name="creationAttractions")
     * @Route("/admin/attractions/{id}", name="modifAttractions", methods="GET|POST")
     */
    public function attractions(Attractions $attractions = null, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if (!$attractions) {
            $attractions = new Attractions;
        }

        $form = $this->createForm(AttractionsType::class, $attractions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif=$attractions->getId() !== null;
            $entityManagerInterface->persist($attractions);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectué" : "L'ajout a été effectué");
            return $this->redirectToRoute("adminAttractions");
        }

        return $this->render('admin/admin_attractions/adminAttractions.html.twig', [
            "attractions" => $attractions,
            "form"=> $form->createView(),
            "isModification"=> $attractions->getId() !== null,
        ]);
    }

            /**
     * @Route("/admin/attractions/{id}", name="suppAttractions", methods="SUP")
     */
    public function suppression(Attractions $attractions, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$attractions->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($attractions);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("adminAttractions");
        }
    }
}
