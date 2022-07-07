<?php

namespace App\Controller;

use App\Entity\BookMark;
use App\Entity\Boosts;
use App\Entity\ChatMessages;
use App\Entity\Company;
use App\Entity\CompanyAttributes;
use App\Entity\CompanyAttributesValues;
use App\Entity\CompanyCategories;
use App\Entity\CompanyWorkingDay;
use App\Entity\DirectMessages;
use App\Entity\Listing;
use App\Entity\ListingReports;
use App\Entity\Newsletters;
use App\Entity\PaymentsPlans;
use App\Entity\PromotionInvoice;
use App\Entity\Promotions;
use App\Entity\Rating;
use App\Entity\SocialMedia;
use App\Entity\User;
use App\Entity\WorkingDays;
use App\Form\ListingReportsType;
use App\Form\NewslettersType;
use App\Form\PromotionInvoiceType;
use App\Repository\AttributesRepository;
use App\Repository\AttributeValuesRepository;
use App\Repository\BookMarkRepository;
use App\Repository\BoostsRepository;
use App\Repository\CategoryRepository;
use App\Repository\ChatMessagesRepository;
use App\Repository\CompanyRepository;
use App\Repository\DirectMessagesRepository;
use App\Repository\HowItHelpsRepository;
use App\Repository\ListingRepository;
use App\Repository\NewslettersRepository;
use App\Repository\PartnersRepository;
use App\Repository\PaymentsPlansRepository;
use App\Repository\PromotionsRepository;
use App\Repository\UserRepository;
use App\Repository\WorkingDaysRepository;
use DateTime;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="main_route")
     */
    public function index(NewslettersRepository $newslettersRepository, Request $request, PaymentsPlansRepository $paymentsPlansRepository, HowItHelpsRepository $howItHelpsRepository, PartnersRepository $partnersRepository, CompanyRepository $companyRepository,ListingRepository $listingRepository): Response
    {
        $latestCompanny = $companyRepository->findBy([
            'isDeleted'=>false,
            'status'=>1
        ],[],5);


        $listings = $listingRepository->findAll(); 

        $partners = $partnersRepository->findAll();

        $howItHelps = $howItHelpsRepository->findAll();



        $newsletter = new Newsletters();
        $newsletter->setDate(new DateTime());
        
        $form = $this->createForm(NewslettersType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            // check if already saved
            $check = $newslettersRepository->findOneBy(['email'=>$newsletter->getEmail()]);
            if ($check != null) {
                return $this->redirectToRoute('main_route', ['message'=>'your email is already saved in our newsletter notifications system'], Response::HTTP_SEE_OTHER);
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($newsletter);
                $entityManager->flush();
    
                return $this->redirectToRoute('main_route', ['message'=>'Your email is successfully registered to our newsletter notifications system'], Response::HTTP_SEE_OTHER);
            }


          
        }

        
        return $this->renderForm('main/index.html.twig', [
             'latestCompanny'=>$latestCompanny,
             "listings"=>$listings,
             "partners"=>$partners,
             'how_it_helps'=>$howItHelps,
             'plans'=>$paymentsPlansRepository->findAll(),
             'newsletter' => $newsletter,
            'nform' => $form,
            'message'=>$request->query->get('message')
        ]);
    }







    /**
     * @Route("/explore", name="marketplace_route")
     */
    public function marketPlace(Request $request, CompanyRepository $companyRepository, CategoryRepository $categoryRepository,ListingRepository $listingRepository): Response
    {
        $user = $this->getUser();

        $isSearching = false;

        $categories = [];
        $companies = $companyRepository->findAll();

        $categories = $categoryRepository->findAll(); 


         
        $queries = $request->query;

        $listingType = null;
        $category = null;
        $search = null;
        $address = null; 
        $pageIndex = 0;
        $orderBy = '1';
        
        if ($queries->get('order-by') != null) {
            $isSearching = true;

            $orderBy = $queries->get('order-by');
        } 
 

        if ($queries->get('page') != null) {
            $pageIndex = $queries->get('page');
            $isSearching = true;
            
        } 


        if ($queries->get('listing-type') != null) {
            $listingType = $queries->get('listing-type');
            $isSearching = true;
            
        }
        if ($queries->get('listing-categories') != null) {
            $category = $queries->get('listing-categories');
            $isSearching = true;
            
        }
        if ($queries->get('search') != null) {
            $search = $queries->get('search');
            $isSearching = true;
            
        }
        if ($queries->get('address') != null) {
            $address = $queries->get('address');
            $isSearching = true;
            
        }

        
        


        $entityManager = $this->getDoctrine()->getManager();


        $ql = "SELECT c FROM App\Entity\Company c WHERE c.isDeleted = 0 AND c.status = 1 "; // 1 approved

 
        if ($listingType != null) {
            $ql.="AND c.listing = :idListing ";
        }
 
        
        if ($search != null) {
            $ql.="AND c.name LIKE :search ";
        }
 
        if ($address != null) {
            $ql.="AND c.address LIKE :address ";
        }

         
  
        if ($orderBy =='1') {
            $ql.="ORDER BY c.avgRating DESC";
        }
        if ($orderBy =='2') {
            $ql.="ORDER BY c.createdAt DESC";
        }
        if ($orderBy =='3') {
            $ql.="ORDER BY c.name ASC";
        }
         
         

        $query = $entityManager->createQuery($ql)
        ->setFirstResult( ($pageIndex * 10) )->setMaxResults(10)
        ;

         
        $queryTotal = $entityManager->createQuery($ql);
        

        if ($listingType != null) {
          
            $query->setParameter('idListing', $listingType) ;
            $queryTotal->setParameter('idListing', $listingType) ;
            
        }

        if ($search != null) {
          
            $query->setParameter('search', '%'.$search.'%') ;
            $queryTotal->setParameter('search', '%'.$search.'%') ;
            
        }

        if ($address != null) {
          
            $query->setParameter('address', $address) ;
            $queryTotal->setParameter('address', $address) ;
            
        }

        
        $list = $query->getResult();

        // now we need to loop the list for testing if user are expired


        /**
         * @var mixed $lastList
         */
        $lastList = array();

        $companiesMarkers = array();


        foreach ($list as $key => $company) {
           $res =  $this->checkListingAvaibility($company);

           if ($res) {
            array_push($lastList,$company);
            array_push($companiesMarkers,array('id'=>$company->getId(),'lng'=>$company->getLng(),'lat'=>$company->getLat(),'name'=>$company->getName(),'logo'=>$company->getLogoURL(),'address'=>$company->getAddress(),'coverImageURL'=>$company->getCoverImageURL()));
               

           }
        }

        

        
         


        

        /**
         * @var mixed $lastTotalList
         */
        $lastTotalList = array();

        foreach ($queryTotal->getResult() as $key => $value) {
            $res =  $this->checkListingAvaibility($value);

           if ($res) {
               array_push($lastTotalList,$value);

           }
        }


        // last step we need to check if user is serching if yes we do nothing else w only show promoted items

 
        /**
         * @var mixed $lastTotalList
         */
        $finalDisplay = array();
        foreach ($lastList as $key => $listingTMP) {
            // check if promoted and promotion still valdi !!

            $today = new DateTime();
 

            if ($listingTMP->getStartPromotionAt() != null) { 


               $diffrenceTMP = $today->getTimestamp() - $listingTMP->getStartPromotionAt()->getTimestamp();
               $difInDaysTMP = floor(($diffrenceTMP / 3600) / 24);
               $leftDaysTMP = intval($listingTMP->getPromotedPeriod() - $difInDaysTMP) ;

                if ($leftDaysTMP > 0) {
                    array_push($finalDisplay,$listingTMP);
                }
            }
            

        }

        foreach ($lastList as $key => $listingTMP) {
            // check if promoted and promotion still valdi !!

            $today = new DateTime();
 

            if ($listingTMP->getStartPromotionAt() != null) { 


               $diffrenceTMP = $today->getTimestamp() - $listingTMP->getStartPromotionAt()->getTimestamp();
               $difInDaysTMP = floor(($diffrenceTMP / 3600) / 24);
               $leftDaysTMP = intval($listingTMP->getPromotedPeriod() - $difInDaysTMP) ;

                if ($leftDaysTMP > 0) {
                    
                }else{
                    array_push($finalDisplay,$listingTMP);
                }
            } else{
                array_push($finalDisplay,$listingTMP);
            }
            

        }



 
        $lastList = $finalDisplay;
         


        return $this->render('app/marketplace.html.twig', [ 
            'listings'=>$listingRepository->findAll(),
            'categories'=>$categories,
            'companies'=>$lastList,
            "companiesMarkers"=>$companiesMarkers,
            'totalCompanies'=> sizeof($lastTotalList) ,
            'listingType'=>$listingType,
            'search'=>$search,
            "address"=>$address,
            "category"=>$category,
            "pageIndex"=>$pageIndex,
            "nextPageIndex"=>($pageIndex+1),
            "previousPageIndex"=> ($pageIndex-1) < 0 ? 0 :($pageIndex-1),
            "orderBy"=>$orderBy,
            'isSearching'=>$isSearching,
            'trial'=>$user->getLastBoughtPlanType() == null ? true : false
        ]);
    }

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
     * @Route("/checkout-trial-version", name="checkout_trial_version")
     */
    public function checkout_trial_version(PaymentsPlansRepository $paymentsPlansRepository): Response
    {

        return $this->redirectToRoute('plans_pricing', [], Response::HTTP_SEE_OTHER);

        /**
         * $plans = $paymentsPlansRepository->findAll();

        *return $this->render('main/checkout-trial.html.twig', [
         *   'plans'=>$plans
        *]);
         */
    }


    /**
     * @Route("/company/{id}", name="company_route")
     */
    public function companyPage(Company $company,Request $request): Response
    {

        // check if user have a plan
        $user = $this->getUser();

        if ($user->getLastBoughtPlanType() == null ) {
            return $this->redirectToRoute('checkout_trial_version', [], Response::HTTP_SEE_OTHER);


        }else{

            $today = new DateTime();

            $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
            $difInDays = floor(($diff / 3600) / 24);
    
            $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;

            if ( $leftDays <= 0) {
                return $this->redirectToRoute('checkout_trial_version', [], Response::HTTP_SEE_OTHER); 
            }else{

                $method = $request->getMethod();
                if ($method == 'POST') {
                    $params = $request->request;
                    $files = $request->files; 
        
                    $rating = new Rating();
        
                    
        
                    if ($params->get('overall-rating') != null ) {
                        $rating->setOverall($params->get('overall-rating'));
                    }
        
                    if ($params->get('hospitality') != null ) {
                        $rating->setHospitality($params->get('hospitality'));
                    }
                    if ($params->get('services') != null ) {
                        $rating->setServices($params->get('services'));
                    }
                    if ($params->get('pricing') != null ) {
                        $rating->setPricing($params->get('pricing'));
                    }
          
                    $rating->setReview($params->get('message'));
        
                    // check for image 
                    $image = $files->get('image');   
                    if ($image) {
                        $newFilename = uniqid().'.'.$image->guessExtension();  
                        try {  
                            $image->move('assets/img/companies/reviews',
                                $newFilename
                            );
                            $rating->setJoinedImageURL('/assets/img/companies/reviews/'.$newFilename); 
        
                        } catch (FileException $e) { 
                            $rating->setJoinedImageURL(null); 
                        }
         
                        
                    } 
                    $rating->setDate(new DateTime());
        
                    $avg = ($rating->getOverall() + $rating->getHospitality() + $rating->getServices() + $rating->getPricing() ) / 4;
                    
                    $rating->setAverage($avg);
                    $rating->setUser($this->getUser());
                    $rating->setCompany($company);
        
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($rating);
                    $entityManager->flush();
        
        
        
                    $newRating = 0;
        
                    $nbrOfRatings = sizeof($company->getRatings());
                    $sumOfRatinsg = 0;
        
                    for ($i=0; $i < $nbrOfRatings ; $i++) { 
                        $rating = $company->getRatings()[$i];
                        $sumOfRatinsg+=$rating->getAverage();
                        
                    }
        
                    $newRating = ( $sumOfRatinsg / $nbrOfRatings );
        
                    $company->setAvgRating($newRating); 
                    $this->getDoctrine()->getManager()->flush();
        
                    
                    
                }
        
        
                
        
                $listingReport = new ListingReports();
                $listingReportForm = $this->createForm(ListingReportsType::class, $listingReport);
                $listingReportForm->handleRequest($request);
        
                if ($listingReportForm->isSubmitted() && $listingReportForm->isValid()) {
        
                    $listingReport->setListing($company);;
                    $listingReport->setReporter($this->getUser());
                    $listingReport->setReportDate(new DateTime());
        
        
        
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($listingReport);
                    $entityManager->flush();
        
                    return $this->redirectToRoute('company_route', ['id'=>$company->getId(),'message'=>"Thanks for your feedback."], Response::HTTP_SEE_OTHER);
                }
        
                $message="";
        
                if ($request->query->get('message') != "" ) {
                    $message = $request->query->get('message');
                }
        
                 
        
                return $this->render('main/company.html.twig', [
                     'company'=>$company,
                     'listingReportForm'=>$listingReportForm->createView(),
                     "message"=>$message
                ]);
            }
            }



         
        
    }

    /**
     * @Route("/user/{id}", name="user_route")
     */
    public function userPage(User $user, Request $request): Response
    {
         $method = $request->getMethod();


         if ($method == 'POST') { 
            if ($request->request->get('about') != null) {
                $this->getUser()->setAbout($request->request->get('about'));
                $this->getDoctrine()->getManager()->flush();
            }
         }

        return $this->render('main/user.html.twig', [
             'user'=>$user
        ]);
    }

    



    /**
     * @Route("/account/edit-company/{id}", name="edit_listing_route", methods={"GET","POST"})
     */
    public function editListing(AttributeValuesRepository $attributeValuesRepository, AttributesRepository $attributesRepository, Company $company, Request $request,WorkingDaysRepository $workingDaysRepository, CategoryRepository $categoryRepository): Response
    {
        $listing = $company->getListing();
         
        $method = $request->getMethod();
        if ($method=='POST') {
            $params = $request->request;
            $files = $request->files;

            $company->setName(trim($params->get("companyName")));
            $company->setSlogan(trim($params->get("slogan")));
            $company->setDescription(trim($params->get("description")));
            $company->setVideoURL(trim($params->get("videoURL")));
            $company->setEmail(trim($params->get("email")));
            $company->setWebsite(trim($params->get("website")));
            
            $company->setTimezone(trim($params->get("timezone")));
            
            $company->setLng(trim($params->get("longitude")));
            $company->setLat(trim($params->get("latitude")));
            $company->setAddress(trim($params->get("locationSTR")));
            $company->setAvgRating(0);
            $company->setAddionalInformations(trim($params->get("additinal-information")));
            

            $logo_iamge = $files->get('logo_iamge');   
            if ($logo_iamge) {
                $newFilename = uniqid().'.'.$logo_iamge->guessExtension();  
                try {  
                    $logo_iamge->move('assets/img/companies',
                        $newFilename
                    );
                    $company->setLogoURL('/assets/img/companies/'.$newFilename); 

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    $company->setLogoURL('/assets/img/companies/blank-logo.png');
                }
 
                
            } 

            $cover_image = $files->get('cover_image');   
            if ($cover_image) {
                $newFilename = uniqid().'.'.$cover_image->guessExtension();  
                try {  
                    $cover_image->move('assets/img/companies',
                        $newFilename
                    );

                    $company->setCoverImageURL('/assets/img/companies/'.$newFilename);
                    


                } catch (FileException $e) { 
                    $company->setCoverImageURL('/assets/img/companies/blank-cover.png');
                } 
                 
            } 


            try {
                $categories = $params->get("categories"); 
                $sql = "DELETE  FROM `company_categories` WHERE `company_id` = ".$company->getId();
                $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
                $stmt->execute();
                 


                foreach ($categories as $key => $value) {
                    $tmp = new CompanyCategories();
                    $tmp->setCategory($categoryRepository->findOneBy(['id'=>$value]));
                    $tmp->setCompany($company);

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($tmp);
                    $entityManager->flush();

                }
           
            } catch (\Throwable $th) { 
            }



            try {
                $categories = $params->get("categories"); 
                $sql = "DELETE FROM `company_working_day` WHERE `company_id` = ".$company->getId();
                $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
                $stmt->execute();






                // working days
             $days = $workingDaysRepository->findAll();

              
                 for ($i=0; $i < sizeof($days); $i++) { 
                     $day = $days[$i];
                     $formDay = $params->get('day-'.$day->getId());
     
                     $dateName = $day->getDay();
 
                     if ($formDay == 'Open all day' ) {
                         if ($params->get('open-all-day-start-'.$day->getId()) != null) {
                             $formDay=$formDay.' from  '. $params->get('open-all-day-start-'.$day->getId());
                             $formDay=$formDay.' to '.$params->get('open-all-day-end-'.$day->getId());
                         }
                         
                         
                     }
     
                     $tmp = new CompanyWorkingDay();
                     $tmp->setDay($dateName);
                     $tmp->setValue($formDay);
                     $tmp->setCompany($company);
     
                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($tmp);
                     $entityManager->flush();
                 }
      
 
           
            } catch (\Throwable $th) { 
            }





             


             // social medias 
             $socials = $params->get("social");
             $socialsURL = $params->get("url");
             
             try {
                $sql = "DELETE FROM `social_media`  WHERE `company_id` = ".$company->getId();
                $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
                $stmt->execute(); 


                foreach ($socials as $key => $value) { 
                     $tmp = new SocialMedia();
                     $tmp->setName($value);
                     $tmp->setValue($socialsURL[$key]);
                     
                     $tmp->setCompany($company);
     
                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($tmp);
                     $entityManager->flush();
     
                }
             } catch (\Throwable $th) {
                 //throw $th;
             } 

             // attrs
            // attributes and values
            $allAttributes = $attributesRepository->findAll();
             try {

                // first we delete the attr values ! 
                $attrs = $company->getCompanyAttributes();
                
                foreach ($attrs as $key => $value) {
                    // get the values 

                   $attrValues =  $value->getCompanyAttributesValues();

                   foreach ($attrValues as $k => $v) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($v);
                    $entityManager->flush();
                   }

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($value);
                    $entityManager->flush();
 
                } 

                for ($i=0; $i < sizeof($allAttributes); $i++) { 
                    $idAttr = $allAttributes[$i]->getId();
    
                    if ($params->get('attribute-'.$idAttr) != null ) {
                        $selectedAttribute = $allAttributes[$i];
    
                        $CompanyAttributes = new CompanyAttributes();
                        $CompanyAttributes->setCompany($company);
                        $CompanyAttributes->setAttribute($selectedAttribute);
    
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($CompanyAttributes);
                        $entityManager->flush();
    
                        // now we hundle them values
                        $attributeValuesArray = $params->get('attribute-'.$idAttr);
    
                        foreach ($attributeValuesArray as $key => $value) {
                            $attributeValue = $attributeValuesRepository->findOneBy(['id'=>$value]);
    
                            $tmp = new CompanyAttributesValues();
                            $tmp->setSelectedCompanyAttribute($CompanyAttributes);
                            $tmp->setValue($attributeValue);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($tmp);
                            $entityManager->flush();
    
                        }
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            } 




            

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('company_route', ['id'=>$company->getId()], Response::HTTP_SEE_OTHER);


            
        }

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;


        return $this->render('app/edit-listing.html.twig', [
            "categories"=>$categoryRepository->findBy(['listing'=>$listing]),
            'company'=>$company,
            "days"=>$workingDaysRepository->findAll(),
            'leftDays'=>$leftDays
        ]);
    }


    /**
     * @Route("/account/new-listing/{id}", name="new_listing_route", methods={"GET","POST"})
     */
    public function newListing(AttributeValuesRepository $attributeValuesRepository, AttributesRepository $attributesRepository, Listing $listing, Request $request,WorkingDaysRepository $workingDaysRepository, CategoryRepository $categoryRepository): Response
    {
        
        // check if user have a plan
        $user = $this->getUser();

        if ($user->getLastBoughtPlanType() == null ) {
              return $this->redirectToRoute('checkout_trial_version', [], Response::HTTP_SEE_OTHER); 
        } else {
            $today = new DateTime();

            $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
            $difInDays = floor(($diff / 3600) / 24);
    
            $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;

            if ( $leftDays <= 0) {
                return $this->redirectToRoute('checkout_trial_version', [], Response::HTTP_SEE_OTHER); 
            }else{

                $method = $request->getMethod();
                if ($method=='POST') {
                    $params = $request->request;
                    $files = $request->files;
         
         
        
                    $company = new Company();
                    $company->setName(trim($params->get("companyName")));
                    $company->setSlogan(trim($params->get("slogan")));
                    $company->setDescription(trim($params->get("description")));
        
                    $company->setVideoURL(trim($params->get("videoURL")));
                    $company->setIsDeleted(false);
        
                    
        
                    $company->setEmail(trim($params->get("email")));
                    $company->setWebsite(trim($params->get("website")));
                    
                    $company->setTimezone(trim($params->get("timezone")));
                    $company->setAddress(trim($params->get("locationSTR")));
                    $company->setLng(trim($params->get("longitude")));
                    $company->setLat(trim($params->get("latitude")));
                    $company->setAddress(trim($params->get("locationSTR")));
                    $company->setAddress(trim($params->get("locationSTR")));
                    $company->setAddionalInformations(trim($params->get("additinal-information")));
                    $company->setCreatedAt(new DateTimeImmutable());
                    $company->setStatus(0);
                    $company->setUser($this->getUser());
                    $company->setListing($listing);
                    
                    // images
                    
                    $logo_iamge = $files->get('logo_iamge');   
                    if ($logo_iamge) {
                        $newFilename = uniqid().'.'.$logo_iamge->guessExtension();  
                        try {  
                            $logo_iamge->move('assets/img/companies',
                                $newFilename
                            );
                            $company->setLogoURL('/assets/img/companies/'.$newFilename); 
        
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                            $company->setLogoURL('/assets/img/companies/blank-logo.png');
                        }
         
                        
                    }else{
                        $company->setLogoURL('/assets/img/companies/blank-logo.png');
                    }
        
                    $cover_image = $files->get('cover_image');   
                    if ($cover_image) {
                        $newFilename = uniqid().'.'.$cover_image->guessExtension();  
                        try {  
                            $cover_image->move('assets/img/companies',
                                $newFilename
                            );
        
                            $company->setCoverImageURL('/assets/img/companies/'.$newFilename);
                            
        
        
                        } catch (FileException $e) { 
                            $company->setCoverImageURL('/assets/img/companies/blank-cover.png');
                        } 
                         
                    }else{
                        $company->setCoverImageURL('/assets/img/companies/blank-cover.png');
                    }
        
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($company);
                            $entityManager->flush();
                    // categories
                    
                    try {
                        $categories = $params->get("categories");
                    foreach ($categories as $key => $value) {
                        $tmp = new CompanyCategories();
                        $tmp->setCategory($categoryRepository->findOneBy(['id'=>$value]));
                        $tmp->setCompany($company);
        
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($tmp);
                        $entityManager->flush();
        
                    }
                   
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
        
        
                    // social medias 
                    $socials = $params->get("social");
                    $socialsURL = $params->get("url");
                    
                    try {
                        foreach ($socials as $key => $value) {
        
                            $tmp = new SocialMedia();
                            $tmp->setName($value);
                            $tmp->setValue($socialsURL[$key]);
                            
                            $tmp->setCompany($company);
            
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($tmp);
                            $entityManager->flush();
            
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
        
                    // working days
                    $days = $workingDaysRepository->findAll();
        
                    try {
                        for ($i=0; $i < sizeof($days); $i++) { 
                            $day = $days[$i];
                            $formDay = $params->get('day-'.$day->getId());
            
                            $dateName = $day->getDay();
        
                            if ($formDay == 'Open all day' ) {
                                if ($params->get('open-all-day-start-'.$day->getId()) != null) {
                                    $formDay=$formDay.' from  '. $params->get('open-all-day-start-'.$day->getId());
                                    $formDay=$formDay.' to '.$params->get('open-all-day-end-'.$day->getId());
                                }
                                
                                
                            }
            
                            $tmp = new CompanyWorkingDay();
                            $tmp->setDay($dateName);
                            $tmp->setValue($formDay);
                            $tmp->setCompany($company);
            
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($tmp);
                            $entityManager->flush();
                        }
            
                    } catch (\Throwable $th) {
                        
                    }
                    // attributes and values
                    $allAttributes = $attributesRepository->findAll();
        
                    try {
                        for ($i=0; $i < sizeof($allAttributes); $i++) { 
                            $idAttr = $allAttributes[$i]->getId();
            
                            if ($params->get('attribute-'.$idAttr) != null ) {
                                $selectedAttribute = $allAttributes[$i];
            
                                $CompanyAttributes = new CompanyAttributes();
                                $CompanyAttributes->setCompany($company);
                                $CompanyAttributes->setAttribute($selectedAttribute);
            
                                $entityManager = $this->getDoctrine()->getManager();
                                $entityManager->persist($CompanyAttributes);
                                $entityManager->flush();
            
                                // now we hundle them values
                                $attributeValuesArray = $params->get('attribute-'.$idAttr);
            
                                foreach ($attributeValuesArray as $key => $value) {
                                    $attributeValue = $attributeValuesRepository->findOneBy(['id'=>$value]);
            
                                    $tmp = new CompanyAttributesValues();
                                    $tmp->setSelectedCompanyAttribute($CompanyAttributes);
                                    $tmp->setValue($attributeValue);
                                    $entityManager = $this->getDoctrine()->getManager();
                                    $entityManager->persist($tmp);
                                    $entityManager->flush();
            
                                }
                            }
                        }
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
        
                    // we done !!
                     return $this->redirectToRoute('my_listing_index', [], Response::HTTP_SEE_OTHER);
                    
                    
            }

            
        }


        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;


        // check if user can create listing


        $canPost = true;
        $cannotPostMessage = '';
        $allowed = 0;

        $boughtPlan = $this->getUser()->getLastBoughtPlanType();

        if ($boughtPlan == null) {
            $canPost = false;
            $cannotPostMessage="You need first to buy to choose a pricing plan in order to add a new listing in the marketplace";
        }else{
            $allowed = $boughtPlan->getAllowedListing() ;
            $alreadyPosted = 0;

            $userCompanies = $this->getUser()->getCompanies();

            foreach ($userCompanies as $key => $company) {
                if ($company->getIsDeleted() == true) {
                    
                }else{
                    $alreadyPosted++;
                }
            }
 
            if ( $alreadyPosted >= $allowed    ) {
                $canPost = false;
                $cannotPostMessage="looks like you reached your offre  limits ";
            } 
     
        }

        

         
       


        return $this->render('app/new-listing.html.twig', [
            "categories"=>$categoryRepository->findBy(['listing'=>$listing]),
            'listing'=>$listing,
            "days"=>$workingDaysRepository->findAll(),
            'leftDays'=>$leftDays,
            'canPost'=> $canPost,
            "cannotPostMessage"=>$cannotPostMessage
        ]);
        }
        

    }

    /**
     * @Route("/account/choose-category", name="choose_listing_route")
     */
    public function preListingChooseCategory(ListingRepository $listingRepository): Response
    {

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;


        return $this->render('app/choose-category.html.twig', [
            "listing"=>$listingRepository->findAll(),
            "leftDays"=>$leftDays
        ]);
    }




    


    
 
    /**
     * @Route("/account/add-book-mark/{id}", name="new_bookmark_index")
     */
    public function addCompanyToMyBookMarks(Company $company,BookMarkRepository $bookMarkRepository): Response
    {
        

        // check 
        $res = $bookMarkRepository->findOneBy(['user'=>$this->getUser(),'company'=>$company]);


        if ($res == null) {
            $bookMark = new BookMark();
            $bookMark->setUser($this->getUser());
            $bookMark->setCompany($company);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookMark);
            $entityManager->flush();

        }
        return $this->redirectToRoute('my_bookmarks_index', [], Response::HTTP_SEE_OTHER);
    }


    

    /**
     * @Route("/account/my-bookmarks", name="my_bookmarks_index")
     */
    public function my_bookmarks_index(): Response
    {

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;

        return $this->render('app/my-bookmarks.html.twig', [
            'leftDays'=>$leftDays
        ]);
    }


    
    /**
     * @Route("/account/remove-book-mark/{id}", name="remove_book_mark")
     */
    public function remove_bookmark(BookMark $bookMark): Response
    {


        $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookMark);
            $entityManager->flush();

        return $this->redirectToRoute('my_bookmarks_index', [], Response::HTTP_SEE_OTHER);
    }

    
    
    


    /**
     * @Route("/account/my-listing", name="my_listing_index")
     */
    public function myListingPage(Request $request, BoostsRepository $boostsRepository, CompanyRepository $companyRepository, PromotionsRepository $promotionsRepository): Response
    {
        //  0 = pending 1 = published 2 waiting for payment 3 expired
 

        $filter = $request->query->get('filter');

         

        $user = $this->getUser();

        $published = $companyRepository->findBy(['user'=>$user,'status'=>1,"isDeleted"=>false]);
        $pending = $companyRepository->findBy(['user'=>$user,'status'=>0,"isDeleted"=>false]);
        $waitingForPayment = $companyRepository->findBy(['user'=>$user,'status'=>2,"isDeleted"=>false]);
        $expried = 0;

        foreach ($published as $key => $company) {
            $res = $this->checkListingAvaibility($company);
            if ($res == false) {
                $expried++;
            }
        }


        
        $all =  [];

        if ($filter == null) {
            $all = $companyRepository->findBy(['user'=>$user,"isDeleted"=>false]);
        }else{

            if ($filter == '0') {
                $all = $companyRepository->findBy(['user'=>$user,"isDeleted"=>false]);
            }

            if ($filter == '1') {
                $all = $companyRepository->findBy(['user'=>$user,'status'=>1,"isDeleted"=>false]);
            }
            
            if ($filter == '2') {
                $all = $companyRepository->findBy(['user'=>$user,'status'=>0,"isDeleted"=>false]);
            }
            
             
            
        }
        

        

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;

        return $this->render('app/my-listing.html.twig', [
            'published'=>$published,
            'pending'=>$pending,
            'waitingForPayment'=>$waitingForPayment,
            'expried'=>$expried,
            'all'=>$all,
            'leftDays'=>$leftDays,
            'promotions'=>$promotionsRepository->findAll(),
            'boosts'=>$boostsRepository->findAll(),
            "filterListing"=>$filter
             
        ]);
    }

    




    



    /**
     * @Route("/buy-promtion-listing/{listing}/{promotion}", name="checkout_promotion_final_route")
     */
    public function finalPromotionCheckoutUpdate( Company $listing, Promotions $promotion, Request $request): RedirectResponse 
    {
            $listing->setPromotedPeriod($promotion->getDuration());
            $listing->setStartPromotionAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();

            
            return $this->redirectToRoute('my_promoted_items_index', [], Response::HTTP_SEE_OTHER);


    }


    /**
     * @Route("/account/my-promotions", name="my_promoted_items_index")
     */
    public function my_promoted_items_index( CompanyRepository $companyRepository ): Response
    {

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;

        $em =   $this->getDoctrine()->getManager();

        

        $query = $em->createQuery(
            'SELECT p
            FROM App\Entity\Company p
            WHERE p.user = :id AND
            p.promotedPeriod IS NOT NULL '
        )->setParameter('id', $this->getUser()->getId());

        // returns an array of Product objects
          ;


        $myPromotedListing =  $query->getResult();

         

        $lastArray = [];

        for ($i=0; $i < sizeof($myPromotedListing); $i++) { 
            $listingTMP  = $myPromotedListing[$i];

            $diffrenceTMP = $today->getTimestamp() - $listingTMP->getStartPromotionAt()->getTimestamp();
            $difInDaysTMP = floor(($diffrenceTMP / 3600) / 24);
            $leftDaysTMP = intval($listingTMP->getPromotedPeriod() - $difInDaysTMP) ;
            
             

            array_push($lastArray,array("company"=>$listingTMP,"days"=>$leftDaysTMP));
        }


        return $this->render('app/my-promotions.html.twig', [ 
            "leftDays"=>$leftDays,
            'myPromotedListing'=>$lastArray
        ]);
    }




    /**
     * @Route("/account/delete-company/{id}", name="company_account_delete" )
     */
    public function delete(Request $request, Company $company): Response
    {
         
        $company->setIsDeleted(true);
    
        $this->getDoctrine()->getManager()->flush();
        
        return $this->redirectToRoute('my_listing_index', [], Response::HTTP_SEE_OTHER);
    }





    /**
     * @Route("/checkout/{listing}/{promotion}", name="checkout_route")
     */
    public function checkout( Company $listing, Promotions $promotion, Request $request): Response
    {
        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;
        


        return $this->renderForm('main/checkout.html.twig', [
            'leftDays' => $leftDays,
            'promotion'=>$promotion,
            'company'=>$listing
        ]);
 
    }


    /**
     * @Route("/boost/checkout/{listing}/{boost}", name="checkout_boost_route")
     */
    public function boostCheckout( Company $listing, Boosts $boost, Request $request): Response
    {
        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;
   
 
        return $this->renderForm('main/boost-checkout.html.twig', [
            'leftDays' => $leftDays, 
            'company'=>$listing,
            'boost'=>$boost
        ]);
 
    }



    /**
     * @Route("/account/send-message/{id}", name="send_direct_message")
     */
    public function sendDirectMessage( User $user, Request $request ): JsonResponse
    { 

        try {
            $content= $request->request->get('content');

            $directMessage = new DirectMessages();

            $directMessage->setContent($content);
            $directMessage->setSendDate(new DateTime());
            $directMessage->setVue(0);
            $directMessage->setSender($this->getUser());
            $directMessage->setReciever($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($directMessage);
            $entityManager->flush();

            return $this->json(['success'=>true,'message_id'=>$directMessage->getId()]);
        } catch (\Throwable $th) {
            
            return $this->json(['success'=>false]);
        }

        


 
    }

    /**
     * @Route("/account/inbox", name="my_inbox_route")
     */
    public function my_inbox_route( Request $request, DirectMessagesRepository $directMessagesRepository ): Response
    { 

        $myMessages = $directMessagesRepository->findBy(['reciever'=>$this->getUser()->getId()]);

        return $this->renderForm('main/inbox.html.twig', [
             'myMessages'=>$myMessages
        ]);
 
 
    }


    /**
     * @Route("/account/fetch-message/{id}", name="fetch_message")
     */
    public function direct_message_fetch( DirectMessages $directMessages ): JsonResponse
    { 
        $directMessages->setVue(1);
        $this->getDoctrine()->getManager()->flush();
         
        $res = array(
            'fullname'=>$directMessages->getSender()->getFirstname().' '.$directMessages->getSender()->getLastname(),
            'id_sender'=>$directMessages->getSender()->getId(),
            'date'=>$directMessages->getSendDate(),
            'content'=>$directMessages->getContent(),
            
        );

        return $this->json($res);
 
    }

    
    /**
     * @Route("/account/update-membership", name="update_membership_route")
     */
    public function FunctionName( PaymentsPlansRepository $paymentsPlansRepository ): Response
    {  


       return $this->renderForm('main/update-membership-route.html.twig', [
           'plans'=> $paymentsPlansRepository->findAll()
       ]);


    }
    

    /**
     * @Route("/account/membership-checkout/{id}", name="membership_checkout_route")
     */
    public function membership_checkout(Request $request, PaymentsPlans $plan, SessionInterface $sessionInterface ): Response
    {  
 

        $sessionInterface->set("plan",$plan->getId());

       return $this->renderForm('main/checkout-membership.html.twig', [
           'plan'=> $plan
       ]);


    }


    
    /**
     * @Route("/account/membership_checkout_success_callback", name="membership_checkout_success_callback_route")
     */
    public function membership_checkout_success_callback( PaymentsPlansRepository $paymentsPlansRepository ,  SessionInterface $sessionInterface ): Response
    {  

        $user = $this->getUser();

        if ($sessionInterface->get("plan") != null) {


            $planID = $sessionInterface->get("plan");

            $plan = $paymentsPlansRepository->findOneBy(['id'=>$planID]);
            

            $user->setLastBoughtPlanType($plan);

            // now we update the days for the user
            $user->setBoughtDays( ($user->getBoughtDays() + $plan->getDuration() )  );

            $this->getDoctrine()->getManager()->flush();
            
            return $this->redirectToRoute('profile_route', [ ], Response::HTTP_SEE_OTHER);

        }else{
            return $this->redirectToRoute('profile_route', [ ], Response::HTTP_SEE_OTHER);

        }

       


    }
    



    /**
     * @Route("/account/dicussions", name="all_chat_route")
     */
    public function dicussions( ChatMessagesRepository $chatMessagesRepository, UserRepository $userRepository ): Response
    {
        // create a list of contacts
        $contacts = [];

        $uid = $this->getUser()->getId();
    

        
        
        $sql1 = 'SELECT * FROM `chat_messages` WHERE `sender_id` = '.$uid.' GROUP BY `receiver_id`';
        $stmt1 = $this->getDoctrine()->getManager()->getConnection()->prepare($sql1);
        $stmt1->execute();


        $data = $stmt1->fetchAll();
 

        $users = [];

        for ($i=0; $i < sizeof($data); $i++) { 
            $tmp = $userRepository->findOneBy(['id'=>$data[$i]['receiver_id']]);
            array_push($users,$tmp);
        }


 
        // talking to me
        $sql2 = 'SELECT * FROM `chat_messages` WHERE `receiver_id` = '.$uid.' GROUP BY `sender_id`';
        $stmt2 = $this->getDoctrine()->getManager()->getConnection()->prepare($sql2);
        $stmt2->execute();
         
        $data2 = $stmt2->fetchAll();
 

        dump($data2);

        foreach ($data2 as $key => $value) {
            $tmp = $userRepository->findOneBy(['id'=>$value['sender_id']]);
            // check if we already addedd user

            dump($tmp);

            $toBeAdded = true;

            for ($i=0; $i < sizeof($users); $i++) { 
                # code...
                if ($users[$i]->getId() == $tmp->getId()) {
                    $toBeAdded = false;

                }
                
            }

            if ($toBeAdded == true) {
                array_push($users,$tmp);
            }
        }


       


        return $this->renderForm('chat/all.html.twig', [
            'contacts'=>$users
        ]);

    }


    

    
}
