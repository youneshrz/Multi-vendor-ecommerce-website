<?php
ob_start();//output buffering start
$title='home';
session_start();
 include 'init.php'; ?>
<!-- Swiper -->
<div class="container-fluid" >
    <div class="swiper-container">
        <div class="swiper-wrapper">
        
          <div class="swiper-slide  "  >
              <div class="hero__center ">
              
                    <div class="hero__left text-left ">
                      <span class="">New Inspiration 2020</span>
                      <h1 class="">PHONES MADE FOR YOU!</h1>
                      <p>Trending from mobile and headphone style collection</p>
                      <a href="products.php?itemid=2"><button class="hero__btn ">SHOP NOW</button></a>
                    </div>
                    <div class="hero__right">
                      <div class="hero__img-container">
                        <img class="banner_01 " src="images/banner_01.png" alt="banner2" />
                      </div>
                    </div>
                  </div>
                </div>
          <div class="swiper-slide"> 
            <div class="hero__center ">
              
              <div class="hero__left  text-left">
                <span class="">New Inspiration 2020</span>
                <h1 class="">PHONES MADE FOR YOU!</h1>
                <p>Trending from mobile and headphone style collection</p>
                <a href="products.php?itemid=12"><button class="hero__btn">SHOP NOW</button></a>
              </div>
              <div class="hero__right">
                <div class="hero__img-container">
                  <img class="banner_01 " src="images/banner_02.png" alt="banner2" />
                </div>
              </div>
            </div>
          </div>
        
        
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
  </div>
  <br>
<!-- fin swiper -->

<div class="container">
  <!-- collection-->
   <div class="row">
       <div class="  col-md-6 ">
          <div class="row cols">
          <div class="col-md-6 ">
              <img  class="img-responsive"  src="images/collection_01.png" alt="">
          </div>
          <div class="col col-md-6  text-center">
                  <div class="collection1  text-center">
                    <span>Phone Device Presets</span>
                    <h1 >SMARTPHONES</h1>
                    <a href="categories.php?sub_cat_id=57&childname=mobiles&sub_pageid=53">SHOP NOW</a>
                  </div>
           </div>
          </div>
       </div>
    
    
       <div class="  col-md-6 ">
       <div class="row cols ">
          <div class="  col-md-6 ">
              <img class="img-responsive"  src="images/collection_02.png" alt="">
          </div>
          <div class=" col col-md-6  text-center ">
              <div class="collection1  text-center">
                  <span>New Colors Introduced</span>
                  <h1>HEADPHONES</h1>
                  <a href="categories.php?sub_cat_id=56&childname=headphones&sub_pageid=53">SHOP NOW</a>
            </div>
          </div>
         </div>
        </div>
  </div>
</div>
   <!--fin collection-->
 <!-- start swiper special products-->
 <div class="container">
 <div class=" latest-pro  ">
   
    <span class="dot"></span> <h1>Special Products</h1>
 </div>
    
</div>
 
 <br>
    <!-- Swiper -->
    <div class="container-fluid">
      <div class="swiper-container1">
        <div class="swiper-wrapper">

           <div class="swiper-slide">
            <div class=" text-center" >
              <div><a href="products.php?itemid=13"><img class="img-responsive" src="admin/upload/img/9510554438_images (14).jpg" alt=""></a></div>
            </div>
          </div>


          <div class="swiper-slide">
            <div class=" text-center" >
              <div><a href="products.php?itemid=2"><img class="img-responsive" src="admin/upload/img/909611294_iphone1.jpeg" alt=""></a></div>
            </div>
          </div>

          <div class="swiper-slide">
            <div class=" text-center" >
              <div><a href="products.php?itemid=23"><img class="img-responsive" src="admin/upload/img/936522103_images (42).jpg" alt=""></a></div>
            </div>
          </div>

          <div class="swiper-slide">
            <div class=" text-center" >
              <div><a href="products.php?itemid=15"><img class="img-responsive" src="admin/upload/img/764162188_download (2).jpg" alt=""></a></div>
            </div>
          </div>

          <div class="swiper-slide">
            <div class=" text-center" >
              <div><a href="products.php?itemid=25"><img class="img-responsive" src="admin/upload/img/4115444204_images (55).jpg" alt=""></a></div>
            </div>
          </div>
         
         
        </div>
        <div class="swiper-button-next pag_next"></div>
        <div class="swiper-button-prev pag_prev"></div>
      </div>
      </div>
      <!-- fin swiper special products-->
 <hr>
 <!-- start all products-->
 <div class="container">
     

      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title text-center"> LATEST PRODUCTS</h3>
        </div>
        <div class="panel-body">
          <div class="row">
           <?php 
           $alls=getallfrom("*","products","where Approve=1","","Proid","Desc");
            foreach($alls as $all){
              $stmmmt=$con->prepare( " SELECT round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$all['Proid']} ");
              $stmmmt->execute();
              $getrat=$stmmmt->fetch();
              ?>
                  <div class="col-sm-6 col-md-3  text-center margintop_pro"  data-aos="fade-up" data-aos-duration="1200" >
                    <a href="products.php?itemid=<?php echo $all['Proid'] ?>">
                    <div><img class="img-responsive" src="admin/upload/img/<?php echo $all['Proimg1']; ?>" alt=""></div>
                    <div class="titel_pro"><h2><?php echo $all['Proname']; ?></h2></div>
                    <div><span class="price_sup">$<?php echo $all['Price']; ?></span></div>
                    <div></div>
              <div  id="stars"><span><i class="glyphicon glyphicon-star"></i> <strong><?php  if(!empty( $getrat['rating'])){ echo $getrat['rating'];}else{echo 'non' ;} ?></strong> </span><span class="date_pro">in Stock(<?php  echo $all['Qnty']  ?>)</span></div>
              </a> 
                    <div id="product_btns" ><a  onclick="buy(<?php echo $all['Proid'];  ?>)"> <button class="product__btn">Buy</button></a>
                  <a onclick="addtocart(<?php echo $all['Proid'];  ?>)"> <button class="product__btn"> Add To cart</button></a></div>
                  </div>
              <?php  } ?>

          </div>
      </div>
 </div>
 </div>
 <!-- fin all products-->

<?php include 'inc/tamplate/footer.php';
ob_end_flush();
?>