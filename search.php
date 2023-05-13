<?php 
ob_start();
session_start();
include 'init.php'; ?>
<div class="container">
<div class="row" style="background:white">
<?php

if(isset($_GET['search'])){
$search=$_GET['search'];
?>

<?php
$stmt=$con->prepare("SELECT * FROM products WHERE Approve=1 AND Proname LIKE '%$search%' OR Brand LIKE '%$search%' OR Tags LIKE '%$search%' ");
$stmt->execute();
$rows=$stmt->fetchAll();
$num=$stmt->rowCount();
if($num>0){
foreach($rows as $item){ 
 $stmmmt=$con->prepare( " SELECT round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$item['Proid']} ");
            $stmmmt->execute();
            $getrat=$stmmmt->fetch();
            ?>
<div class=" col-sm-6 col-md-3  text-center margintop_pro" >
  <a href="products.php?itemid=<?php echo $item['Proid'] ?>">
              <div><img class="img-responsive" src="admin/upload/img/<?php echo $item['Proimg1']; ?>" alt=""></div>
              <div class="titel_pro"><h2><?php echo $item['Proname']; ?></h2></div>
              <div><span class="price_sup">$<?php echo $item['Price']; ?></span></div>
              <div  id="stars"><span><i class="glyphicon glyphicon-star"></i> <strong><?php if(!empty( $getrat['rating'])){ echo $getrat['rating'];}else{echo 'non' ;} ?></strong> </span><span class="date_pro">in Stock(<?php  echo $item['Qnty']  ?>)</span></div>
              </a>
              <div id="product_btns" ><a> <button class="product__btn">Buy</button></a>
                  <a onclick="addtocart(<?php echo $item['Proid'];  ?>)"> <button class="product__btn"> Add To cart</button></a></div>
            </div>
        <?php } 

}else{
    echo "<span class='text-center'> There are no results Matching your search! </span>";
}
}elseif(isset($_GET['tags'])){
  $tags=$_GET['tags'];
  
$stmt=$con->prepare("SELECT * FROM products WHERE Approve=1 AND Tags LIKE '%$tags%' ");
$stmt->execute();
$rows=$stmt->fetchAll();
$num=$stmt->rowCount();
if($num>0){
foreach($rows as $item){
  $stmmmt=$con->prepare( " SELECT round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$item['Proid']} ");
  $stmmmt->execute();
  $getrat=$stmmmt->fetch();
  ?>

<div class=" col-sm-6 col-md-3  text-center margintop_pro" >
  <a href="products.php?itemid=<?php echo $item['Proid'] ?>">
              <div><img class="img-responsive" src="admin/upload/img/<?php echo $item['Proimg1']; ?>" alt=""></div>
              <div class="titel_pro"><h2><?php echo $item['Proname']; ?></h2></div>
              <div><span  class="price_sup">$<?php echo $item['Price']; ?></span></div>
              <div  id="stars"><span><i class="glyphicon glyphicon-star"></i> <strong><?php if(!empty( $getrat['rating'])){ echo $getrat['rating'];}else{echo 'non' ;} ?></strong> </span><span class="date_pro">in Stock(<?php  echo $item['Qnty']  ?>)</span></div>
              </a>
              <div id="product_btns" ><a  onclick="buy(<?php echo $item['Proid'];  ?>)"> <button class="product__btn">Buy</button></a>
                  <a onclick="addtocart(<?php echo $item['Proid'];  ?>)"> <button class="product__btn"> Add To cart</button></a></div>
            </div>
        <?php } 

}else{
    echo "<span class='text-center'> There are no results Matching your search! </span>";
}
} ?>
</div>
</div>
<?php
include 'inc/tamplate/footer.php'; 
ob_end_flush();
?>