
<?php
ob_start();
session_start();

include 'connect.php';
$do=isset($_GET['do'])? $_GET['do']:'manage';
if($do=='manage'){
                          
        if($_SERVER["REQUEST_METHOD"]=='POST'){
            $comment=filter_var( $_POST['comment'],FILTER_SANITIZE_STRING);
            $userid=$_SESSION['uid'];
            $itemid=(int)$_POST['proid'];

            if(!empty($comment)){
                $stmt=$con->prepare("INSERT INTO comments(Comment,Statuss,Date,proid,userid) VALUE(:zcomment,0,now(),:zitemid,:zuserid)");
              $stmt->execute(array(
                  'zcomment'=>$comment,
                  'zitemid'=>$itemid,
                  'zuserid'=>$userid,
                  
              ));
              if($stmt){
                  echo '<div class="alert alert-success">Comment Add waiting admin to  approved</div>';
              }
            }else{ echo ' you dont write your comment';}
        }
}elseif($do=='cart'){
    if($_SERVER["REQUEST_METHOD"]=='POST'){
       
        $userid=$_SESSION['uid'];
        $itemid=(int)$_POST['proid'];

        $statement= $con->prepare("SELECT Cartid FROM carts WHERE pro_id= ? and user_id=? and status = 0");
    $statement->execute(array($itemid,$userid));
    $count = $statement->rowCount();
        if($count<1){
            $stmt=$con->prepare("INSERT INTO carts(pro_id,Date,user_id) VALUE(:zitemid,now(),:zuserid)");
          $stmt->execute(array(
              
              'zitemid'=>$itemid,
              'zuserid'=>$userid,
              
          ));
          echo "<div  class= 'alert alert-info'>These Product Is Add To Your Cart.</div>";
        }else{ echo  "<div class= 'alert alert-info'> These Product Is Alerdy In Your Cart </div>";}
}
}
   ob_end_flush();  
        ?>