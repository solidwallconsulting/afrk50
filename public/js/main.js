$(document).ready(function(){

    var today = new Date();

    $("#year").html(today.getFullYear());

    try {
        AOS.init();

    $('.select2').select2();
    } catch (error) {
        
    }
  

    // main search engine
    $(".main-link").click(function(e){
        e.preventDefault();
        const target = $(this).attr("tab-target");
        $(".main-link").removeClass("active")
        $(this).addClass("active")

        //tab-content tab-content-3
        $(".tab-content").removeClass('show');
        $(".tab-content-"+target).addClass('show')
    })


    $('.owl-carousel-start').owlCarousel({
        loop:true,
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,

        margin:10,
        nav:true, 
        navText:['<div class="btn slider-left-btn"><i class="fas fa-chevron-left"></i></div>','<div   class="btn slider-left-btn"><i class="fas fa-chevron-right"></i></div>'],
         
        
        responsive:{
            0:{
                items:1
            },
            800:{
                items:3
            },
            1000:{
                items:3
            }
        }
    })




    $('.owl-carousel-partners').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        dots:true,
        autoplay:true,
        autoplayTimeout:4000,
        autoplayHoverPause:true,
        navText:['<div   class="btn slider-left-btn"><i class="fas fa-chevron-left"></i></div>','<div   class="btn slider-left-btn"><i class="fas fa-chevron-right"></i></div>'],
        dots:true,
        
        responsive:{
            0:{
                items:1
            },
            800:{
                items:4
            },
            1000:{
                items:4
            }
        }
    }) 







    $(".loader-screen").fadeOut();



    
    let nbrSteps = Number($(".contract-progress").attr("steps"));
    /**** progress **** */
    // init progress %
    let progress = (100 / nbrSteps).toFixed();

    $(".contract-progress").css({width:progress+'%'});
    $(".contract-progress").html(progress+'%');



    $(".update-profile-photo").click(function(){
        $("#photo").click();

    });

    $("#photo").change(function(){
        $("#update-photo-form").submit();
        
    });



    $(".print-doc-from-profile").click(function(){
        let data = $(this).attr('data-to-print');
        let w=window.open();
        w.document.write(data);
        w.print();
        w.close();
    })



    $(".profile-side-menu").click(function(e){
        e.preventDefault();
        $(".profile-side-menu").removeClass("active-item");
        $(this).addClass("active-item");
        
        let targetID = $(this).attr('data-target');

        $(".account-target").hide();
        $(".bloc-"+targetID+"").fadeIn();
         
         
    })


    $(".new-social-media").click(function(){
        let BlocToAdd =`
        <div class="row">
            <div class="col-sm-1 delete-line"><i class="fas fa-trash text-danger"></i></div>
            <div class="col-sm-5"> 
            <select name="social[]"  class="form-control select2"  >
                <option value=""  >Select Network</option>
                <option value="Facebook"  >Facebook</option>
                <option value="Twitter"  >Twitter</option>
                <option value="Instagram"  >Instagram</option>
                <option value="YouTube" >YouTube</option>
                <option value="Snapchat"  >Snapchat</option>
                <option value="Tumblr"  >Tumblr</option>
                <option value="Reddit"  >Reddit</option>
                <option value="LinkedIn"  >LinkedIn</option>
                <option value="Pinterest"  >Pinterest</option>
                <option value="DeviantArt" >DeviantArt</option>
                <option value="VKontakte"  >VKontakte</option>
                <option value="SoundCloud"  >SoundCloud</option>
                <option value="Website"  >Website</option>
                <option value="Other"  >Other</option>
            </select>
            </div>
            <div class="col-sm-6"> 
                <input type="text" name="url[]" class="form-control-afrk social-media-value" placeholder="Enter URL" />  
            </div>
        </div>

        `;

        $(".socials-lines").append(BlocToAdd);

        $(".delete-line").click(function(){
            $(this).parent().remove();
        })

        $(".select2").select2();



    })



    $(".delete-line").click(function(){
        $(this).parent().remove();
    })



    $(".tab-switch-day").click(function(e){
        e.preventDefault();

        let target = $(this).attr('href');

        $(".selecting-day").hide();
        $(target).fadeIn();
    })
    
    $(".input-zone").click(function(e){ 
        let source = $(this);
        let target = $(this).attr('target'); 
        $("#"+target+"").click();

        $("#"+target+"").on('change',function(event){
            var reader = new FileReader();
            reader.onload = function(){
               
              source.css({'background-image':'url('+reader.result+')'});
            };
            reader.readAsDataURL(event.target.files[0]);
        })
         

    })
    

    $(".info-bloc").click(function(){
        let id = $(this).attr('company'); 
        window.location="/company/"+id;
         
        
    })




    /*$(window).scroll(function() {
        if ($(this).scrollTop() > 400) { 
            $('#top-nav-bar').css({'position':'fixed'});
          
        } else { 
            $('#top-nav-bar').css({'position':'relative'});
          
        }
      });*/


    $(".company-nav-id").click(function(e){
        e.preventDefault();

        const target = $(this).attr('href');
        $(".company-section-tab").hide();

        
        $(".company-nav-id").removeClass('active');
        $(this).addClass('active');

        $(target).fadeIn();

    })


    $(".my-rating").starRating({
        initialRating: 0, 
        strokeWidth: 10,
        starSize: 25,
        emptyColor: 'lightgray',
        hoverColor: '#68a0b1',
        activeColor: '#68a0b1',
        strokeColor: '#68a0b1',
        disableAfterRate: false,

        callback: function(currentRating, $el){
            console.log('rated ' + currentRating);
            console.log('DOM element ', $el);

            $el.attr('value',currentRating);
            $el.parent().children(".value").val(currentRating);
            
          }


      });

 
      
    $(".solid-rating").each(function(){
        const rating = $(this).attr('rating');

        $(this).starRating({
            initialRating: rating, 
            strokeWidth: 10,
            starSize: 25,
            emptyColor: 'lightgray',
            hoverColor: '#68a0b1',
            activeColor: '#68a0b1',
            strokeColor: '#68a0b1', 
            readOnly: true
          });
    })


  


    $(".tab-item-user-toolbar").click(function(e){
        e.preventDefault();

        const target = $(this).attr('target');
        $(".user-section-tab").hide();

        
        $(".tab-item-user-toolbar").removeClass('active');
        $(this).addClass('active');

        $(target).fadeIn();

    })


    $("#update-cover-btn").click(function(){
        $("#cover-photo-input").click();

        $("#cover-photo-input").on('change',function(){
            $("#cover-form").submit();
        })
        
    })



    $(".business-modal-zoom").on('shown.bs.modal',function(){
        console.log("opned");

        mapboxgl.accessToken = 'pk.eyJ1IjoiYWZyazUwYWRtaW4iLCJhIjoiY2t2d2F2ZXJuYzRkYTMwczdoZTh5N3BzZiJ9.ev6y63e37s0_YkF-54EZgg';
         
            
            var map = new mapboxgl.Map({
            container: $(this).attr('target-id'),
            style: 'mapbox://styles/afrk50admin/ckxerlgpz2lsk15ph7vpg5zku',
            zoom:12
            
        });

        const marker = new mapboxgl.Marker({
        draggable: true
        })
        .setLngLat([$(this).attr('lng'), $(this).attr('lat')])
        .addTo(map);

        map.flyTo({
        center: [$(this).attr('lng'), $(this).attr('lat')]
        });
     

    })


    $(".book-mark-add").click(function(){
        const id = $(this).attr('target');
        window.location = "/account/add-book-mark/"+id;
        
    })


    $(".leave-a-review-button").click(function(e){
        e.preventDefault();
        $("#reviews-tab").click();
    })



     


    $(".listing-side-nav").click(function(e){
        //e.preventDefault();
        $(".listing-side-nav").removeClass("active");
        $(this).addClass("active");


        
    })



    $(".back-btn").click(function(){
        window.history.back();
    })



    $(".switch-btn").click(function(){
        $(this).toggleClass("active");

        $(".pack-row").toggleClass("d-none");
    })



    $("#change-filter").on('change',function(){
        $("#filter-form").submit();
    })

 

    document.addEventListener('scroll', function(e) {
        var lastKnownScrollPosition = window.scrollY;
      
        

        $(".listing-side-nav").removeClass("active");

        if (lastKnownScrollPosition < 700) {
            $(".to-general").addClass("active");
        }

        if (lastKnownScrollPosition >= 700 && lastKnownScrollPosition < 1200) {
            $(".to-images").addClass("active");
        }
         
        if (lastKnownScrollPosition >= 1200 && lastKnownScrollPosition < 1500) {
            $(".to-contact").addClass("active");
        }

        if (lastKnownScrollPosition >= 1500 && lastKnownScrollPosition < 1700) {
            $(".to-socials").addClass("active");
        }

        if (lastKnownScrollPosition >= 1700 && lastKnownScrollPosition < 2000) {
            $(".to-working-hours").addClass("active");
        }

        if (lastKnownScrollPosition >= 2000 && lastKnownScrollPosition < 2800) {
            $(".to-locations").addClass("active");
        }


        
        if (lastKnownScrollPosition >= 2800  ) {
            $(".to-listing-details").addClass("active");
        }



        
        if (lastKnownScrollPosition >= 2900  ) {
            $(".add-listing-nav").fadeOut();
        }else{
            $(".add-listing-nav").fadeIn();
        }

        

         
      });


      setTimeout(() => {
          $(".missing-info-toast").addClass('show');
      }, 4000);

    
})




