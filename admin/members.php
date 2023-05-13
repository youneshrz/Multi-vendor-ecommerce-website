<?php
ob_start();
session_start();
if(isset($_SESSION['admin'])){

    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 
    include "init.php";
    if ($do=='manage') {
        $users=getallfrom('*','users','','','Userid','asc' );

        ?>
        
        <h2 class="text-center">Table Members</h2>
        <hr>
        <div class="container">
            <div class="row">
            <div class='errr-msg'></div>
                <a class="btn btn-warning pull-right fa fa-plus" href="members.php?do=add">Add New Admin</a>
                <br><br><br>
                <table class="table table-resopnsive">
                    <tr>
                        <th>Userid</th> <th>Avatar</th> <th>Username</th> <th>Full Name</th> <th>Email</th> <th>Status</th> <th>Delet</th> <th>Edite</th>
                    </tr>
                    <?php foreach($users as $user){  ?>
                    <tr id="delete<?php echo $user['Userid'] ;?>">
                         <td><?php echo $user["Userid"] ?> </td>
                         <td><?php  if(empty($user['Avatar'])){
                                echo 'no image';
                            }else{
                              echo "<img class='img-responsive avatar' src='upload/avatars/" . $user['Avatar'] . "'/>";
                            } ?> </td>
                         <td><?php echo $user["Username"] ?> </td> 
                         <td><?php echo $user["Fullname"] ?> </td>
                         <td><?php echo $user["Email"] ?> </td>
                         <td><?php echo $user["Status"] ?> </td>
                         <td><a class="btn btn-danger" onclick="deletebyajax(<?php echo $user['Userid']; ?>)"><i class="fa fa-close"></i>delete</a></td>
                         <td><a class="btn btn-info" href="members.php?do=edit&&userid=<?php echo $user['Userid'] ;?>"><i class="fa fa-edit"></i>edit</a></td>
                              
                    </tr>
                    <?php } ?>
                    <script>
                     function deletebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'members.php?do=delete',
                                type: 'POST',
                                data:{userid:id},
                                success:function (data){
                                $(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>
                </table>
        
            </div>
        
        </div>
    <?php }elseif($do=='add' || $do==='edit'){ ?>
      <div class="msg-error"> </div>
        <div class="modal-dailog modal-lg  center-block  ">
  <div class="modal-content">
  <div class="modal-header">
   
   <h4 class="modal-title text-center"><?php isset($_GET['userid'])? print('Edit'):print('Add New'); ?> Member </h4>
  </div>
  <div class="modal-body">

    <?php //find user who will edit if raquest was edit
       $userid=isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;
      
      $stmt=$con->prepare("SELECT *  FROM users WHERE Userid = ? ");
      $stmt->execute(array($userid));
      $row=$stmt->fetch();
      $count= $stmt->rowCount();
      

    
         
    
    ?>
             <form action="members.php?do=insert" class="<?php if($count >0){echo 'edit';}else{echo 'add';} ?>" method="POST" enctype="multipart/form-data">
                 <div class="text-center message" ></div>
                 <input type="hidden" name='userid' value=<?php if($count >0){echo $row['Userid'];} ?> >
                 <div class="form-group height-form-control ">
                     <label class="control-lable" for=""><i class=""></i> Username</label>
                     <input id="username" class="form-control " name="name"  pattern=".{5,}" title=" Username must be minimum 5 chars "  placeholder="type your name" type="text" value="<?php if($count > 0){echo $row['Username']; } ?>" required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Full Name</label>
                     <input id="fullname" class="form-control " name="fullname"  pattern=".{5,}" title=" Username must be minimum 5 chars "  placeholder="type your full name" type="text"  value="<?php if($count > 0 ){echo $row['Fullname']; } ?>" required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Email</label>
                     <input id="email" class="form-control" name="email"  placeholder="type your email" type="email"  value="<?php if($count > 0 ){echo $row['Email']; } ?>"  required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> <?php if($do=='edit') { echo 'Old Password'; }else{ echo'Password';}  ?></label>
                     <input id="password1" class="form-control " name="password1" minlength="6"  placeholder="type your password" type="password"  value="<?php if($count > 0 ){echo $row['Password'] ;} ?>" required="required">
                 </div>

                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i><?php if($do=='edit') {echo 'New Password' ;}else{echo 'Re Password' ;} ?></label>
                     <input  id="password2" class="form-control " name="password2" minlength="6"  placeholder='<?php if($do=="edit"){echo "leave this if dont want to change";}else{echo "Re type your password";} ?>' type="password">

                 </div>

                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i>Avatar</label>
                    
                     <input type="file" id="avatar" class="form-control " name="avatar"  >

                 </div>

                 <input id="submit" type="submit" name="submit"  class="btn btn-success center-block"  value="Save">
             </form>
    
      </div>
   
  
   <div class="modal-footer"> 
      
     </div>
   </div>
 </div>
    <?php }elseif($do=='insert'){ 
      if($_SERVER['REQUEST_METHOD']== 'POST'){
       // if(isset($_POST['submit'])){
           
        $username=$_POST['name'];
        $fullname=$_POST['fullname'];
        $email=$_POST['email'];
        $password1=$_POST['password1'];
        $password2=$_POST['password2']; 
       
        $formErrors=array();

        $avatarname=$_FILES['avatar']['name'];
        $avatarsize=$_FILES['avatar']['size'];
        $avatartmp=$_FILES['avatar']['tmp_name'];
        $avatartype=$_FILES['avatar']['type'];
                // list of allowed file typed upload
        $avatarallowextension = array("jpeg","jpg","png","gif");

        //get avatar

        $avatarextension =strtolower(end( explode('.',$avatarname)));

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
          if(sha1($password1) !== sha1($password2)){
  
                  $formErrors[]='Sorry password is not match';
              
  
          }
          
      }
      if(isset($email)){
          $filteremail=filter_var($email,FILTER_SANITIZE_STRING);
             if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
               $formErrors[]='this email is not valid ';
              
             }
      }
      if(! empty($avatarname) && ! in_array($avatarextension,$avatarallowextension)){
                $formErrors[]='this extension is not allowed';
        }
        if( empty($avatarname)){
            $formErrors[]='avatar is required';
        }
        if( $avatarsize >41940304){
                $formErrors[]='avatar  cant be larger than 4mb ';
        }
       
  
       //check if there is no error proceed the user add
       if(empty($formErrors)){
        $avatar=rand(0,10000000000).'_'.$avatarname;
        move_uploaded_file($avatartmp,"upload\avatars\\". $avatar);
          //check if user exist in database
          $check=checkitem("Username","users",$username);
          if($check == 1){
              $formErrors[]= ' sorry this username is exist ';
              
          
             
          }else{
                //insert to database with this info
     $stmt=$con->prepare("INSERT INTO users ( Username,Fullname,Password,Email,Status ,Avatar,Date) VALUES(:zuser,:zfullname,:zpass,:zemail,0,:zavatar,now() )");
     $stmt->execute(array(
      'zuser' => $username,
      'zfullname' => $fullname,
      'zpass' =>sha1($password1),
      'zemail' =>$email,
      'zavatar'=>$avatar
       ));
     //echo succsess massage
     echo "<span class='alert alert-success text-center'>Congrats Record Inserted</span> <br> <br>";
     
               }
              
           }
           foreach($formErrors as $error){
            echo '<div class="alert alert-danger text-center">' . $error .'</div>' ;
            }
                     
     // }
    }
    }elseif($do=='update') {
        if($_SERVER['REQUEST_METHOD']== 'POST'){
           
            $id    =$_POST['userid']; 
            
             $username=$_POST['name'];
             $fullname=$_POST['fullname'];
             $email=$_POST['email'];
            
             //password trick
        $pass=empty($_POST['password2'])? $_POST['password1']:sha1($_POST['password2']);

            
             $formErrors=array();
           
     
             $avatarname=$_FILES['avatar']['name'];
             $avatarsize=$_FILES['avatar']['size'];
             $avatartmp=$_FILES['avatar']['tmp_name'];
             $avatartype=$_FILES['avatar']['type'];
             
                     // list of allowed file typed upload
             $avatarallowextension = array("jpeg","jpg","png","gif");
     
             //get avatar
     
             $avatarextension =strtolower(end( explode('.',$avatarname)));
     
             if(isset($username)){
                 $filteruser=filter_var($_POST['name'],FILTER_SANITIZE_STRING);
                 if(strlen($filteruser)< 5){
                     
                         $formErrors[]='Username cant be less then 5 character';
                 }
             }
             
           
               if(empty($pass)){
                   $formErrors[]='Sorry Passwored Cant Be Empty';
                   
               }
              
               
           if(isset($email)){
               $filteremail=filter_var($email,FILTER_SANITIZE_STRING);
                  if(filter_var($filteremail,FILTER_VALIDATE_EMAIL) != true){
                    $formErrors[]='this email is not valid ';
                   
                  }
           }
           if(! empty($avatarname) && ! in_array($avatarextension,$avatarallowextension)){
                     $formErrors[]='this extension is not allowed';
             }
             if( empty($avatarname)){
                $formErrors[]='avatar is required';
            }
             if( $avatarsize >41940304){
                     $formErrors[]='avatar  cant be larger than 4mb ';
             }
            
       
            //check if there is no error proceed the user add
            if(empty($formErrors)){
             $avatar=rand(0,10000000000).'_'.$avatarname;
             move_uploaded_file($avatartmp,"upload\avatars\\". $avatar);
               //check if user exist in database
               $stmt2=$con->prepare("SELECT * from  users WHERE Username =? AND Userid !=?");
            $stmt2->execute(array($username,$id));
            $count=$stmt2->rowCount();
      
               if($count == 1){
                   $formErrors[]= ' sorry this username is exist ';
                   
               
                  
               }else{
                   //update the database with this info
      $stmt=$con->prepare("UPDATE users SET Username =? ,Email=? ,Fullname=? ,Password= ? ,Avatar= ? WHERE Userid=? ");
      $stmt->execute(array($username,$email,$fullname,$pass,$avatar,$id));
      //echo succsess massage
         echo "<div class='alert alert-success'>Record Updated</div>";
         
        }

    }
    foreach($formErrors as $error){
        echo '<div class="alert alert-danger text-center">' . $error .'</div>' ;
        }
}
    }elseif($do=='delete'){
        
        $userid=isset($_POST['userid']) && is_numeric($_POST['userid']) ? intval($_POST['userid']) : 0;
        echo $userid;
        
        $check=checkItem('Userid','users',$userid);
      
    if($check > 0){
        $stmt=$con->prepare('DELETE FROM users WHERE Userid=:zuser');
        $stmt->bindParam(':zuser',$userid);
        $stmt->execute();
        $stmt->rowCount();
       echo "<div class='alert alert-success'> Record Deleted</div>";
       
     }else{
        echo '<div class="alert alert-danger">this id not existe</div>';
     } 
    }
   
}else{
  
    header('Location:index.php');
    exit();
}





//<?php 
include 'inc/tamplate/footer.php';
ob_end_flush();
?>