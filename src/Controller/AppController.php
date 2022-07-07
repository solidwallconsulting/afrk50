<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Entity\Message;
use App\Entity\Partnership;
use App\Entity\PrintHistory;
use App\Form\MessageType;
use App\Form\PartnershipType;
use App\Repository\CategoryRepository;
use App\Repository\CompanyRepository;
use App\Repository\ContactsRepository;
use App\Repository\HowItHelpsRepository;
use App\Repository\PartnersRepository;
use App\Repository\PaymentsPlansRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppController extends AbstractController
{

    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }



    
 

    /**
     * @Route("/redirection-auth-route", name="redirection_auth_route")
     */
    public function redirectionAfterLogin(): Response
    {
        
        if ( $this->getUser()->getRoles()[0] == 'ROLE_ADMIN' ) {
            return $this->redirectToRoute('web_master_route', [], Response::HTTP_SEE_OTHER);
        }else{
            return $this->redirectToRoute('profile_route',  [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @Route("/all-categories", name="all_categories_route")
     */
    public function allCategories(CategoryRepository $categoryRepository): Response
    {

        return $this->render('app/all-categories.html.twig', [
             'categories'=>$categoryRepository->findAll()
        ]);
    }

 
    /**
     * @Route("/web-master", name="web_master_route")
     */
    public function web_master_route(UserRepository $userRepository ): Response
    { 
        $members = $userRepository->findAll(); 


   
        return $this->render('admin/index.html.twig', [
            "members"=>$members, 
            
            
        ]);
    }

 

        
    /**
     * @Route("/forget-password", name="forget_password_route", methods={"GET","POST"})
     */
    public function forgetPassword(Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $errorMessage='';
        $successMessage='';
        

        if ($request->getMethod() == 'POST') {
            $email = trim($request->request->get('email'));
            $user = $userRepository->findOneBy(['email'=>$email]);
            if ($user != null) {

                $domaine = $request->server->get('HTTP_HOST');
                $token = uniqid($email,true);

                $blocEmail = '
                <h3>Forgot your password?</h3> 
                <p>You told us that you forgot your password. Set a new one by following the link below.</p>
                <a href="https://'.$domaine.'/new-password?token='.$token.'">Reset password</a>
                <hr/>';
                $blocEmail.="<p>If you don't need to reset your password, just ignore this email. Your password will not change.</p>";                
 

                $user->setResetPasswordToken($token);

                $this->getDoctrine()->getManager()->flush();


                // send verification mail
                $emailMessage = (new Email())
                ->from('afrk50team@gmail.com')
                ->to($email) 
                ->priority(Email::PRIORITY_HIGH)
                ->subject('Forget password AFRK50 account')
                ->html($blocEmail);

            

            try {
                $mailer->send($emailMessage);
                $successMessage="a verification email has been successfully sent to".$email.", please check your inbox.";
             
            } catch (\Throwable $th) {
                
            }
 
               
            }else{
                $errorMessage= 'Wrong email address, please try again';
            }
        
        }



        return $this->render('app/forget-password.html.twig', [ 
            'errorMessage'=>$errorMessage,
            'successMessage'=>$successMessage
       ]);
    }


    

    /**
     * @Route("/new-password", name="new_password_route", methods={"GET","POST"})
     */
    public function newPassword(Request $request,UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $errorMessage='';
        $successMessage=''; 

        if ($request->getMethod() == 'POST') {

            $token = $request->query->get('token'); 
            $newPasswordTXT = trim($request->request->get('new-password'));
            $user = $userRepository->findOneBy(['resetPasswordToken'=>$token]);

             
           if ($user != null) {
              
            $user->setPassword($this->encoder->encodePassword($user,$newPasswordTXT));
            $user->setResetPasswordToken(null);

            $this->getDoctrine()->getManager()->flush();

            $successMessage ='Your password is updated successfully.';
            
           }else{
               $errorMessage ='Looks like you are using an old link.';
           }
        
        }



        return $this->render('app/new-password.html.twig', [ 
            'errorMessage'=>$errorMessage,
            'successMessage'=>$successMessage
       ]);
    }


    


    /**
     * @Route("/choose-account-to-create", name="choose_account_to_create_route")
     */
    public function choose_account_to_create_route( ): Response
    {
        return $this->render('app/choose-account-to-create.html.twig', [ 
        ]);
    }

    /**
     * @Route("/faq", name="faq_route")
     */
    public function faq_route( ): Response
    {
        return $this->render('app/faq.html.twig', [ 
        ]);
    }


    /**
     * @Route("/contact", name="contact_route")
     */
    public function contactPage( Request $request ): Response
    {

        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message->setSentAt(new DateTime());
            $message->setIsSeen(false);
            

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('contact_route', ["message"=>"Your message is successfully sent, we will contact you as soon as possible."], Response::HTTP_SEE_OTHER);
        }

         
        $message="";

        if ($request->query->get('message') != null) {
            $message = $request->query->get('message');
        }


        return $this->renderForm('app/contact.html.twig', [ 
            'message' => $message,
            'form' => $form,
            "message"=>$message
        ]);
    }





    /**
     * @Route("/tell-us-more", name="tell_us_more_route")
     */
    public function tell_us_more_route( Request $request ): Response
    {

        $data = new Partnership();
        $form = $this->createForm(PartnershipType::class, $data);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            return $this->redirectToRoute('tell_us_more_route', ["message"=>"Your message is successfully sent, we will contact you as soon as possible."], Response::HTTP_SEE_OTHER);
        }

         
        $message="";

        if ($request->query->get('message') != null) {
            $message = $request->query->get('message');
        }


        return $this->renderForm('app/partnership.html.twig', [ 
            'data' => $data,
            'form' => $form,
            "message"=>$message
        ]);
    }



    /**
     * @Route("/customer-reviews", name="customer_reviews")
     */
    public function customer_reviews(HowItHelpsRepository $howItHelpsRepository ): Response
    {
        $howItHelps = $howItHelpsRepository->findAll();

        return $this->render('app/customer-reviews.html.twig', [ 
            'how_it_helps'=>$howItHelps
        ]);
    }


 

    /**
     * @Route("/plans-pricing", name="plans_pricing")
     */
    public function plans_pricing( PaymentsPlansRepository $paymentsPlansRepository ): Response
    {
         
        
        return $this->render('app/plans-pricing.html.twig', [ 
            'plans'=>$paymentsPlansRepository->findAll()
        ]);
    }



    
    /**
     * @Route("/about", name="about_route")
     */
    public function about_route(  ): Response
    {
         
        
        return $this->render('app/about.html.twig', [  
        ]);
    }



    /**
     * @Route("/privacy-policy", name="privacy_policy")
     */
    public function FunctionName(): Response
    {
        return $this->render('app/privacy-policy.html.twig', []);
    }


    /**
     * @Route("/our-solutions", name="our_solutions")
     */
    public function ourSolutions(): Response
    {
        return $this->render('app/our-solutions.html.twig', []);
    }



    /**
     * @Route("/imprint", name="Imprint_route")
     */
    public function imprint(   ): Response
    { 
          

        return $this->render('app/imprint.html.twig', [ 
        ]);
    }

    /**
     * @Route("/general-terms-and-conditions", name="general_terms_and_conditions_route")
     */
    public function gtac(   ): Response
    { 
         

        return $this->render('app/general-terms-and-conditions.html.twig', [ 
        ]);
    }

    /**
     * @Route("/our-partners", name="our_partners")
     */
    public function our_partners( PartnersRepository $partnersRepository ): Response
    {
         

        $partners = $partnersRepository->findAll(); 

        return $this->render('app/our-partners.html.twig', [
             "partners"=>$partners
        ]);
    }



    /**
     * @Route("/features", name="features_route")
     */
    public function features_route( ): Response
    {  
        return $this->render('app/features_route.html.twig', [
             
        ]);
    }



    /**
     * @Route("/account/features/checkout/{checkoutID}", name="features_checkout_route")
     */
    public function checkout_feature( $checkoutID ): Response
    {  

        $money = 0.1;
        $stripeID = null;
        $title = null;

        if ( $checkoutID == 'newsletter-branding' ) {
            $money =150;
            $stripeID ='price_1KlWm9IYJLTSS40aKwaZfl0n';
            $title = 'Newsletter branding';
            
        }

        if ( $checkoutID == 'promote-your-listing' ) {
            $money =100;
            $stripeID ='price_1KlWweIYJLTSS40aDoENWFi5';
            $title = 'Promote your Listing';
            
        }


        if ( $checkoutID == 'session-with-a-business-consultant' ) {
            $money =150;
            $stripeID ='price_1KlWxKIYJLTSS40a1T1XoaoB';
            $title = 'Session with a Business Consultant (1h)';
            
        }


        if ( $checkoutID == 'session-with-a-business-incubator' ) {
            $money =150;
            $stripeID ='price_1KlWxoIYJLTSS40asJoAdgpN';
            $title = 'Session with a Business Incubator';
            
        }


        return $this->render('app/feature-checkout.html.twig', [
            'money'=>$money,
            'stripeID'=>$stripeID,
            'title'=>$title
             
        ]);
    }
    

  
}
