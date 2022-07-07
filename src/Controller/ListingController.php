<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Entity\ListingAttributes;
use App\Form\ListingAttributesType;
use App\Form\ListingType;
use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/listing")
 */
class ListingController extends AbstractController
{
    /**
     * @Route("/", name="listing_index", methods={"GET"})
     */
    public function index(ListingRepository $listingRepository): Response
    {
        return $this->render('listing/index.html.twig', [
            'listings' => $listingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="listing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listing = new Listing();
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


             /** @var UploadedFile $image */
             
             $image = $form->get('photoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('img/listings-covers/',
                         $newFilename
                     );

                     $listing->setPhotoURL('/img/listings-covers/'.$newFilename);
                 } catch (FileException $e) {
                    $listing->setPhotoURL('/img/listings-covers/null.jpg');
                 }
  
                
             }else{
                $listing->setPhotoURL('/img/listings-covers/null.jpg');
             }



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listing);
            $entityManager->flush();

            return $this->redirectToRoute('listing_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('listing/new.html.twig', [
            'listing' => $listing,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="listing_show", methods={"GET"})
     */
    public function show(Listing $listing): Response
    {
        return $this->render('listing/show.html.twig', [
            'listing' => $listing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Listing $listing): Response
    {
        $form = $this->createForm(ListingType::class, $listing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $image */
             
            $image = $form->get('photoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('img/listings-covers/',
                        $newFilename
                    );

                    $listing->setPhotoURL('/img/listings-covers/'.$newFilename);
                } catch (FileException $e) {
                  
                }
 
               
            } 


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listing_index', [], Response::HTTP_SEE_OTHER);
        }


        $listingAttribute = new ListingAttributes();
        $listingAttribute->setListing($listing);
        
        $formListingAttributte = $this->createForm(ListingAttributesType::class, $listingAttribute);
        $formListingAttributte->handleRequest($request);

        if ($formListingAttributte->isSubmitted() && $formListingAttributte->isValid()) {

            $listingAttribute->setListing($listing);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listingAttribute);
            $entityManager->flush();

             
        }
 

        return $this->renderForm('listing/edit.html.twig', [
            'listing' => $listing,
            'form' => $form,
            'listing_attribute' => $listingAttribute,
            'formListingAttributte' => $formListingAttributte,
            
        ]);
    }

    /**
     * @Route("/{id}", name="listing_delete", methods={"POST"})
     */
    public function delete(Request $request, Listing $listing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listing);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listing_index', [], Response::HTTP_SEE_OTHER);
    }
}
