<?php

namespace App\Controller;

use App\Entity\JobSeekerInfo;
use App\Form\JobSeekerInfoType;
use App\Repository\JobSeekerInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/job/seeker/info")
 */
class JobSeekerInfoController extends AbstractController
{
    /**
     * @Route("/", name="job_seeker_info_index", methods={"GET"})
     */
    public function index(JobSeekerInfoRepository $jobSeekerInfoRepository): Response
    {
        return $this->render('job_seeker_info/index.html.twig', [
            'job_seeker_infos' => $jobSeekerInfoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="job_seeker_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jobSeekerInfo = new JobSeekerInfo();
        $form = $this->createForm(JobSeekerInfoType::class, $jobSeekerInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jobSeekerInfo);
            $entityManager->flush();

            return $this->redirectToRoute('job_seeker_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_seeker_info/new.html.twig', [
            'job_seeker_info' => $jobSeekerInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="job_seeker_info_show", methods={"GET"})
     */
    public function show(JobSeekerInfo $jobSeekerInfo): Response
    {
        return $this->render('job_seeker_info/show.html.twig', [
            'job_seeker_info' => $jobSeekerInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="job_seeker_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, JobSeekerInfo $jobSeekerInfo): Response
    {
        $form = $this->createForm(JobSeekerInfoType::class, $jobSeekerInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('job_seeker_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('job_seeker_info/edit.html.twig', [
            'job_seeker_info' => $jobSeekerInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="job_seeker_info_delete", methods={"POST"})
     */
    public function delete(Request $request, JobSeekerInfo $jobSeekerInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jobSeekerInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jobSeekerInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('job_seeker_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
