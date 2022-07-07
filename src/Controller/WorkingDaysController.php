<?php

namespace App\Controller;

use App\Entity\WorkingDays;
use App\Form\WorkingDaysType;
use App\Repository\WorkingDaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/working/days")
 */
class WorkingDaysController extends AbstractController
{
    /**
     * @Route("/", name="working_days_index", methods={"GET"})
     */
    public function index(WorkingDaysRepository $workingDaysRepository): Response
    {
        return $this->render('working_days/index.html.twig', [
            'working_days' => $workingDaysRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="working_days_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $workingDay = new WorkingDays();
        $form = $this->createForm(WorkingDaysType::class, $workingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($workingDay);
            $entityManager->flush();

            return $this->redirectToRoute('working_days_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('working_days/new.html.twig', [
            'working_day' => $workingDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="working_days_show", methods={"GET"})
     */
    public function show(WorkingDays $workingDay): Response
    {
        return $this->render('working_days/show.html.twig', [
            'working_day' => $workingDay,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="working_days_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, WorkingDays $workingDay): Response
    {
        $form = $this->createForm(WorkingDaysType::class, $workingDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('working_days_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('working_days/edit.html.twig', [
            'working_day' => $workingDay,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="working_days_delete", methods={"POST"})
     */
    public function delete(Request $request, WorkingDays $workingDay): Response
    {
        if ($this->isCsrfTokenValid('delete'.$workingDay->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($workingDay);
            $entityManager->flush();
        }

        return $this->redirectToRoute('working_days_index', [], Response::HTTP_SEE_OTHER);
    }
}
