<?php
ob_start();  
  session_start();
  if(isset($_SESSION['user'])){
    include 'init.php';
  $do=isset($_GET['do'])? $_GET['do'] : 'manage';
  if($do=='manage'){
   

  $getall=$con->prepare("SELECT * FROM users where Userid={$_SESSION['uid']}  ");
  $getall->execute();
  $profile=$getall->fetch();
 
  ?>

   <br>
   
   <br><br><br>

 <div class="modal-dailog modal-lg  center-block">
  <div class="modal-content">
  <div class="modal-header">
   <button class="close" type="button" data-dismiss="modal" aria-label="close">
    
   </button>
   <h4 class="modal-title text-center"> My profile </h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <div class="row">
          
      <div class="my-information">
      <form action="?do=update" method="post" enctype="multipart/form-data">
          <div class="img-profile">
           
              <?php if(empty($profile['Avatar'])){ ?>
                  <img class="img-responsive img-thumbnail img-circle center-block " src="images/png.png ">
             <?php }else{ ?>
                
               <img style="width:200px;height:209px;border-radius:19%" class="img-responsive img-thumbnail img-circle center-block " src="admin/upload/avatars/<?php echo $profile['Avatar'] ; ?>" alt=""> <?php } ?>
              
          </div>
                    <ul class="list-unstyled">
                    <input type="hidden" name="userid" value="<?php echo $profile['Userid'] ?>">
                    <li><i class="glyphicon glyphicon-file"></i><span>Image :</span><input class="form-control" type="file" name="avatar"> </li>
                     <li><i class="fa fa-unlock-alt fa-fw"></i><span>Username :</span><input class="form-control" type="text" name="name" value="<?php echo $profile['Username'] ?>"> </li>
                     <li><i class="fa fa-envelope-o fa-fw"></i><span>Email :</span> <input class="form-control" type="text" name="email" value="<?php echo $profile['Email'] ?>" > </li>
                     <li><i class="fa fa-user fa-fw"></i><span>Full Name :</span> <input class="form-control" type="text" name="fullname" value="<?php echo $profile['Fullname'] ?>"> </li>
                     <li><i class="fa fa-user fa-fw"></i><span> Address :</span> <input class="form-control" type="text" name="address" value="<?php echo $profile['Address'] ?>"> </li><br>

                     <li><i class="fa fa-calendar fa-fw"></i><span>Register Date : </span> <?php echo $profile['Date'] ?>  </li>                     
                     </ul>
                     <button class="btn btn-default" type="submit">Update Information </button>
                </div> 
                </form>
      </div>
    </div>
   </div>
  
   <div class="modal-footer"> 
     </div>
   </div>
 </div>

</div>

<!--- fin modal 1-->
<hr>
<div class="modal-dailog modal-lg  center-block">
  <div class="modal-content">
  <div class="modal-header">
   <button class="close" type="button" data-dismiss="modal" aria-label="close">
    
   </button>
   <h4 class="modal-title text-center"> My Advertismentes </h4>
  </div>
  <div class="modal-body">
    <div class="container-fluid">
      <div class="row">
          
      <div id="my-ads" class="my-ads">
         <?php         
        $ads=getallfrom("*","products","where Username={$_SESSION['uid']} ","","Proid","desc");
        foreach($ads as $ad){ ?>
       
          <div class="col-sm-4 text-center" id="delete<?php echo $ad['Proid'] ;?>">
          <div class="text-center"><img class="img-responsive" src="admin/upload/img/<?php echo $ad['Proimg1']; ?>" alt=""></div>
              <div><h2><?php echo $ad['Proname']; ?></h2></div>
              <?php if($ad['Approve']==0){ echo "<span class='approve'>Waiting Admin To Approve</span>"; }?>
              <a ><i class="fa fa-close close" onclick="deletebyajax(<?php echo $ad['Proid']; ?>)"></i></a>
              <a href="products.php?itemid=<?php echo $ad['Proid'] ?>"><button  class="product__btn"> More Detail</button></a>
          </div>
       <?php }

        ?>
                </div> 
                <script>
                     function deletebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'profile.php?do=delete',
                                type: 'POST',
                                data:{userid:id},
                                success:function (data){
                                //$(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>


      </div>
    </div>
   </div>
  
   <div class="modal-footer"> 
     </div>
   </div>
 </div>

</div>
 <!-- fin modal 2-->
 
<?php

  }elseif($do=='update'){
    if($_SERVER['REQUEST_METHOD']== 'POST'){
           
      $id    =$_POST['userid'];       
       $username=$_POST['name'];
       $fullname=$_POST['fullname'];
       $email=$_POST['email'];
       $address=$_POST['address'];

       $formErrors=array();
       if(!empty($_FILES['avatar']['tmp_name'])){ 
       $avatarname=$_FILES['avatar']['name'];
       $avatarsize=$_FILES['avatar']['size'];
       $avatartmp=$_FILES['avatar']['tmp_name'];
       $avatartype=$_FILES['avatar']['type'];       
               // list of allowed file typed upload
       $avatarallowextension = array("jpeg","jpg","png","gif");
       //get avatar
       $avatarextension =strtolower(end( explode('.',$avatarname)));
       if(! empty($avatarname) && ! in_array($avatarextension,$avatarallowextension)){
        $formErrors[]='this extension is not allowed';
        }
        if( $avatarsize >41940304){
                $formErrors[]='avatar  cant be larger than 4mb ';
        }
        if(empty($formErrors)){
          $avatar=rand(0,10000000000).'_'.$avatarname;
          move_uploaded_file($avatartmp,"admin/upload\avatars\\". $avatar);
          $stmt=$con->prepare("UPDATE users SET Avatar= ? WHERE Userid=? ");
          $stmt->execute(array($avatar,$id));
        }
      }

       if(isset($username)){
           $filteruser=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
           if(strlen($filteruser)< 5){
               
                   $formErrors[]='Username cant be less then 5 character';
           }
       }
       
     
        
     if(isset($email)){
         $filteremail=filter_var($email,FILTER_SANITIZE_STRING);
            if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
              $formErrors[]='this email is not valid ';
             
            }
     }
    
      
 
      //check if there is no error proceed the user add
      if(empty($formErrors)){
      
         //check if user exist in database
         $stmt2=$con->prepare("SELECT * from  users WHERE Username =? AND Userid !=?");
      $stmt2->execute(array($username,$id));
      $count=$stmt2->rowCount();

         if($count == 1){
             $formErrors[]= ' sorry this username is exist ';
             
         
            
         }else{
             //update the database with this info
    
$stmt=$con->prepare("UPDATE users SET Username =? ,Email=? ,Fullname=? ,Address=? WHERE Userid=? ");
$stmt->execute(array($username,$email,$fullname,$address,$id));
//echo succsess massage
   $theMsg= "<div class='alert alert-success'>Record Updated</div>";
   redirecthome($theMsg,'back','3');
   
  }

}
foreach($formErrors as $error){
  $theMsg='<div class="alert alert-danger text-center">' . $error .'</div>' ;
  redirecthome($theMsg,'back','5');

  }
}

  }elseif($do=='delete'){
    $userid=isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0;
    echo $userid;
    
    $check=checkItem('Proid','products',$userid);
  
if($check > 0){
    $stmt=$con->prepare('DELETE FROM products WHERE Proid=:zuser');
    $stmt->bindParam(':zuser',$userid);
    $stmt->execute();
    $stmt->rowCount();
   echo "<div class='alert alert-success'> Record Deleted</div>";
   
 }else{
    echo '<div class="alert alert-danger">this id not existe</div>';
 } 
  }

  include 'inc/tamplate/footer.php';
  }else{
    header('location:login.php');
  } 
  ob_end_flush();
?>
