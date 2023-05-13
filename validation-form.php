<?php 
ob_start();
session_start();
include 'connect.php';
include 'inc/function/function.php';


if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(isset($_POST['submit'])){
        $username=$_POST['name'];
        $fullname=$_POST['fullname'];
        $email=$_POST['email'];
        $password1=$_POST['password1'];
        $password2=$_POST['password2']; 
        $address=$_POST['address']; 

        $formErrors=array();
        
   
   
      if(isset($username)){
          $filteruser=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
          if(strlen($filteruser)< 5){
                  $formErrors[]='Username cant be less then 5 character';
          }
      }
      if(isset($password1) && isset($password2)){
        if(empty($password1)){
            $formErrors[]='Sorry Passwored Cant Be Empty';
        }
        if($password1 !== $password2){

                $formErrors[]='Sorry password is not match';

        }
        
    }
    if(isset($email)){
        $filteremail=filter_var($email,FILTER_SANITIZE_STRING);
           if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
             $formErrors[]='this email is not valid ';
            
           }
    }
    if( empty($address)){
        $address=filter_var($address,FILTER_SANITIZE_STRING);
             $formErrors[]=' Address filed can not be empty';
    }

     //check if there is no error proceed the user add
     if(empty($formErrors)){
        //check if user exist in database
        $check=checkitem("Username","users",$username);
        if($check == 1){
            $formErrors[]= ' sorry this username is exist ';
           
        }else{
              //insert to database with this info
   $stmt=$con->prepare("INSERT INTO users ( Username,Fullname,Password,Email,Address,Status ,Date) VALUES(:zuser,:zfullname,:zpass,:zemail,:zaddress,0,now() )");
   $stmt->execute(array(
    'zuser' => $username,
    'zfullname' => $fullname,
    'zpass' =>($password1),
    'zemail' =>$email,
    'zaddress' =>$address
     ));
   //echo succsess massage
   echo "<span class='alert alert-success'>Congrats you are now register user</span> <br> <br>";
   
             }
            
         }
                   
    }
    
    else{
        if(isset($_POST['login'])){
            $user= $_POST['username'];
            $pass= $_POST['password'];
            
           //check if user exist in database,
           $stmt=$con->prepare('SELECT   Userid,Username , Password FROM users WHERE Username= ? AND Password= ? ');
           $stmt->execute(array($user,$pass));
           $get=$stmt->fetch();
           $count= $stmt->rowCount();
          
        //if count >0 this mean the database contain record about this username
        if($count>0){
            
            $_SESSION['user']=$get['Username']; //register session name
            $_SESSION["uid"]=$get['Userid'];//register id of user login
            header('Location:index.php');//redirect to dashborad page
            exit();
           }
           else{
              
               $themsg="<span class='alert alert-info'> This Username Does Not Exist</span> <br> <br>";
               redirecthome($themsg,'login.php','3');
              
           }
       }
    }

}

//print the errors

 if(!empty($formErrors)){
     foreach($formErrors as $error){
         echo "<span class='alert alert-danger'>".$error."</span>"."<br> <br> ";
     }
 }
 ob_end_flush();
?>
 