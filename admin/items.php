<?php 
ob_start();//output buffering start

session_start();

if(isset($_SESSION['admin'])){
  
    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 
    include "init.php";

    if ($do=='manage') {
      $sort='ASC';
      $sort_array=array('ASC','DESC');
      if(isset($_GET['sort'])&& in_array($_GET['sort'],$sort_array)){
         $sort=$_GET['sort'];}
      $stmt=$con->prepare("SELECT  products.*,
      categories.Catname AS category,
      users.Username 
      FROM    products
      INNER JOIN
            categories
      ON      categories.Catid = products.category
      INNER JOIN
            users
      ON      users.Userid = products.Username 
       ORDER BY Proid $sort   ");
      $stmt->execute();
      // assign to variable
      $items=$stmt->fetchAll();
        

        ?>
        
        <h2 class="text-center">Table Products</h2>
        <hr>
        <div class="container-fluid">
            <div class="row">
            <div class='option ' ><i class="fa fa-sort"></i>Ordering:[
                         <a class='<?php if($sort == "ASC"){echo "active";}?>' href="?sort=ASC">ASC </a>|
                         <a class='<?php if($sort == "DESC"){echo "active";}?>' href="?sort=DESC">DESC</a>]
                        
                      </div>
                <a href="items.php?do=add" class="btn btn-warning pull-right"> <i class="fa fa-plus"></i> New Item</a>
                <br><br>
                <table class="table table-resopnsive">
                <tr>
                            <td>#ID</td>
                            <td>NAME</td>
                            <td>DESCRIPTION</td>
                            <td>PRICE</td>
                            <td>Brand</td>
                            <td>CATEGORY</td>
                            <td>img1</td>
                            <td>img2</td>
                            <td>img3</td>
                            <td>img4</td>
                            <td>img5</td>
                            <td>USERNAME</td>
                            <td>ADDING DATE</td>                            
                            <td>CONTROL</td>                           
                        </tr>
                        <?php
                        foreach($items as $item){
                            echo "<tr id='delete " .$item['Proid']."'>";
                            echo "<td>" . $item['Proid'] . "</td>";
                            echo "<td>" . $item['Proname'] . "</td>";
                            echo "<td>" . $item['Description'] . "</td>";
                            echo "<td>" . $item['Price'] . "</td>";
                            echo "<td>" . $item['Brand'] . "</td>";
                            echo "<td>" . $item['category'] . "</td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/" . $item['Proimg1'] . "'/></td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/" . $item['Proimg2'] . "'/></td>"; 
                            echo "<td><img class='img-responsive avatar' src='upload/img/" . $item['Proimg3'] . "'/></td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/" . $item['Proimg4'] . "'/></td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/" . $item['Proimg5'] . "'/></td>";
                            echo "<td>"  . $item['Username'] . "</td>";
                            echo "<td>" . $item['Date'] . "</td>";
                            echo "<td>
                                     <a href='items.php?do=edit&itemid=" . $item['Proid'] . "&parent=". $item['Child']."' class='btn btn-success'><i class='fa fa-edit'></i>EDIT</a>
                                      <a  onclick='deletebyajax(".$item['Proid'].")' class='btn btn-danger '><i class='fa fa-close'></i>DELETE</a>";
                                      if($item["Approve"]==1){
                                        echo "<a href='items.php?do=Approve&itemid=" . $item["Proid"] . "&status=1' class='btn btn-info  activate '><i class='fa fa-check'></i> Active</a>";
                                        }else{
                                          echo "<a href='items.php?do=Approve&itemid=" . $item["Proid"] . "&status=0' class='btn btn-info  activate '><i class='fa fa-minc'></i> Bloked</a>";
                                        }
                               echo  " </td>";
                            echo "</tr>";
                        }
                        ?>                  
                </table>
            </div>
       
        </div>
                    <script>
                     function deletebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'items.php?do=delete',
                                type: 'GET',
                                data:{proid:id},
                                success:function (data){
                                $(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>
                  
   <?php  }elseif($do=='add' || $do=='edit'){ 
     if($do=='edit'){
      
      $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
      $stmt=$con->prepare("SELECT *  FROM products WHERE Proid = ? ");
       $stmt->execute(array($itemid));
       $item=$stmt->fetch();
       
     }
     ?>
    
        <h1 class="text-center"><?php if($do=='edit'){echo 'Edit' ;}else{echo 'Add New';} ?> Item</h1>
        <div class="container">
           <form class="form-horizontal" action="<?php if($do=='edit'){echo '?do=update';}else{echo '?do=insert' ;} ?>" method="POST" enctype="multipart/form-data">
               
              <!-- start name failed -->
              <div class="form-group form-group-lg">
                <label classs=" control-label" >Name</label>
                <div class="">
                <input type="text" name="name"  class="form-control"  <?php if($do=='edit'){echo  'value='.$item['Proname'].'' ;} ?>  required="required" placeholder="name of the item" >
                <input type="hidden" name="itemid"  <?php if($do=='edit'){echo  'value='.$item['Proid'].'' ;} ?> >
                </div>
              </div>
               <!-- start description failed -->
               <div class="form-group form-group-lg">
                <label classs=" control-label" >Description</label>
                <div class="">
                <textarea  name="description"  class="form-control"  placeholder="desc of the item"   required="required" > <?php if($do=='edit'){echo $item['Description']; }?></textarea>
                </div>
              </div>
               <!-- start price failed -->
               <div class="form-group form-group-lg">
                <label classs=" control-label" >Price</label>
                <div class="">
                <input type="text" name="price"  class="form-control"  <?php if($do=='edit'){echo  'value='.$item['Price'].'' ;} ?> required="required" placeholder="price of the item" >
                </div>
              </div>
               <!-- start country failed -->
               <div class="form-group form-group-lg">
                <label classs=" control-label" >Brand</label>
                <div class="">
                <input type="text" name="brand"  class="form-control"  <?php if($do=='edit'){echo  'value='.$item['Brand'].'' ;} ?>  required="required" placeholder="Brand of  item" >
                </div>
              </div>
               <!-- start img failed -->
               <div class="form-group form-group-lg">
                <label classs=" control-label" >img Prancipal</label>
                <input type="file" name="img1"  class="form-control"  <?php if($do!=='edit'){echo ' required="required"' ;} ?>  >
                <input type="hidden" name="hidimg1"  <?php if($do=='edit'){echo  'value='.$item['Proimg1'].'' ;} ?> >
                </div>

                <div class="form-group form-group-lg">
                <label classs=" control-label" >img 2</label>
                <input type="file" name="img2"  class="form-control" <?php if($do!=='edit'){echo ' required="required"' ;} ?>  >
                <input type="hidden" name="hidimg2"  <?php if($do=='edit'){echo  'value='.$item['Proimg2'].'' ;} ?> >
                </div>

                <div class="form-group form-group-lg">
                <label classs=" control-label" >img 3</label>
                <input type="file" name="img3"  class="form-control" <?php if($do!=='edit'){echo ' required="required"' ;} ?> >
                <input type="hidden" name="hidimg3"  <?php if($do=='edit'){echo  'value='.$item['Proimg3'].'' ;} ?> >
                </div>

                <div class="form-group form-group-lg">
                <label classs=" control-label" >img 4</label>
                <input type="file" name="img4"  class="form-control" <?php if($do!=='edit'){echo ' required="required"' ;} ?>  >
                <input type="hidden" name="hidimg4"  <?php if($do=='edit'){echo  'value='.$item['Proimg4'].'' ;} ?> >
                </div>
               
                <div class="form-group form-group-lg">
                <label classs=" control-label" >img 5</label>
                <input type="file" name="img5"  class="form-control" <?php if($do!=='edit'){echo ' required="required"' ;} ?>   >
                <input type="hidden" name="hidimg5"  <?php if($do=='edit'){echo  'value='.$item['Proimg5'].'' ;} ?> >
                </div>

                <div class="form-group form-group-lg">
                <label classs=" control-label" > Quantity</label>
                <input type="text" name="qnty"  class="form-control"  <?php if($do=='edit'){echo  'value='.$item['Qnty'].'' ;}?>  required="required"  >
                </div>
               <!-- start members failed -->
               
               <div class="form-group form-group-lg">
                <label classs=" control-label" >Member</label>
                <div class="">
                 <select class='form-control' name="member">
                   <?php if($do!=='edit'){ ?>
                 <option value="0">...</option>
                 <?php 
                  $allmembers= getallfrom('*','users',"where Status=1","",'Userid'); 
               
                 foreach($allmembers as $user){
                     echo "<option value='". $user['Userid']."'>". $user['Username']."</option>";
                 }
                }else{  $stmt=$con->prepare("SELECT *  FROM users ");
                  $stmt->execute();
                  $users=$stmt->fetchAll();  
              
                 foreach($users as $user){
                      echo "<option value='". $user['Userid']."'" ; if($item['Username']==$user['Userid']){ echo 'selected';}echo " >". $user['Username']."</option>";
                 }
                }?>
                 </select>
                </div>
              </div>
                <!-- start category failed -->
                <div class="form-group form-group-lg">
                <label classs=" control-label" >Category</label>
                <div class="">
                 <select class='form-control' id="#parent" name="parent">
                 <?php if($do!=='edit'){ ?>
                 <option value="">...</option>
                 <?php 

                  $allcats= getallfrom('*','categories',"where Parent = 0","",'Catid'); 
                 foreach($allcats as $cat){
                     echo "<option value='". $cat['Catid']."'>". $cat['Catname']."</option>";
                

                 }
                }else{
                  $stmt=$con->prepare("SELECT *  FROM categories ");
                  $stmt->execute();
                  $cats=$stmt->fetchAll(); 
                  foreach($cats as $cat){
                  echo "<option value='". $cat['Catid']."'" ; if($item['category']==$cat['Catid']){ echo 'selected';}echo " >". $cat['Catname']."</option>";
                 
                  }
                }
                 ?>
                 </select>
                </div>
              </div>
              <!-- start category failed -->
              <div class="form-group form-group-lg">
                <label classs=" control-label" > child Category</label>
                <div class="">
                 <select class='form-control' id="child"  name="child">
               
                 </select>
                </div>
              </div>
          

               <!-- start qnty failed -->
               <div class="form-group form-group-lg">
                <label classs=" control-label" >Tags</label>
                <div class="">
                <input type="text" name="tags"  class="form-control"  <?php if($do=='edit'){echo  'value='.$item['Tags'].'' ;} ?>  placeholder="separate tags with comma (,)" >
                </div>
              </div>
                <!-- start commenting failed -->
                <div class="form-group form-group-lg">
                <label classs="control-label" > Allow Comminting</label>
                   <div class="">
                       <div>
                           <input id="com-yes" type="radio" name='commenting' value="1"  <?php if($do=='edit' && $item['Alowcomment']==1){echo 'checked' ;}?> >
                           <label for="com-yes"> Yes</label>
                       </div>
                       <div>
                           <input id="com-no" type="radio" name='commenting' value="0"  <?php if($do=='edit'  && $item['Alowcomment']==0){echo  'checked' ;} ?> >
                           <label for="com-no"> No</label>
                       </div>
                   </div>
              </div>

               <!-- start submite failed -->
               <div class="form-group form-group-lg">
                
                   <div class=" "><input type="submit" value=" <?php if($do=='edit'){echo  'Edit item' ;}else{echo '   Add item' ;} ?> " class="btn-primary btn-lg" ></div>
              </div>
           </form>
           <?php
           ////////////////////////////////////////////////////
                    // select comments of item
                        $stmt=$con->prepare("SELECT 
                        comments.*,users.Username as member
                  from  
                        comments

                  inner join
                      users
                  on
                      users.Userid=comments.userid
                  where
                      Proid=? ");
                  $stmt->execute(array($itemid));
                  // assign to variable
                  $rows=$stmt->fetchAll();
                  if(! empty($rows)){
                  ?>
                  <hr>
                  <h1 class="text-center">Manage  [<?php echo  $item['Proname']?>] comments</h1>

                  <div class='table-responsive'>
                  <table class='main-table text-center table table-bordered'>
                  <tr>
                  
                  <td>Comment</td>
                  
                  <td>Username</td>
                  <td> DATE</td>
                  <td>CONTROLE</td>
                  
                  </tr>
                  <?php
                  foreach($rows as $row){
                  echo "<tr id='delete".$row['Cid']."'>";
                  
                  echo "<td>" . $row['Comment'] . "</td>";

                  echo "<td>" . $row['member'] . "</td>";
                  echo "<td>"  . $row['Date'] . "</td>";
                  echo "<td>
                            <a href='comments.php?do=edit&cid=" . $row['Cid'] . "' class='btn btn-success'><i class='fa fa-edit'></i>EDIT</a>
                            <a  onclick='deletebyajax(". $row['Cid'].")' class='btn btn-danger confirm'><i class='fa fa-close'></i>DELETE</a>";
                              if($row['Status']==0){
                              echo "<a id='approve".$row['Cid']."'  onclick='approvebyajax(".$row['Cid'].")' class='btn btn-info activate '><i class='fa fa-check'></i>APPROVE</a>";
                              }
                      echo  " </td>";
                  echo "</tr>";
                  }
                  ?>                  
                  </table>
                  <script>
                     function deletebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'comments.php?do=delete',
                                type: 'GET',
                                data:{cid:id},
                                success:function (data){
                               // $(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>
                     <script>
                     function approvebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'comments.php?do=Approve',
                                type: 'GET',
                                data:{cid:id},
                                success:function (data){
                               // $(".errr-msg").html(data);
                                $('#approve'+id).hide('slow');
                                },
                               
                                });};}
                    </script>

                  </div>
                 <?php } 
                  

               //////////////////////////////////////// 
               ?>
        </div>
       
    <?php }elseif($do=='insert'){
       if($_SERVER['REQUEST_METHOD']=='POST'){

       
           
           $name  =$_POST['name'];
           $desc  =$_POST['description'];
           $price =$_POST['price'];
           $brand  =$_POST['brand'];
           $img1=$_FILES['img1']['name'];
           $img1_tmp=$_FILES['img1']['tmp_name'];
           $img2=$_FILES['img2']['name'];
           $img2_tmp=$_FILES['img2']['tmp_name'];

           $img3=$_FILES['img3']['name'];
           $img3_tmp=$_FILES['img3']['tmp_name'];

           $img4=$_FILES['img4']['name'];
           $img4_tmp=$_FILES['img4']['tmp_name'];

           $img5=$_FILES['img5']['name'];
           $img5_tmp=$_FILES['img5']['tmp_name'];

           $qnty  =$_POST['qnty'];

           $member  =$_POST['member'];
          $parent= $_POST['parent'];
          $child= $_POST['child'];
          $tags= $_POST['tags'];
          $allowcomment=$_POST['commenting'];
          $formErrors=array();
        // list of allowed file typed upload
        $avatarallowextension = array("jpeg","jpg","png","gif");

        //get avatar

        $ximg1 =strtolower(end( explode('.',$img1)));
        $ximg2 =strtolower(end( explode('.',$img2)));
        $ximg3 =strtolower(end( explode('.',$img3)));
        $ximg4 =strtolower(end( explode('.',$img4)));
        $ximg5 =strtolower(end( explode('.',$img5)));
        if(! in_array($ximg1,$avatarallowextension) || ! in_array($ximg2,$avatarallowextension) 
         || ! in_array($ximg3,$avatarallowextension)  || ! in_array($ximg4,$avatarallowextension) || ! in_array($ximg5,$avatarallowextension)){
          $formErrors[]='this extension is not allowed';
  }

   
           //validation the form
   
           
           if(empty($name) || empty($desc) || empty( $price )|| empty( $brand)|| empty( $img1)
           || empty( $img2)|| empty( $img3) || empty( $img4)|| empty( $img5)|| empty($member) || empty( $parent) || empty( $child)|| empty( $tags) || empty($qnty)){
               $formErrors[]= ' Cant Be any facking filed  <strong> Empty</strong></div> ';
           }
          
           
          foreach($formErrors as $error){
              echo '<div class="alert alert-danger">' . $error .'</div>' ;
          }
   
           //check if there is no error proceed the apdate operation
           if(empty($formErrors)){
            $img1=rand(0,10000000000).'_'.$img1;
            move_uploaded_file($img1_tmp,"upload\img\\". $img1);
            $img2=rand(0,10000000000).'_'.$img2;
            move_uploaded_file($img2_tmp,"upload\img\\". $img2);
            $img3=rand(0,10000000000).'_'.$img3;
            move_uploaded_file($img3_tmp,"upload\img\\". $img3);
            $img4=rand(0,10000000000).'_'.$img4;
            move_uploaded_file($img4_tmp,"upload\img\\". $img4);
            $img5=rand(0,10000000000).'_'.$img5;
            move_uploaded_file($img5_tmp,"upload\img\\". $img5);
                     //insert to database with this info
          $stmt=$con->prepare("INSERT INTO products ( Proname ,Description,Price ,Brand,category,Child,Proimg1,Proimg2,Proimg3,Proimg4,Proimg5,Qnty,Username,Approve,Alowcomment,tags,Date)
           VALUES(:zname,:zdesc,:zprice,:zbrand,:zcategory,:zchild,:zimg1,:zimg2,:zimg3,:zimg4,:zimg5,:zqnty,:zmember,1,:zcomment,:ztags,now() )");
          $stmt->execute(array(
           'zname' => $name,
           'zdesc' =>$desc,
           'zprice' =>$price,
           'zbrand' => $brand,
           'zcategory'=> $parent,
           'zchild' =>$child,
           'zimg1'=>$img1,
           'zimg2'=>$img2,
           'zimg3'=>$img3,
           'zimg4' => $img4,
           'zimg5' =>$img5,
           'zqnty' =>$qnty,
           'zmember' =>$member,
           'zcomment' =>$allowcomment,
           'ztags'=>$tags
            ));
          //echo succsess massage
           $theMsg="<div class='alert alert-success'>Record Inserted</div>";
           redirectHome($theMsg,'back');
                    }
                   
            }else{
                   
                $theMsg =  '<div class="alert alert-danger">sorry you can not browes this page directry</div>';
                 redirectHome($theMsg);
                 
             }
    
    }elseif($do=='update') {
      if($_SERVER['REQUEST_METHOD']=='POST'){
          $itemid=$_POST['itemid'];
        $name  =$_POST['name'];
        $desc  =$_POST['description'];
        $price =$_POST['price'];
        $brand  =$_POST['brand'];
        $formErrors=array();
         // list of allowed file typed upload
     $avatarallowextension = array("jpeg","jpg","png","gif");
        if(empty($_FILES['img1']['tmp_name'])){       
        }else{
          $img1=$_FILES['img1']['name'];
          $img1_tmp=$_FILES['img1']['tmp_name'];
          $ximg1 =strtolower(end( explode('.',$img1)));
          if(! in_array($ximg1,$avatarallowextension)){
           $formErrors[]= 'this extension is not allowed';
          }else{
            $img1=rand(0,10000000000).'_'.$img1;
            move_uploaded_file($img1_tmp,"upload\img\\". $img1);
            $stmt=$con->prepare("UPDATE  products SET Proimg1=$img1 WHERE Proid==$itemid ");
            $stmt->execute();
          }
          
         
        }

        if(empty($_FILES['img2']['tmp_name'])){         
        }else{
          $img2=$_FILES['img2']['name'];
          $img2_tmp=$_FILES['img2']['tmp_name'];
          $ximg2 =strtolower(end( explode('.',$img2)));
          if(! in_array($ximg2,$avatarallowextension)){
            $formErrors[]='this extension is not allowed';
          }else{
            $img2=rand(0,10000000000).'_'.$img2;
            move_uploaded_file($img2_tmp,"upload\img\\". $img2);
            $stmt=$con->prepare("UPDATE  products SET Proimg2=$img2 WHERE Proid==$itemid ");
            $stmt->execute();
          }
        }

        if(empty($_FILES['img3']['tmp_name'])){        
        }else{
          $img3=$_FILES['img3']['name'];
          $img3_tmp=$_FILES['img3']['tmp_name'];
          $ximg3 =strtolower(end( explode('.',$img3)));
          if( ! in_array($ximg3,$avatarallowextension)){
            $formErrors[]='this extension is not allowed';
          }else{
            $img3=rand(0,10000000000).'_'.$img3;
            move_uploaded_file($img3_tmp,"upload\img\\". $img3);
            $stmt=$con->prepare("UPDATE  products SET Proimg3=$img3 WHERE Proid==$itemid ");
            $stmt->execute();
          }
        }

        if(empty($_FILES['img4']['tmp_name'])){
        }else{
          $img4=$_FILES['img4']['name'];
          $img4_tmp=$_FILES['img4']['tmp_name'];
          $ximg4 =strtolower(end( explode('.',$img4)));
          if(! in_array($ximg4,$avatarallowextension)){
            $formErrors[]='this extension is not allowed';
          }else{
            $img4=rand(0,10000000000).'_'.$img4;
            move_uploaded_file($img4_tmp,"upload\img\\". $img4);
            $stmt=$con->prepare("UPDATE  products SET Proimg4=$img4 WHERE Proid==$itemid");
            $stmt->execute();
          }
        }

        if(empty($_FILES['img5']['tmp_name'])){
        }else{
          $img5=$_FILES['img5']['name'];
          $img5_tmp=$_FILES['img5']['tmp_name'];
          $ximg5 =strtolower(end( explode('.',$img5)));
          if( in_array($ximg5,$avatarallowextension)){
            $formErrors[]='this extension is not allowed';
          }else{
            $img5=rand(0,10000000000).'_'.$img5;
            move_uploaded_file($img5_tmp,"upload\img\\". $img5);
            $stmt=$con->prepare("UPDATE  products SET Proimg5=$img5  WHERE Proid==$itemid");
             $stmt->execute();
          }         
          }
      
        $qnty  =$_POST['qnty'];
        $member  =$_POST['member'];
       $parent= $_POST['parent'];
       $child= $_POST['child'];
       $tags= $_POST['tags'];
       $allowcomment=$_POST['commenting'];
       
    
        //validation the form

        
        if(empty($name) || empty($desc) || empty( $price )|| empty( $brand)|| empty($member) || empty( $parent) || empty( $child)|| empty( $tags) || empty($qnty)){
            $formErrors[]= ' Cant Be any facking filed  <strong> Empty</strong></div> ';
        }
       
        
       foreach($formErrors as $error){
           echo '<div class="alert alert-danger">' . $error .'</div>' ;
       }

       
        if(empty($formErrors)){
        
                  //update to database with this info
       $stmt=$con->prepare("UPDATE  products SET  Proname=? ,Description=?,Price=? ,Brand=?,category=?,Child=?,Qnty=?,Username=?,Approve=?,Alowcomment=?,tags=? WHERE Proid=$itemid");
       
       $stmt->execute(array(
         $name,
        $desc,
        $price,
        $brand,
         $parent,
        $child,
       $qnty,
        $member,1,
        $allowcomment,
        $tags
         ));
         $theMsg= "<div class='alert alert-success'>Record Updated</div>";
         redirectHome($theMsg,'back','2');
        }}
    }elseif($do=='delete'){
      $proid=isset($_GET['proid']) && is_numeric($_GET['proid']) ? intval($_GET['proid']) : 0;
    
      $check=checkItem('Proid','products',$proid);
    
  if($check > 0){
      $stmt=$con->prepare('DELETE FROM products WHERE Proid=:zid ' );
      $stmt->bindParam(':zid',$proid );
      $stmt->execute();
      $stmt->rowCount();
     
   }else{
       $theMsg ='<div class="alert alert-danger">this id not existe</div>';
       redirectHome($theMsg);
       
   } 
  
    }elseif($do=='Approve'){
      $itemid=isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
          
      $check=checkItem('Proid','products',$itemid);
    
  if($check > 0){
   $status=isset($_GET['status'])&& is_numeric($_GET['status'])?intval($_GET['status']) :'' ;
if($status== 0){
    
      $stmt=$con->prepare('UPDATE products SET Approve=1 WHERE Proid=:zitem');
      $stmt->bindParam(':zitem',$itemid);
      $stmt->execute();
      $stmt->rowCount();
      $theMsg= "<div class='alert alert-success'>Record Activated</div>";
      redirectHome($theMsg,'back');
}elseif($status== 1){
  $stmt=$con->prepare('UPDATE products SET Approve=0 WHERE Proid=:zitem');
  $stmt->bindParam(':zitem',$itemid);
  $stmt->execute();
  $stmt->rowCount();
  $theMsg= "<div class='alert alert-success'>Record Bloked</div>";
  redirectHome($theMsg,'back');
}
   }else{
       $theMsg ='<div class="alert alert-danger">this id not existe</div>';
       redirectHome($theMsg);
      
   } 
  


    }
    include "inc/tamplate/footer.php";
    if($do=='edit'){$childid=isset($_GET['parent']) && is_numeric($_GET['parent']) ? intval($_GET['parent']) : 0;
    ?>
    <script>

    getchildoption(<?php echo $childid ;?>);
    
    </script>
    <?php }
}else{
  
    header('Location:index.php');
    exit();
}
ob_end_flush();
?>