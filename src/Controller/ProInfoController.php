<?php

namespace App\Controller;

use App\Entity\ProInfo;
use App\Form\ProInfoType;
use App\Repository\ProInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pro/info")
 */
class ProInfoController extends AbstractController
{
    /**
     * @Route("/", name="pro_info_index", methods={"GET"})
     */
    public function index(ProInfoRepository $proInfoRepository): Response
    {
        return $this->render('pro_info/index.html.twig', [
            'pro_infos' => $proInfoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pro_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $proInfo = new ProInfo();
        $form = $this->createForm(ProInfoType::class, $proInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proInfo);
            $entityManager->flush();

            return $this->redirectToRoute('pro_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pro_info/new.html.twig', [
            'pro_info' => $proInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pro_info_show", methods={"GET"})
     */
    public function show(ProInfo $proInfo): Response
    {
        return $this->render('pro_info/show.html.twig', [
            'pro_info' => $proInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pro_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ProInfo $proInfo): Response
    {
        $form = $this->createForm(ProInfoType::class, $proInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pro_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pro_info/edit.html.twig', [
            'pro_info' => $proInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="pro_info_delete", methods={"POST"})
     */
    public function delete(Request $request, ProInfo $proInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$proInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($proInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pro_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
