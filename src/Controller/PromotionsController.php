<?php

namespace App\Controller;

use App\Entity\Promotions;
use App\Form\PromotionsType;
use App\Repository\PromotionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/promotions")
 */
class PromotionsController extends AbstractController
{
    /**
     * @Route("/", name="promotions_index", methods={"GET"})
     */
    public function index(PromotionsRepository $promotionsRepository): Response
    {
        return $this->render('promotions/index.html.twig', [
            'promotions' => $promotionsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="promotions_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $promotion = new Promotions();
        $form = $this->createForm(PromotionsType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();

            return $this->redirectToRoute('promotions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotions/new.html.twig', [
            'promotion' => $promotion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="promotions_show", methods={"GET"})
     */
    public function show(Promotions $promotion): Response
    {
        return $this->render('promotions/show.html.twig', [
            'promotion' => $promotion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="promotions_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Promotions $promotion): Response
    {
        $form = $this->createForm(PromotionsType::class, $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotions_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('promotions/edit.html.twig', [
            'promotion' => $promotion,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="promotions_delete", methods={"POST"})
     */
    public function delete(Request $request, Promotions $promotion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($promotion);
            $entityManager->flush();
        }

        return $this->redirectToRoute('promotions_index', [], Response::HTTP_SEE_OTHER);
    }
}
