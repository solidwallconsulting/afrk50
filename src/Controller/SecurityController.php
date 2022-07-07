<?php

namespace App\Controller;

use App\Entity\JobSeekerInfo;
use App\Entity\ProInfo;
use App\Entity\StudentInfo;
use App\Entity\User;
use App\Form\JobSeekerInfoType;
use App\Form\ProInfoType;
use App\Form\StudentInfoType;
use App\Form\UserType;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class SecurityController extends AbstractController
{
    private $encoder;
 
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    
    /**
     * @Route("/verification-mail/{email}", name="verification_mail_route")
     */
    public function verificationMail($email,Request $request, MailerInterface $mailer,UserRepository $userRepository): Response
    { 

        $domaine = $request->server->get('HTTP_HOST');
        $validationToken = uniqid();

        $user=$userRepository->findOneBy(['email'=>$email]);

        $user->setVerificationToken($validationToken);
        $this->getDoctrine()->getManager()->flush();
        


        $blocEmail = ' 
        <h3>Account validation</h3> 
        <p>Thank you for registering on www.afrk50.com</p>
        <a href="https://' . $domaine . '/validate-account-token?token=' . $validationToken . '">Please use this link to complete your registration.</a>
        <hr/>
        
        
        ';
                $blocEmail .= "Team AFRK50";

                $this->getDoctrine()->getManager()->flush();


                // send verification mail
                $emailMessage = (new Email())
                    ->from('afrk50team@gmail.com')
                    ->to($email)
                    ->priority(Email::PRIORITY_HIGH)
                    ->subject('Account validation')
                    ->html($blocEmail);



                try {
                    $mailer->send($emailMessage);
                   

                } catch (\Throwable $th) {
                    dump($th); 
                }






        return $this->render('security/verification.html.twig', ['email' => $email]);
    }



      /**
     * @Route("/validate-account-token", name="verification_mail_with_token_route")
     */
    public function verificationMailTOKEN(UserRepository $userRepository ,Request $request, MailerInterface $mailer): Response
    { 

        $token = $request->query->get('token');
        $user = $userRepository->findOneBy(['verificationToken'=>$token]);

        
        if ($user != null) {
            $user->setIsVerified(true);
            $user->setVerificationToken(null);
            $this->getDoctrine()->getManager()->flush(); 
            return $this->redirectToRoute('profile_route',['success'=>"Your account is successfully activated"]); 

        } else {
            return $this->redirectToRoute('profile_route',[ ]);
        }
         
    }


    





    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('profile_route');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }




    /**
     * @Route("/create-account", name="app_siginup", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        $error="";



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // check if email already in use
            if ($userRepository->findOneBy(['email'=>$user->getEmail()]) != null) {
                $error="This email address is already in use by another user";
            }else{
                $user->setRoles(['ROLE_CLIENT']);
            $user->setPhotoURL('/assets/img/users/avatar.png');
            $user->setIsBlocked(false);
            $user->setSignupDate(new DateTime());
            $user->setBoughtDays(14);
            $user->setPrivacy(0);
            $user->setIsVerified(false);
            $user->setIsLeagalEntity(false);

            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));


            $entityManager->persist($user);
            $entityManager->flush();

 
            return $this->redirectToRoute('verification_mail_route',['email'=>$user->getEmail()]);
            }
 
        }


        
        

        return $this->render('security/signup.html.twig', [
            
            'form' => $form->createView(),
            'error' => $error
        ]);
    }



    /**
     * @Route("/create-company-account", name="company_create_accout_route", methods={"GET","POST"})
     */
    public function newCompany(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user,['isCompany'=>true]);
        $form->handleRequest($request);

        $error="";



        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            // check if email already in use
            if ($userRepository->findOneBy(['email'=>$user->getEmail()]) != null) {
                $error="This email address is already in use by another user";
            }else{
                $user->setRoles(['ROLE_CLIENT']);
            $user->setPhotoURL('/assets/img/users/avatar.png');
            $user->setIsBlocked(false);
            $user->setSignupDate(new DateTime());
            $user->setBoughtDays(14);
            $user->setPrivacy(0);
            $user->setIsVerified(false);

            $user->setFirstname($user->getCompanyName());
            $user->setLastname(" ");
            $user->setIsLeagalEntity(true);
            

            $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));


            $entityManager->persist($user);
            $entityManager->flush();

 
            return $this->redirectToRoute('verification_mail_route',['email'=>$user->getEmail()]);
            }
 
        }
 

        return $this->render('security/signup.html.twig', [
            
            'form' => $form->createView(),
            'error' => $error
        ]);
    }


    
    /**
     * @Route("/account", name="profile_route")
     */
    public function profile(Request $request): Response
    {
        $errMessage='';
        $succMessage='';
        $missingProfileInfo = true;

        
        $user = $this->getUser();
        $options = ['isEditing'=>true];


        if ($user->getIsLeagalEntity() == true) {
            $options = ['isEditing'=>true,'isCompany'=>true];

        }
        
        
        $form = $this->createForm(UserType::class, $user,$options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($user->getIsLeagalEntity() == true) {
                $options = ['isEditing'=>true,'isCompany'=>true];

                $user->setFirstname($user->getCompanyName());
                $user->setLastname(" "); 
            }

            $this->getDoctrine()->getManager()->flush();

            

            return $this->redirectToRoute('profile_route', [], Response::HTTP_SEE_OTHER);
        }

        
        $privacyForm = $this->createForm(UserType::class, $user,['isEditing'=>true,'privacy'=>true,]);
        $privacyForm->handleRequest($request); 
        if ($privacyForm->isSubmitted() && $privacyForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
           
            return $this->redirectToRoute('profile_route', [], Response::HTTP_SEE_OTHER);
        }


        $method = $request->getMethod();

        if ($method == 'POST') {
            $params = $request->request;

            if ($params->get('privacy') !=null) { 
                 
                 $user->setPrivacy( intval($params->get('user_privacy')) );
                 $this->getDoctrine()->getManager()->flush();
                 $succMessage='Privacy updated.';
            }
            
        }


        
 

        $today = new DateTime();

        $diff = $today->getTimestamp() - $this->getUser()->getSignupDate()->getTimestamp();
        $difInDays = floor(($diff / 3600) / 24);

        $leftDays = $this->getUser()->getBoughtDays() - $difInDays ;



        // user more info switch category
        $studentInfo = $user->getStudentInfo();

        if ($studentInfo == null) {
            $studentInfo = new StudentInfo();
            $studentInfo->setUser($user);
        }


        $studentInfoForm = $this->createForm(StudentInfoType::class, $studentInfo);
        $studentInfoForm->handleRequest($request);

        if ($studentInfoForm->isSubmitted() && $studentInfoForm->isValid()) {
             



             /** @var UploadedFile $image */
             
             $studentPass = $studentInfoForm->get('studentPass')->getData();
            
             if ($studentPass) {
                 $newFilename = uniqid().'.'.$studentPass->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $studentPass->move('assets/students/passes/',
                         $newFilename
                     );

                     $studentInfo->setStudentPass('/assets/students/passes/'.$newFilename);


                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($studentInfo);
                     $entityManager->flush();
         
                     return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);


                 } catch (FileException $e) {
                      
                 }
  
                
             }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($studentInfo);
                $entityManager->flush();
    
                return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);

             }


             
        }



        $jobSeakerInfo = $user->getJobSeekerInfo();

        if ($jobSeakerInfo == null) {
            $jobSeakerInfo = new JobSeekerInfo();
            $jobSeakerInfo->setUser($user);
        }

 
        $jobSeakerForm = $this->createForm(JobSeekerInfoType::class, $jobSeakerInfo);
        $jobSeakerForm->handleRequest($request);

        if ($jobSeakerForm->isSubmitted() && $jobSeakerForm->isValid()) {
             
             /** @var UploadedFile $image */
             
             $resumeFILE = $jobSeakerForm->get('resumeFILE')->getData();
            
             if ($resumeFILE) {
                 $newFilename = uniqid().'.'.$resumeFILE->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $resumeFILE->move('assets/job-seackers/files/',
                         $newFilename
                     );

                     $jobSeakerInfo->setResumeFILE('/assets/job-seackers/files/'.$newFilename); 
                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($jobSeakerInfo);
                     $entityManager->flush();
         
                     return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);


                 } catch (FileException $e) {
                      
                 }
  
                
             }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($jobSeakerInfo);
                $entityManager->flush();
    
                return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);

             }

        }
 




        
        $proInfo = $user->getProInfo();

        if ($proInfo == null) {
            $proInfo = new ProInfo();
            $proInfo->setUser($user);
        }


        $proInfoForm = $this->createForm(ProInfoType::class, $proInfo);
        $proInfoForm->handleRequest($request);

        if ($proInfoForm->isSubmitted() && $proInfoForm->isValid()) {
             
             /** @var UploadedFile $image */
             
             $resumeFILE = $proInfoForm->get('resumeFILE')->getData();
            
             if ($resumeFILE) {
                 $newFilename = uniqid().'.'.$resumeFILE->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try { 
                     $resumeFILE->move('assets/pro/files/',
                         $newFilename
                     );

                     $proInfo->setResumeFILE('/assets/pro/files/'.$newFilename); 

                     $entityManager = $this->getDoctrine()->getManager();
                     $entityManager->persist($proInfo);
                     $entityManager->flush();
         
                     return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);


                 } catch (FileException $e) {
                      
                 }
  
                
             }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($proInfo);
                $entityManager->flush();
    
                return $this->redirectToRoute('profile_route', ['success'=>'data updated successfully.'], Response::HTTP_SEE_OTHER);

             }

        }
 



        if ($user->getProInfo() != null) {
            $missingProfileInfo = false;
        }
        
        if ($user->getJobSeekerInfo() != null) {
            $missingProfileInfo = false;
        }
        
        if ($user->getStudentInfo() != null) {
            $missingProfileInfo = false;
        }
        



        return $this->renderForm('app/profile.html.twig', [ 
            'user' => $user, 
            'profileForm' => $form,
            'studentInfoForm'=>$studentInfoForm,
            'jobSeakerForm'=>$jobSeakerForm,
            'proInfoForm'=>$proInfoForm,
            'privacyForm'=>$privacyForm,
            'errMessage'=>$errMessage,
            'succMessage'=>$succMessage,
            'leftDays'=>$leftDays,
            'missingProfileInfo'=>$missingProfileInfo
            
        ]);
    }


    
    /**
     * @Route("/account/update/profile", name="edit_account_data_route", methods={"GET","POST"})
     */
    public function profile_edit_route(Request $request ): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user,['isEditing'=>true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_route', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('app/edit-profile.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }



    
    /**
     * @Route("/account/update/profile-picture-update", name="update_profile_picture", methods={"GET","POST"})
     */
    public function update_profile_picture(Request $request ): Response
    {
        $user = $this->getUser();



        $parameters = $request->request;
        $files = $request->files;
        $method = $request->getMethod();

 
        if ($method == 'POST') {  
            

            $image = $files->get('photo'); 


            // save the user
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $image->move('assets/img/users',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
 
                $user->setPhotoURL('/assets/img/users/'.$newFilename);
                $this->getDoctrine()->getManager()->flush();
            }
            

          
        } 
        

         
        return $this->redirectToRoute('profile_route', [], Response::HTTP_SEE_OTHER); 
        
    }


    
    /**
     * @Route("/account/update/profile-cover-picture-update", name="update_profile_cover_picture", methods={"GET","POST"})
     */
    public function update_profile_cover_picture(Request $request ): Response
    {
        $user = $this->getUser(); 

        $files = $request->files;
        $method = $request->getMethod();

 
        if ($method == 'POST') {  
            

            $image = $files->get('cover'); 


            // save the user
            if ($image) {
                $newFilename = uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try { 

                    
                    $image->move('assets/img/users',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
 
                $user->setCoverURL('/assets/img/users/'.$newFilename);
                $this->getDoctrine()->getManager()->flush();
            }
            

          
        }  
         
        return $this->redirectToRoute('user_route', ['id'=>$user->getId()], Response::HTTP_SEE_OTHER); 
        
    }


    
    




    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
