<?php

namespace App\Controller;

use App\Entity\Newsletters;
use App\Form\NewslettersType;
use App\Repository\NewslettersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/newsletters")
 */
class NewslettersController extends AbstractController
{
    /**
     * @Route("/", name="newsletters_index", methods={"GET"})
     */
    public function index(NewslettersRepository $newslettersRepository): Response
    {
        return $this->render('newsletters/index.html.twig', [
            'newsletters' => $newslettersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="newsletters_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newsletter = new Newsletters();
        $form = $this->createForm(NewslettersType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($newsletter);
            $entityManager->flush();

            return $this->redirectToRoute('newsletters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newsletters/new.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="newsletters_show", methods={"GET"})
     */
    public function show(Newsletters $newsletter): Response
    {
        return $this->render('newsletters/show.html.twig', [
            'newsletter' => $newsletter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="newsletters_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Newsletters $newsletter): Response
    {
        $form = $this->createForm(NewslettersType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('newsletters_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('newsletters/edit.html.twig', [
            'newsletter' => $newsletter,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="newsletters_delete", methods={"POST"})
     */
    public function delete(Request $request, Newsletters $newsletter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$newsletter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($newsletter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('newsletters_index', [], Response::HTTP_SEE_OTHER);
    }
}
