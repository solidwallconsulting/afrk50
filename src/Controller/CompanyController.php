<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/web-master/company")
 */
class CompanyController extends AbstractController
{

    
    function checkListingAvaibility($company){

        $today = new DateTime();

        $diff = $today->getTimestamp() - $company->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $company->getUser()->getBoughtDays() - $difInDays ;
        

        if ($leftDays > 0) {
            return true;
        }

        return false;
    }



    /**
     * @Route("/", name="company_index", methods={"GET"})
     */
    public function index(CompanyRepository $companyRepository): Response
    {

        $list =  $companyRepository->findAll();
        /**
         * @var mixed $lastList
         */
        $lastList = array();
        /**
         * @var mixed $lastList
         */
        $expiredList = array();
        

        foreach ($list as $key => $company) {
           $res =  $this->checkListingAvaibility($company);

           if ($res) {
               array_push($lastList,$company);

           }else{
            array_push($expiredList,$company);
           }
        }


        return $this->render('company/index.html.twig', [
            'notExpriredCompanies' =>$lastList,
            'expiredList' =>$expiredList,
            
        ]);
    }

    /**
     * @Route("/new", name="company_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($company);
            $entityManager->flush();

            return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="company_show",  methods={"GET","POST"})
     */
    public function show(Company $company,Request $request): Response
    {

        $method = $request->getMethod();

        if ($method =='POST') {
            $params = $request->request;

            $actions = $request->get('todo-company-status');

            if ($actions == 'accept') {
                $company->setStatus(1);
            }

            if ($actions == 'decline') {
                $company->setStatus(4);
            }
            if ($actions == 'restore') {
                $company->setStatus(0);
            }
            
            $this->getDoctrine()->getManager()->flush();
        }
 
        $today = new DateTime();
  

        $companyOwnerSignupDate = $company->getUser()->getSignupDate()->getTimestamp();

        $diff = $today->getTimestamp() - $companyOwnerSignupDate;

        $diffInDays = floor(($diff / 3600) / 24);

        $ownerBoughtDays = $company->getUser()->getBoughtDays();

        $leftDays = $ownerBoughtDays - $diffInDays;

        
        


        $this->getDoctrine()->getManager()->flush();


        return $this->render('company/show.html.twig', [
            'company' => $company,
            'days'=>$leftDays
        ]);
    }

    /**
     * @Route("/{id}/edit", name="company_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Company $company): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="company_delete", methods={"POST"})
     */
    public function delete(Request $request, Company $company): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($company);
            $entityManager->flush();
        }

        return $this->redirectToRoute('company_index', [], Response::HTTP_SEE_OTHER);
    }




}
