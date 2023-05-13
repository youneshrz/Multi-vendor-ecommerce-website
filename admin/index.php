<?php 
session_start();
include '../connect.php';
if(isset($_SESSION['admin'])){
    header ('location:dashboard.php');
}?>
<link rel="stylesheet" href="inc/css/bootstrap.css"/>
<link rel="stylesheet" href="inc/css/backend.css"/>

  <?php  
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['login'])){
       $username=$_POST['user'];
       $password=$_POST['pass'];
        //check if user exist in database,
   $stmt=$con->prepare('SELECT Userid, Username , Password FROM users WHERE Username= ? AND Password= ? AND Status=1 LIMIT 1');
   $stmt->execute(array($username,$password));
   $row=$stmt->fetch();
   $count= $stmt->rowCount();
  
//if count >0 thiis mean the database contain record about this username
if($count>0){
    
    $_SESSION['admin']=$username; //register session name
    $_SESSION['id']=$row['Userid'];//register sission ID
    header('Location: dashboard.php');//redirect to dashborad page
    exit();
}


    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='POST' class="login center-block">
<h4 class='text-center'>Admin Login</h4>
<input class='form-control input-lg' type="text" name="user"  placeholder='Username' autocomplete='off'>
<br>
<input class='form-control input-lg' type="password" name="pass" placeholder='Password' autocomplete='new-password'>
<br>
<input class='btn btn-primary btn-block 'name='login' type="submit" value='login'>
</form>

<?php
//include "inc/tamplate/footer.php";
?>