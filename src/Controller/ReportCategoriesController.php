<?php

namespace App\Controller;

use App\Entity\ReportCategories;
use App\Form\ReportCategoriesType;
use App\Repository\ReportCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/report-categories")
 */
class ReportCategoriesController extends AbstractController
{
    /**
     * @Route("/", name="report_categories_index", methods={"GET"})
     */
    public function index(ReportCategoriesRepository $reportCategoriesRepository): Response
    {
        return $this->render('report_categories/index.html.twig', [
            'report_categories' => $reportCategoriesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="report_categories_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $reportCategory = new ReportCategories();
        $form = $this->createForm(ReportCategoriesType::class, $reportCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reportCategory);
            $entityManager->flush();

            return $this->redirectToRoute('report_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report_categories/new.html.twig', [
            'report_category' => $reportCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="report_categories_show", methods={"GET"})
     */
    public function show(ReportCategories $reportCategory): Response
    {
        return $this->render('report_categories/show.html.twig', [
            'report_category' => $reportCategory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="report_categories_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ReportCategories $reportCategory): Response
    {
        $form = $this->createForm(ReportCategoriesType::class, $reportCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('report_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report_categories/edit.html.twig', [
            'report_category' => $reportCategory,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="report_categories_delete", methods={"POST"})
     */
    public function delete(Request $request, ReportCategories $reportCategory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reportCategory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reportCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('report_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
