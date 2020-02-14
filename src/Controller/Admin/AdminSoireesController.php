<?php

namespace App\Controller\Admin;

use App\Entity\Soiree;
use App\Form\SoireeType;
use App\Repository\NotationRepository;
use App\Repository\SoireeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminSoireesController extends AbstractController
{
    /**
     * @Route("/admin/Soirees", name="adminSoirees")
     */
    public function index(SoireeRepository $SoireeRepository, NotationRepository $notationRepository, Request $request, PaginatorInterface $paginatorInterface)
    {
        $soirees = $paginatorInterface->paginate(
            $SoireeRepository->findBy([], ['id' => 'DESC']),
            $request->query->getInt('page', 1), /*page number*/
            4 /*limit per page*/
        );

        $notation = $notationRepository->findAll();

        return $this->render('admin/admin_soirees/admin.html.twig', [
            "soirees" => $soirees,
            "notation" => $notation,
        ]);
    }

         /**
     * @Route("/admin/soirees/creation", name="creationSoirees")
     * @Route("/admin/soirees/{id}", name="modifSoirees", methods="GET|POST")
     */
    public function soirees(Soiree $soirees = null, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if (!$soirees) {
            $soirees = new Soiree;
        }

        $form = $this->createForm(SoireeType::class, $soirees);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif=$soirees->getId() !== null;
            $entityManagerInterface->persist($soirees);
            $entityManagerInterface->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectué" : "L'ajout a été effectué");
            return $this->redirectToRoute("adminSoirees");
        }

        return $this->render('admin/admin_soirees/adminSoirees.html.twig', [
            "soirees" => $soirees,
            "form"=> $form->createView(),
            "isModification"=> $soirees->getId() !== null,
        ]);
    }

            /**
     * @Route("/admin/soirees/{id}", name="suppSoirees", methods="SUP")
     */
    public function suppression(Soiree $soirees, Request $request, EntityManagerInterface $entityManagerInterface)
    {
        if ($this->isCsrfTokenValid("SUP".$soirees->getId(),$request->get("_token"))) {

            $entityManagerInterface->remove($soirees);
            $entityManagerInterface->flush();
            $this->addFlash("success", "La suppression a été effectué");
            return $this->redirectToRoute("adminSoirees");
        }
    }
}
