<?php

namespace App\Controller;

use App\Entity\ChatMessages;
use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account")
 */
class ChatController extends AbstractController
{
    /**
     * @Route("/chat/{id}", name="chat_route")
     */
    public function index(User $user): Response
    {

     

        return $this->render('chat/index.html.twig', [
            'user' => $user,
        ]);
    }


    /**
     * @Route("/init-chat/{id}", name="init_chat")
     */
    public function FunctionName(User $user): JsonResponse
    {
           // get my messages 

           $sql = '

           SELECT `chat_messages`.`id` , `chat_messages`.`sender_id`, `chat_messages`.`receiver_id`, `chat_messages`.`content`, `chat_messages`.`date` , `user`.`firstname` , `user`.`lastname` , `user`.`photo_url` FROM `chat_messages`,`user`  WHERE    `chat_messages`.`sender_id` = '.$user->getId().' AND `chat_messages`.`receiver_id` = '.$this->getUser()->getId().' AND `chat_messages`.`sender_id` = `user`.`id`
            UNION
            SELECT `chat_messages`.`id` , `chat_messages`.`sender_id`, `chat_messages`.`receiver_id`, `chat_messages`.`content`, `chat_messages`.`date` , `user`.`firstname` , `user`.`lastname` , `user`.`photo_url` FROM `chat_messages`,`user` WHERE `chat_messages`.`sender_id` = '.$this->getUser()->getId().' AND `chat_messages`.`receiver_id` = '.$user->getId().'
            AND `chat_messages`.`sender_id` = `user`.`id`

            ORDER BY `date` ASC
           ';

 
         
           $stmt = $this->getDoctrine()->getManager()->getConnection()->prepare($sql);
           $stmt->execute();

           return $this->json( $stmt->fetchAll() );
   
    }


    


    /**
     * @Route("/send-msg", name="send_msg_route", methods={"POST"})
     */
    public function sendMSG(Request $request, UserRepository $userRepository): JsonResponse
    {
      $params = $request->request;
      $userID = $params->get("user");
        if ($userID != null) {
          $params = $request->request;
          $userID = $params->get("user");
          $content = $params->get("content");

          $receiver = $userRepository->findOneBy(['id'=>$userID]);

          $user = $this->getUser();

          $msg = new ChatMessages();
          $msg->setSender($this->getUser());
          $msg->setReceiver($receiver);
          $msg->setDate(new DateTime());
          $msg->setContent($content);

          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($msg);
          $entityManager->flush();


                      
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
          "to" : "'.$receiver->getFcm().'",
          "collapse_key" : "type_a",
          "data" : {
              "body" : "'.$content.'"
              "title": "AFRK50 New message from '.$user->getFirstName().'",
              "sender" : "'.$user->getId().'"
          }
          }',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json',
              'Authorization: key=AAAAsD_QY70:APA91bHe6SptfvvXkLQYpcHoih_BkiV22FVzmIxVlzJB3CYm7YXY3XIJnrw_KsZAhT-YJMrvbgltMvMGykinz0q-NTWSnxoTMTGbCqYBbZQD0Oi6f4_Hoj4aVTVu70YCJitaPCLA717U'
            ),
          ));

          $response = curl_exec($curl);

          curl_close($curl);


          return $this->json(array("message"=>"message sent","success"=>true));
        }

       
           
    }



    /**
     * @Route("/fcm/chat/update-my-token", name="update_user_fcm", methods={"POST"})
     */
    public function updateFCM(Request $request): JsonResponse
    {
       
        
            $params = $request->request;
            $fcm = $params->get("fcm");

            $user = $this->getUser();
            $user->setFCM($fcm);
            $this->getDoctrine()->getManager()->flush();

            return $this->json(array("message"=>"fcm saved","success"=>true));

       
           
    }
    
}
