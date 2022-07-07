<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\ListingReports;
use App\Form\ListingReportsType;
use App\Repository\ListingReportsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/listing-reports")
 */
class ListingReportsController extends AbstractController
{
    /**
     * @Route("/details/{id}", name="listing_reports_index", methods={"GET"})
     */
    public function index( Company $company ): Response
    {
        return $this->render('listing_reports/index.html.twig', [
            'company'=>$company,
            'listing_reports' => $company->getListingReports(),
        ]);
    }

    /**
     * @Route("/new", name="listing_reports_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listingReport = new ListingReports();
        $form = $this->createForm(ListingReportsType::class, $listingReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listingReport);
            $entityManager->flush();

            return $this->redirectToRoute('listing_reports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing_reports/new.html.twig', [
            'listing_report' => $listingReport,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="listing_reports_show", methods={"GET"})
     */
    public function show(ListingReports $listingReport): Response
    {
        return $this->render('listing_reports/show.html.twig', [
            'listing_report' => $listingReport,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listing_reports_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ListingReports $listingReport): Response
    {
        $form = $this->createForm(ListingReportsType::class, $listingReport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listing_reports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing_reports/edit.html.twig', [
            'listing_report' => $listingReport,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="listing_reports_delete", methods={"POST"})
     */
    public function delete(Request $request, ListingReports $listingReport): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listingReport->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listingReport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listing_reports_index', ['id'=>$listingReport->getListing()->getId()], Response::HTTP_SEE_OTHER);
    }
}
