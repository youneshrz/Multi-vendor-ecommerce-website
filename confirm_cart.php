<?php

ob_start();
session_start();
?>
<link rel="stylesheet" href="inc/css/bootstrap.css"/>
<?php
include 'connect.php'; 
include 'inc/function/function.php';
$sessionuser='';
if(isset($_SESSION['user'])){
    $sessionuser =$_SESSION['user'];

$row=$con->prepare("SELECT pro_id FROM carts WHERE user_id={$_SESSION['uid'] } AND status='0' ");
$row->execute();
$row=$row->fetchAll();

$ro=$con->prepare("SELECT MAX(status) AS'status' FROM carts WHERE user_id={$_SESSION['uid'] }  ");
$ro->execute();
$ro=$ro->fetch();

$max=$ro['status'];
foreach($row as $rows){
    $stmt=$con->prepare(" UPDATE carts SET status={$max}+1   WHERE user_id={$_SESSION['uid'] } AND  status=0 ");
    $stmt->execute();
    }
}
$themsg="<div class='alert alert-success'>Thanck you sir,we will fulfill your order in the shortest time </div> ";
redirecthome($themsg,'index.php','5');
ob_end_flush();
?>