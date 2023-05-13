<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: index.php');//redirect to dashborad page  
}
  include 'init.php';?>


        <!-- start signup form--> 
        
   <div class="modal-dailog modal-lg signup center-block  ">
  <div class="modal-content">
  <div class="modal-header">
   
   <h4 class="modal-title text-center"> Sign Up </h4>
  </div>
  <div class="modal-body">
             <form>
                 <div class="text-center message" ></div>
                 <div class="form-group height-form-control ">
                     <label class="control-lable" for=""><i class=""></i> Username</label>
                     <input id="username" class="form-control " name="username"  pattern=".{5,}" title=" Username must be minimum 5 chars "  placeholder="type your name" type="text" required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Full Name</label>
                     <input id="fullname" class="form-control " name="fullname"  pattern=".{5,}" title=" Username must be minimum 5 chars "  placeholder="type your full name" type="text" required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Email</label>
                     <input id="email" class="form-control" name="email"  placeholder="type your email" type="email"  required="required">
                 </div>


                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Password</label>
                     <input id="password1" class="form-control " name="password" minlength="6"  placeholder="type your password" type="password" required="required">
                 </div>

                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Re Password</label>
                     <input  id="password2" class="form-control " name="repassword" minlength="6"  placeholder="Re type your password" type="password" required="required">
                 </div>

                 <div class="form-group height-form-control">
                     <label class="control-lable" for=""><i class=""></i> Address</label>
                     <input id="address" class="form-control " name="address"   placeholder="type your address exactly" type="text" required="required">
                 </div>

                 <input id="submit" type="submit" name="signup"  class="submit btn-submit center-block" value="Sign Up">
             </form>
    
      </div>
   
  
   <div class="modal-footer"> 
       <h5 class="text-center">go to <span class="btn btn-default btn-switch1">login</span></h5>
     </div>
   </div>
 </div>
 
 <!-- fin signup-->
 <!-- start login-->
 <div class="modal-dailog modal-lg login center-block selected  ">
  <div class="modal-content">
  <div class="modal-header">
   
   <h4 class="modal-title text-center"> Log In </h4>
  </div>
  <div class="modal-body">
             <form action="validation-form.php" method="post">
             <!--<div class="text-center message1" ></div> -->
                 <div class="text-center message" ></div>
                 <div class="form-group height-form-control ">
                     <label class="control-lable" for=""><i class=""></i> Username</label>
                     <input   class="form-control" name="username"  placeholder="type your name" required="required" type="text">
                 </div>


                 <div class="form-group height-form-control ">
                     <label class="control-lable" for=""><i class=""></i> Password</label>
                     <input  class="form-control" name="password"  placeholder="type your Password" required="required" type="password">
                 </div>

                

                 <button  type="submit" name="login" class="submit btn-submit center-block"> Log in</button>
             </form>
    
      </div>
   
  
   <div class="modal-footer"> 
   <h5 class="text-center">go to <span class="btn btn-default btn-switch">signup</span></h5>
     </div>
   </div>
 </div>
<!-- fin login-->
<br>
<div class="text-center"><a style="text-decoration:none" href="admin/index.php">Login admin <i class="fa fa-arrow-right"></i></a> </div>

<?php
include 'inc/tamplate/footer.php';
?>