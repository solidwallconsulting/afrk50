<?php

namespace App\Controller;

use App\Entity\Partners;
use App\Form\PartnersType;
use App\Repository\PartnersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partners")
 */
class PartnersController extends AbstractController
{
    /**
     * @Route("/", name="partners_index", methods={"GET"})
     */
    public function index(PartnersRepository $partnersRepository): Response
    {
        return $this->render('partners/index.html.twig', [
            'partners' => $partnersRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partners_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partner = new Partners();
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {



             /** @var UploadedFile $image */
             
             $image = $form->get('logoURL')->getData();
            
             if ($image) {
                 $newFilename = uniqid().'.'.$image->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $image->move('img/partners/',
                         $newFilename
                     );
                 } catch (FileException $e) {
                      
                 }
  
                 $partner->setLogoURL('/img/partners/'.$newFilename);
             }


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partner);
            $entityManager->flush();

            return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners/new.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="partners_show", methods={"GET"})
     */
    public function show(Partners $partner): Response
    {
        return $this->render('partners/show.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partners_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partners $partner): Response
    {
        $form = $this->createForm(PartnersType::class, $partner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var UploadedFile $image */
             
            $image = $form->get('logoURL')->getData();
            
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 
                    $image->move('img/partners/',
                        $newFilename
                    );
                } catch (FileException $e) {
                     
                }
 
                $partner->setLogoURL('/img/partners/'.$newFilename);
            }


            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partners/edit.html.twig', [
            'partner' => $partner,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="partners_delete", methods={"POST"})
     */
    public function delete(Request $request, Partners $partner): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partner->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partner);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partners_index', [], Response::HTTP_SEE_OTHER);
    }
}
