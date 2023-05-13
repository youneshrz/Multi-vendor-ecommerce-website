<?php
session_start();
include_once 'connect.php';

if(isset($_GET['pageid'])){
    $catid=isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
    $getall=$con->prepare("SELECT * FROM categories where Catid=$catid  ");
    $getall->execute();
    $catss=$getall->fetch(); 
    $title= 'category - '.$catss['Catname'] ;
}
if(isset($_GET['sub_cat_id']) && isset($_GET['sub_pageid'] )){
    $sub_cat_id=isset($_GET['sub_cat_id']) && is_numeric($_GET['sub_cat_id']) ? intval($_GET['sub_cat_id']) : 0;
    $sub_pageid=isset($_GET['sub_pageid']) && is_numeric($_GET['sub_pageid']) ? intval($_GET['sub_pageid']) : 0;
    $getall=$con->prepare("SELECT * FROM categories where Catid=$sub_pageid ");
    $getall->execute();
    $catss=$getall->fetch(); 
    $title='category - '.$catss['Catname'] ;
}
include_once 'inc/function/function.php';
include 'inc/tamplate/header.php';
?>

<div class="container">
    <div class="row" style="min-height:480px">
    <div class=" col-md-3 sub-category">
            <h3  class="sub-category-name">Sub catrgories</h3>
            <ul>
                <?php 
              if(isset($_GET['sub_pageid'] )){
                $childs=getallfrom('*','categories',"where Parent={$sub_pageid}",'','Catid','');
               }else{
               $childs=getallfrom('*','categories',"where Parent={$catid}",'','Catid','');}
                     foreach($childs as $child){
                ?>
                <li id="li-linck"><a href="?sub_cat_id=<?php echo $child['Catid']; ?><?php if(isset($_GET['sub_pageid'])){ print('&childname='.$child['Catname'].''); } ?>&sub_pageid=<?php isset($_GET['sub_pageid']) ?print( $sub_pageid) : print( $catid); ?>" ><?php echo $child['Catname'] ?></a></li>
               
                     <?php } ?>
            </ul>

        </div>
        <div class=" col-sm-12 col-md-9 category ">
            <h2 class="category-name"><?php echo $catss['Catname']  ;if(isset($_GET['childname'])){ echo '<span> > '.$_GET['childname'].'</span> '; } ?></h2>
            <?php 
            if(isset($_GET['pageid'])){
               $desplaycats=getallfrom('*','products',"where category={$catid}",'AND Approve=1','Proid','asc');
            }elseif(isset($_GET['sub_cat_id'])){
               $desplaycats=getallfrom('*','products',"where Child={$sub_cat_id}",'AND Approve=1','Proid','asc');

            }
            if(empty($desplaycats)){ echo '<div class=" alert alert-info text-center">There Is No Item In This Categorie</div>';}else{
        foreach($desplaycats as $item){
            $stmmmt=$con->prepare( " SELECT round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$item['Proid']} ");
            $stmmmt->execute();
            $getrat=$stmmmt->fetch();
        ?>
            <div class=" col-sm-4 col-md-3  text-center margintop_pro"  data-aos="fade-up" data-aos-duration="1200">
            <a  href="products.php?itemid=<?php echo $item['Proid'] ?>">
              <div><img class="img-responsive" src="admin/upload/img/<?php echo $item['Proimg1']; ?>" alt=""></div>
              <div class="titel_pro"><h2><?php echo $item['Proname']; ?></h2></div>
              <div><span class="price_sup">$<?php echo $item['Price']; ?></span></div>
              
              <div  id="stars"><span><i class="glyphicon glyphicon-star"></i> <strong><?php if(!empty( $getrat['rating'])){ echo $getrat['rating'];}else{echo 'non' ;} ?></strong> </span><span class="date_pro">in Stock(<?php  echo $item['Qnty']  ?>)</span></div>
              </a>
              <div id="product_btns" ><a  onclick="buy(<?php echo $item['Proid'];  ?>)"> <button class="product__btn_category">Buy</button></a>
                  <a onclick="addtocart(<?php echo $item['Proid'];  ?>)"> <button class="product__btn_category"> Add To cart</button></a>
                  </div>
                  
            </div>
        <?php } } ?>
                 

        </div>
        <!---- -->
      </div>

    

</div>

<?php include 'inc/tamplate/footer.php'; ?> 