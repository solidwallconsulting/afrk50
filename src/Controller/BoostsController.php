<?php

namespace App\Controller;

use App\Entity\Boosts;
use App\Form\BoostsType;
use App\Repository\BoostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/boosts")
 */
class BoostsController extends AbstractController
{
    /**
     * @Route("/", name="boosts_index", methods={"GET"})
     */
    public function index(BoostsRepository $boostsRepository): Response
    {
        return $this->render('boosts/index.html.twig', [
            'boosts' => $boostsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="boosts_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $boost = new Boosts();
        $form = $this->createForm(BoostsType::class, $boost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($boost);
            $entityManager->flush();

            return $this->redirectToRoute('boosts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boosts/new.html.twig', [
            'boost' => $boost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="boosts_show", methods={"GET"})
     */
    public function show(Boosts $boost): Response
    {
        return $this->render('boosts/show.html.twig', [
            'boost' => $boost,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="boosts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Boosts $boost): Response
    {
        $form = $this->createForm(BoostsType::class, $boost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boosts_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('boosts/edit.html.twig', [
            'boost' => $boost,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="boosts_delete", methods={"POST"})
     */
    public function delete(Request $request, Boosts $boost): Response
    {
        if ($this->isCsrfTokenValid('delete'.$boost->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($boost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boosts_index', [], Response::HTTP_SEE_OTHER);
    }
}
