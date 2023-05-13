<?php
session_start();
$pageTitle="carts";
if(isset($_SESSION['admin'])){
    
    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 
    include "init.php";
    /*$numpag= countItems('Cartid','carts');
    $number=ceil($numpag/1);*/
    if($do=='manage'){
        $carts=getallfrom('*','users',"",'','Userid','asc' );
if(!empty($carts)){
    ?>
           <h1 class="text-center">Manage carts</h1>
        <div class="container">
            <div class='table-responsive pagination text-center'style="display: block;" id="response">
            <table class='main-table text-center table table-bordered'>
                        <tr>
                            <td>#ID</td>
                            <td>Product</td>
                            <td> Name</td>
                            
                            <td>Quantity</td>
                            <td>Price Total</td>
                            <td>Username</td>
                            <td> DATE</td>
                            <td>CONTROLE</td>
                            
                        </tr>
                        <?php
                        foreach($carts as $cart){
                            $parentid=$cart['Userid'];
                            $stmt=$con->prepare("SELECT 
                            carts.*,users.Username as member ,users.Userid,products.*
                                from  
                                        carts
                                inner join
                                    users
                                on
                                    users.Userid=carts.user_id
                                inner join
                                    products
                                on
                                products.Proid=carts.pro_id
                                where carts.Approve !=1
                                and carts.user_id={$parentid}
                                ");
                                $stmt->execute();
                                $childs=$stmt->fetchAll();  
                                foreach($childs as $child){                         
                            echo "<tr  class='bg-primary'  id='delete".$child['Cartid']."'>";                           
                            echo "<td>" . $child['Cartid'] . "</td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/".$child['Proimg1']."'> </td>";
                            echo "<td>" . $child['Proname'] . "</td>";                           
                            echo "<td>" . $child['qnty'] . "</td>";
                            echo "<td>" . $child['Price'] . "</td>";
                            echo "<td>" . $child['member'] . "</td>";
                            echo "<td>"  . $child['Date'] . "</td>";
                            echo "<td>                                   
                                    <a  onclick='confirmbyajax(". $child['Cartid'].")' class='btn btn-success confirm'><i class='fa fa-close'></i>CONFIRM</a>";                                   
                            echo  "</td>";
                            
                            echo "</tr>";
                        }
                    
                    }
                        ?>                  
                </table>
                </div>
               </div>
<!--
               <input type="hidden"  class="pageno" value="1">
                <span id="prev">prev</span>
                <?php 
               /* for ($i=1; $i <= $number ; $i++) { 
                     echo " <button value='".$i."'>$i</button>";
                }*/
                ?>
               <input type="hidden"  class="pageno_44" value="2">
                <span id="next">next</span>
            -->
             <?php   }else{
                 echo 'no recored to show';
             } ?>
                <script>
                     function confirmbyajax(id){
                          
        
                            $.ajax({
                                url:'carts.php?do=approve',
                                type: 'GET',
                                data:{cid:id},
                                success:function (data){
                               // $(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });}
                   

                    
                    </script>
 <?php }elseif($do=='approve'){
$Cid=isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
    
$check= checkitem("Cartid","carts",$Cid);


if($check > 0){
  $stmt=$con->prepare('UPDATE carts SET Approve=1 WHERE Cartid=:zid');
  $stmt->bindParam(':zid',$Cid);
  $stmt->execute();
}else{
   $theMsg ='<div class="alert alert-danger">this id not existe';
   redirectHome($theMsg);
   echo '</div>';
} 
    }

include 'inc/tamplate/footer.php';
}else{
    header('location:index.php');
}