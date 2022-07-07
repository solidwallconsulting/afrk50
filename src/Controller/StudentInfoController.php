<?php

namespace App\Controller;

use App\Entity\StudentInfo;
use App\Form\StudentInfoType;
use App\Repository\StudentInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/student/info")
 */
class StudentInfoController extends AbstractController
{
    /**
     * @Route("/", name="student_info_index", methods={"GET"})
     */
    public function index(StudentInfoRepository $studentInfoRepository): Response
    {
        return $this->render('student_info/index.html.twig', [
            'student_infos' => $studentInfoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="student_info_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $studentInfo = new StudentInfo();
        $form = $this->createForm(StudentInfoType::class, $studentInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($studentInfo);
            $entityManager->flush();

            return $this->redirectToRoute('student_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_info/new.html.twig', [
            'student_info' => $studentInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="student_info_show", methods={"GET"})
     */
    public function show(StudentInfo $studentInfo): Response
    {
        return $this->render('student_info/show.html.twig', [
            'student_info' => $studentInfo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="student_info_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, StudentInfo $studentInfo): Response
    {
        $form = $this->createForm(StudentInfoType::class, $studentInfo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('student_info_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('student_info/edit.html.twig', [
            'student_info' => $studentInfo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="student_info_delete", methods={"POST"})
     */
    public function delete(Request $request, StudentInfo $studentInfo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentInfo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($studentInfo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('student_info_index', [], Response::HTTP_SEE_OTHER);
    }
}
