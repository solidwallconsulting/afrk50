<?php

namespace App\Controller;

use App\Entity\Partnership;
use App\Form\PartnershipType;
use App\Repository\PartnershipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/partnership")
 */
class PartnershipController extends AbstractController
{
    /**
     * @Route("/", name="partnership_index", methods={"GET"})
     */
    public function index(PartnershipRepository $partnershipRepository): Response
    {
        return $this->render('partnership/index.html.twig', [
            'partnerships' => $partnershipRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partnership_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partnership = new Partnership();
        $form = $this->createForm(PartnershipType::class, $partnership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partnership);
            $entityManager->flush();

            return $this->redirectToRoute('partnership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partnership/new.html.twig', [
            'partnership' => $partnership,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="partnership_show", methods={"GET"})
     */
    public function show(Partnership $partnership): Response
    {
        return $this->render('partnership/show.html.twig', [
            'partnership' => $partnership,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partnership_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partnership $partnership): Response
    {
        $form = $this->createForm(PartnershipType::class, $partnership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partnership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partnership/edit.html.twig', [
            'partnership' => $partnership,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="partnership_delete", methods={"POST"})
     */
    public function delete(Request $request, Partnership $partnership): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partnership->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partnership);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partnership_index', [], Response::HTTP_SEE_OTHER);
    }
}
