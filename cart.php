<?php
ob_start();
session_start();
include 'init.php'; 

$do =isset($_GET['do'])? $_GET['do']: 'manage';
if(isset($_SESSION['user'])){ 
if($do=='manage'){
    $subtotal='0';
?>

<div class="container ">
    <div class="table-responsive">
        <table class=" main-table table ">
            <tr>
            <th>PRODUCT</th><th>NAME</th><th>UNIT PRICE</th><th>QUANTITY</th><th>TOTAL</th><th>DELETE</th>
            </tr>
<?php         

                $stmt=$con->prepare("SELECT 
                carts.*,products.*
                from  
                        carts
                    inner join
                    products
                on
                products.Proid=carts.pro_id
                WHERE user_id={$_SESSION['uid']} and status=0");
                    $stmt->execute();
                    $carts=$stmt->fetchAll();
                if(!empty($carts)){
                    foreach($carts as $cart){

?>
            <tr>
                <td>
                    <a href="products.php?itemid=<?php echo $cart['pro_id'] ?>">
                        <img class="img-responsive" src="admin/upload/img/<?php echo $cart['Proimg1'] ?>" alt="">
                    </a>

                </td>
                <td>
                    <h3><?php echo $cart['Proname'] ?></h3>
                    <br><br>
                    <small></small>

                </td>
                <td class="padd">
                    <span  class="price">
                    $<?php echo $cart['Price'] ?>
                    </span>

                </td>
                <td class="padd">
                    <div>
                    <form style="display:flex" action="?do=update" method="post">
                        <input  class="form-control" name="qnt" type="number" min="1" max="<?php echo $cart['Qnty'] ?>" value="<?php echo $cart['qnty'] ?>" class="counter-btn">
                        <input id="cartidhiden" type="hidden" name="cartid" value="<?php echo $cart['Cartid'] ?>">
                        <button name="save" type="submit">save</button>
                        </form>
                    </div>

                </td>
                <td class="padd">
                    <span  class="price">
                       $<?php 
                       echo $totla=$cart['Price']*$cart['qnty'] ;
                      $subtotal=$subtotal+$totla;
                      
                       ?>
                    </span>

                </td>
                <td  class="padd">
                    <span>
                        <a href="?do=delete&cartid=<?php echo $cart['Cartid'] ?>"><i class="fa fa-times"></i></a>
                    </span>
                </td>
            </tr>
                    <?php }
                  
                    }else{
                        echo "<th><div class=' alert alert-info text-center'> You Dont Have Any Product In Your Cart</div></th>";
                    }                   
                    ?>
        </table>

    </div>
    <!-- fin table -->
    <div class="cart-btns">
        <div class="continue-shopping">
            <a href="index.php">CONTINUE SHOPPING</a>
        </div>
        <div class="check-box">
            <input type="checkbox" name="" id="">
            <span>Shipping (+7%)</span>

        </div>

    </div>
   <?php  if(!empty($carts)){ ?>
    <div class="cart-total">
        <h3 class="text-center">Cart Total</h3>
        <ul>
            <li>
                Subtotl <span  class="price">$<?php  echo $subtotal;
              
                ?></span>
               
            </li>
            <li>
                Shipping <span>$<?php echo $ship= (7*$subtotal)/100; ?></span>
            </li>
            <li>
                Total <span class="price">$<?php echo $subtotal+$ship; ?></span>
            </li>
        </ul>
        <a  href="confirm_cart.php"> CONFIRME</a>

    </div>
<?php }
?>
</div>

<?php
}elseif($do=='delete'){
  $cartid=isset($_GET['cartid']) && is_numeric($_GET['cartid']) ? intval($_GET['cartid']) : 0;
  $check= checkitem("Cartid","carts",$cartid);
    
  if($check > 0){
      $stmt=$con->prepare('DELETE FROM carts WHERE Cartid=:zid ' );
      $stmt->bindParam(':zid',$cartid );
      $stmt->execute();
      $stmt->rowCount();
     header('location:cart.php');
   }else{
       $theMsg ='<div class="alert alert-danger">this id not existe</div>';
      // redirectHome($theMsg);
   } 
}elseif($do=='update'){

    $qnt=isset($_POST['qnt']) && is_numeric($_POST['qnt']) ? intval($_POST['qnt']) : 0;
    $cartid=isset($_POST['cartid']) && is_numeric($_POST['cartid']) ? intval($_POST['cartid']) : 0;
        $stmt=$con->prepare("UPDATE carts SET qnty={$qnt} WHERE Cartid={$cartid}");
        $stmt->execute();
        header('location:cart.php');
}
}else{
    echo "<div class='alert alert-info text-center'>Plz You Must <a href='login.php'><strong>Login</strong></a>, Whene You Can Add Your Products In Your Cart Page . </div>";
}
include 'inc/tamplate/footer.php';
ob_end_flush();
?>
