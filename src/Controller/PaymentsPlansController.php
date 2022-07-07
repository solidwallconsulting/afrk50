<?php

namespace App\Controller;

use App\Entity\PaymentsPlans;
use App\Form\PaymentsPlansType;
use App\Repository\PaymentsPlansRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/payments-plans")
 */
class PaymentsPlansController extends AbstractController
{
    /**
     * @Route("/", name="payments_plans_index", methods={"GET"})
     */
    public function index(PaymentsPlansRepository $paymentsPlansRepository): Response
    {
        return $this->render('payments_plans/index.html.twig', [
            'payments_plans' => $paymentsPlansRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="payments_plans_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $paymentsPlan = new PaymentsPlans();
        $form = $this->createForm(PaymentsPlansType::class, $paymentsPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paymentsPlan);
            $entityManager->flush();

            return $this->redirectToRoute('payments_plans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payments_plans/new.html.twig', [
            'payments_plan' => $paymentsPlan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payments_plans_show", methods={"GET"})
     */
    public function show(PaymentsPlans $paymentsPlan): Response
    {
        return $this->render('payments_plans/show.html.twig', [
            'payments_plan' => $paymentsPlan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="payments_plans_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PaymentsPlans $paymentsPlan): Response
    {
        $form = $this->createForm(PaymentsPlansType::class, $paymentsPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('payments_plans_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payments_plans/edit.html.twig', [
            'payments_plan' => $paymentsPlan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="payments_plans_delete", methods={"POST"})
     */
    public function delete(Request $request, PaymentsPlans $paymentsPlan): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paymentsPlan->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paymentsPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('payments_plans_index', [], Response::HTTP_SEE_OTHER);
    }
}
