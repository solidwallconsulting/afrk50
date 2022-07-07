$(document).ready(function(){

 




    function initCHAT(){

        const chattingWith = $("#target-uid").val();

        const url = '/account/init-chat/'+chattingWith;
    $.get(
      url
      
    ).done((data)=>{

        let blocChat = ''; 




      data.forEach(chat => {


          if (chattingWith == chat.sender_id ) {
             blocChat=blocChat+ `
             <div class="incoming_msg">
             <div class="incoming_msg_img"> <img src="${chat.photo_url}" alt="sunil"> </div>
             <div class="received_msg">
               <div class="received_withd_msg">
                 <p>${chat.content}</p>
                 <span class="time_date"> ${chat.date}</span></div>
             </div>
           </div>
             `;
          } else {
              
            blocChat=blocChat+ `
            <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>${chat.content}</p>
                    <span class="time_date">${chat.date}</span> </div>
                </div>
            `;
            
          }
      });


      $("#msg_history").html(blocChat);
      $("#msg_history").scrollTop($('#msg_history')[0].scrollHeight);
      setTimeout(() => {
        $("#msg_history").scrollTop($('#msg_history')[0].scrollHeight);
    }, 200);

    })


    }

    function sendMSG(){
        const val = $("#write_msg").val();
        $("#write_msg").val("");

        if(val !== ''){
            let old =  $("#msg_history").html();

        let tmp = `
                <div class="outgoing_msg">
                  <div class="sent_msg">
                    <p>${val}</p>
                    <span class="time_date">just now...</span> </div>
                </div>
                `; 
            old = old+tmp;
            $("#msg_history").html(old);

            $("#msg_history").scrollTop($('#msg_history')[0].scrollHeight);
            setTimeout(() => {
              $("#msg_history").scrollTop($('#msg_history')[0].scrollHeight);
          }, 200);



        const url = '/account/send-msg';
        const chattingWith = $("#target-uid").val();

        $.post(
          url,
          {user:chattingWith, content:val}
          
        ).done((data)=>{
    
            initCHAT();
            
        });
        }
    }



    $("#send_btn").click(function(){
        sendMSG();
    })



    $(".chat_list").click(function(){

      $(".chat_list").removeClass("active_chat");
      $(this).addClass("active_chat");
      
      const tmp = $(this).attr('contact-id');
      $("#target-uid").val(tmp);
      initCHAT();
    })



    messaging.onMessage((payload) => {
      const chattingWith = $("#target-uid").val();
        console.log('Message received. ', payload);



        // add a red dot on left chatting

        if ($(".contact-user-list-name-"+payload.data.sender+"") == null) {
          window.location.reload();
          
        }
        $(".contact-user-list-name-"+payload.data.sender+"").addClass("new-message");


        setTimeout(()=>{
          $(".contact-user-list-name-"+payload.data.sender+"").removeClass("new-message");
        },5000)


         
        if (payload.data.sender == chattingWith) {
            initCHAT();

            
              
            
 
        }
        
      });



      initCHAT();

})