<?php

namespace App\Controller;

use App\Entity\ListingAttributes;
use App\Form\ListingAttributesType;
use App\Repository\ListingAttributesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/listing/attributes")
 */
class ListingAttributesController extends AbstractController
{
    /**
     * @Route("/", name="listing_attributes_index", methods={"GET"})
     */
    public function index(ListingAttributesRepository $listingAttributesRepository): Response
    {
        return $this->render('listing_attributes/index.html.twig', [
            'listing_attributes' => $listingAttributesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="listing_attributes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listingAttribute = new ListingAttributes();
        
        $form = $this->createForm(ListingAttributesType::class, $listingAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listingAttribute);
            $entityManager->flush();

            return $this->redirectToRoute('listing_attributes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing_attributes/new.html.twig', [
            'listing_attribute' => $listingAttribute,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="listing_attributes_show", methods={"GET"})
     */
    public function show(ListingAttributes $listingAttribute): Response
    {
        return $this->render('listing_attributes/show.html.twig', [
            'listing_attribute' => $listingAttribute,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listing_attributes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ListingAttributes $listingAttribute): Response
    {
        $form = $this->createForm(ListingAttributesType::class, $listingAttribute);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listing_attributes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing_attributes/edit.html.twig', [
            'listing_attribute' => $listingAttribute,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="listing_attributes_delete", methods={"POST"})
     */
    public function delete(Request $request, ListingAttributes $listingAttribute): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listingAttribute->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listingAttribute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listing_attributes_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
    /**
     * @Route("/delete-from-listing/{id}", name="listing_attributes_delete_from_listing", methods={"POST"})
     */
    public function deleteFromListing(Request $request, ListingAttributes $listingAttribute): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listingAttribute->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listingAttribute);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listing_edit', ['id'=>$listingAttribute->getListing()->getId()], Response::HTTP_SEE_OTHER);
    }


    
}
