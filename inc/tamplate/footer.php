<br>
<!-- Footer -->
<footer id="footer" class="section footer">
<div class="container-fluid">
      <div class="footer__top">
        <div class="footer-top__box">         
        </div>
        <div class="footer-top__box">
          <h3>© 2021 copyright best shopping</h3>
        </div>
        <div class="footer-top__box">        
        </div>
      </div>
    </div>
    
  </footer>
  <!-- End Footer -->








<script src="inc/js/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
    var swiper = new Swiper('.swiper-container1', {
      slidesPerView: 4,
      spaceBetween: 30,
      freeMode: true,
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>

  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>


<!-- Animate On Scroll -->

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init();
</script>
    <script src="inc/js/jquery-3.4.1.min.js"></script>
   
    <script src="inc/js/bootstrap.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script src="inc/js/front.js"></script>
   <script>
     function getchildoption(selected){
     if(typeof selected === 'undefined'){var selected='';}
            //var parentid=$(this).val();
           var parentid=$('select[name="parent"]').val();
           // console.log(parentid);
            $.ajax({
              url: 'admin/child.php',
              type: 'POST',
              data:{keyname:parentid,selected:selected },
              success:function(data){
          $('#child').html(data);
              },
              error:function(){alert("something went wrong with the child option");},
            });
          }
          $('select[name="parent"]').change(function(){getchildoption()});

         
          function addtocart( proid ){
                               
                                $.ajax({
                                url:'insert_comment.php?do=cart',
                                type:'post',
                                data:{proid:proid},
                                success:function (data){
                                    $("#error-mms").html(data);
                                },
                                
                                });
                            };   
              
                            function buy( proid ){                             
                               $.ajax({
                               url:'insert_comment.php?do=cart',
                               type:'post',
                               data:{proid:proid},
                               success:function (data){
                                  
                                   window.location.replace("cart.php");
                               },                              
                               });
                              
                           };   
   </script>
  
  
</body>
</html>