<?php
ob_start();//output buffering start
session_start();

if(isset($_SESSION['admin'])){
    $pageTitle='dashboard';
    $do='manage';

    include "init.php";
   //starte dashboured page
    
   ?>
 <div class="container home-stats text-center">
    <h1>Dashboard</h1>
       <div class='row'>

         <div class='col-md-3'>
         <div class="stat st-members ">
           <i class="fa fa-users" ></i>
            
           <div class='info'>Total Members 
              <span><a href="members.php"><?php echo countItems('Userid','users') ?></a></span>
           </div>
          </div>
         </div>
         <div class='col-md-3 '>

           <div class='stat st-panding '> 
             <i class='fa fa-user-plus'></i>
             <div class='info'>Panding Items
               <span><a href="?panding=panding"><?php echo checkitem('Approve','products',0)?></a></span>
           </div>
          </div>
         </div>
         <div class='col-md-3 '>
           
           <div class='stat st-item '>
             <i class='fa fa-tag'></i> 
           <div class='info'> Total Items
               <span><a href="items.php"><?php echo countItems('Proid','products') ?></a></span> 
           </div>
          </div>
         </div>
         <div class='col-md-3' >
           <div class='stat st-comment  '>
             <i class='fa fa-comments'></i>
             <div class='info'>Panding Comments
              <span>
              <a href="?pandcom=pandcom"><?php  $stmt2= $con->prepare("SELECT COUNT(Cid) FROM comments where Statuss=0");
                                                $stmt2->execute();
                                              
                                              echo $stmt2->fetchColumn();
               ?></a>
              </span>  
           </div>
           </div>
         </div>
       </div>
 </div>

<hr>
   <?php
 if(isset($_GET['panding'])){
  
$panddings=getallfrom('*','products','where Approve=0 ',"","Proid","" ); ?>
   <div class="container">
   <div class="row">

      <table class="table table-responsive">
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
    <?php  foreach($panddings as $item){  
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
                               echo  "</td>";
                            echo "</tr>"; 
                                      } ?>
      </table>
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
   </div>
   </div>
 <?php 
  
}elseif(isset($_GET['pandcom'])){
  
  $stmtn=$con->prepare("SELECT 
  comments.*, products.Proname as item_name,users.Username as member
from  
  comments
inner join 
  products
on 
   products.Proid=comments.proid
inner join
 users
on
 users.Userid=comments.userid
 where Statuss=0 ORDER BY Cid DESC  ");
$stmtn->execute();
// assign to variable
$rows=$stmtn->fetchAll();

?>
<h1 class="text-center">Manage comment</h1>
<div class="container">
<div class='table-responsive'>
<table class='main-table text-center table table-bordered'>
                        <tr>
                            <td>#ID</td>
                            <td>Comment</td>
                            <td>Item name</td>
                            <td>User Name</td>
                            <td> DATE</td>
                            <td>CONTROLE</td>
                            
                        </tr>
                        <?php
                        foreach($rows as $row){
                            echo "<tr  id='delete".$row['Cid']."'>";
                            echo "<td>" . $row['Cid'] . "</td>";
                            echo "<td>" . $row['Comment'] . "</td>";
                            echo "<td>" . $row['item_name'] . "</td>";
                            echo "<td>" . $row['member'] . "</td>";
                            echo "<td>"  . $row['Date'] . "</td>";
                            echo "<td>
                                     <a href='comments.php?do=edit&cid=" .$row['Cid'] . "' class='btn btn-success'><i class='fa fa-edit'></i>EDIT</a>
                                      <a  onclick='deletebyajax(". $row['Cid'].")' class='btn btn-danger confirm'><i class='fa fa-close'></i>DELETE</a>";
                                       if($row['Statuss']==0){
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
</div>
 <?php
}

  //fin page dashbourd
  include "inc/tamplate/footer.php"; 
}else{
    echo 'you are not Authorized to view this page';
    header('Location:index.php');
    exit();
}

ob_end_flush();
?>