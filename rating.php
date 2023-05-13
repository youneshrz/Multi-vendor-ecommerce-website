<?php
 ob_start();
 include 'connect.php';
 session_start();
 if ($_SERVER['REQUEST_METHOD']=='POST'){
  $rat=$_POST['rat'];
  $proid=$_POST['proid'];
  
  $userid=isset($_SESSION['user'])? $_SESSION['uid']:$_SERVER['REMOTE_ADDR']; 
 $stmt=$con->prepare(" SELECT Rating from rating where User_id={$userid} and  Pro_id={$proid} ");
 $stmt->execute();
 $count=$stmt->rowCount();
 if($count > 0){
    $stmt=$con->prepare(" UPDATE  rating set Rating={$rat} where User_id={$userid} and Pro_id={$proid} ");
    $stmt->execute();
 }else{
    $stmt=$con->prepare(" INSERT into rating  (Rating,Pro_id,User_id) values (:zrat,:zpro,:zuser)");
    $stmt->execute(array(
        'zrat'=> $rat,'zpro' => $proid,'zuser'=>$userid
    ));
 }
 $stmt=$con->prepare( " SELECT count(Rating) as 'number_rat',round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$proid} ");
 $stmt->execute();
 $getrats=$stmt->fetchAll();
 foreach($getrats as $g7){
   $number_user_rating=$g7['number_rat'] ;
   $moyenn_rating=$g7['rating'] ;
  
  
   }
$response=array(
   'number_user_rating'=> $number_user_rating ,
   'moyenn_rating'=> $moyenn_rating
);
 // Return response in JSON format ;
 echo json_encode($response); 
 /*foreach($getrats as $g7){
 echo "<span>".$g7['number_rat']." </span> <br>";
 echo "<span>".$g7['rating']." </span> ";


 }*/



















 }
ob_end_flush();
?>