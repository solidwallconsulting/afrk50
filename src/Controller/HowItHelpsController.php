<?php

namespace App\Controller;

use App\Entity\HowItHelps;
use App\Form\HowItHelpsType;
use App\Repository\HowItHelpsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/how-it-helps")
 */
class HowItHelpsController extends AbstractController
{
    /**
     * @Route("/", name="how_it_helps_index", methods={"GET"})
     */
    public function index(HowItHelpsRepository $howItHelpsRepository): Response
    {
        return $this->render('how_it_helps/index.html.twig', [
            'how_it_helps' => $howItHelpsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="how_it_helps_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $howItHelp = new HowItHelps();
        $form = $this->createForm(HowItHelpsType::class, $howItHelp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($howItHelp);
            $entityManager->flush();

            return $this->redirectToRoute('how_it_helps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('how_it_helps/new.html.twig', [
            'how_it_help' => $howItHelp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="how_it_helps_show", methods={"GET"})
     */
    public function show(HowItHelps $howItHelp): Response
    {
        return $this->render('how_it_helps/show.html.twig', [
            'how_it_help' => $howItHelp,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="how_it_helps_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, HowItHelps $howItHelp): Response
    {
        $form = $this->createForm(HowItHelpsType::class, $howItHelp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('how_it_helps_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('how_it_helps/edit.html.twig', [
            'how_it_help' => $howItHelp,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="how_it_helps_delete", methods={"POST"})
     */
    public function delete(Request $request, HowItHelps $howItHelp): Response
    {
        if ($this->isCsrfTokenValid('delete'.$howItHelp->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($howItHelp);
            $entityManager->flush();
        }

        return $this->redirectToRoute('how_it_helps_index', [], Response::HTTP_SEE_OTHER);
    }
}
