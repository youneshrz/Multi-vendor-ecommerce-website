<?php 
/*
====================================================
==manage comment page 
==you can add |edit| deletemember from here
====================================================
*/
session_start();
$pageTitle="comment";

if(isset($_SESSION['admin'])){
    
   

    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 
    include "init.php";
    if ($do=='manage') { //manage member page  
      
        // select all users except admin
      $stmt=$con->prepare("SELECT 
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
                                users.Userid=comments.userid  ORDER BY Cid DESC");
      $stmt->execute();
      // assign to variable
      $rows=$stmt->fetchAll();
      if(!empty($rows)){
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
                                data:{Cid:id},
                                success:function (data){
                              
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>
                     <script>
                     function approvebyajax(id){
                           
        
                            $.ajax({
                                url:'comments.php?do=Approve',
                                type: 'GET',
                                data:{cid:id},
                                success:function (data){
                               // $(".errr-msg").html(data);
                                $('#approve'+id).hide('slow');
                                },
                               
                                });}
                    </script>
            </div>
       
        </div>
      
     
   <?php
      }else{
        echo "<div class='container'>";
        echo "<div class='alert nice-massage'> there is no recourd to show</div>";
        echo "</div>";
    }

    
    }elseif($do=='edit'){  //edit page 
        $cid=isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
         
        $stmt=$con->prepare("SELECT *  FROM comments WHERE Cid = ? ");
        $stmt->execute(array($cid));
        $row=$stmt->fetch();
        $count= $stmt->rowCount();

       if($count > 0){?>
           
        
      
        
        <h1 class="text-center">Edit Comment</h1>
        <div class="container">
           <form class="form-horizontal" action="?do=update" method="POST">
               <input type="hidden" name="comid" value="<?php echo $cid ?>">
              <!-- start comment failed -->
              <div class="form-group form-group-lg">
              
                <label classs=" control-label" >Comment</label>
                <div class="">
                 <textarea class="form-control" name="comment" ><?php echo $row['Comment'] ?></textarea>
                </div>
              </div>
              
               <!-- start submite failed -->
               <div class="form-group form-group-lg">
                
                   <div class=""><input type="submit" value="Save" class="btn-primary btn-lg" ></div>
              </div>
           </form>
     <?php 
       } else{
           echo '<div class="container">';
           $theMsg='<div class="alert alert-danger">theres no such id </div>';
           redirectHome($theMsg);
           echo '</div>';
       }
   }elseif($do=='update') {  //update page
    echo "<h1 class='text-center'>Update Comment</h1>";
     echo "<div class='container'>";
     
    if($_SERVER['REQUEST_METHOD']=='POST'){
        // get variable from the form
        $comid    =$_POST['comid'];
        $comment  =$_POST['comment'];
      
      //update the database with this info
      $stmt=$con->prepare("UPDATE comments SET Comment =? WHERE Cid=? ");
      $stmt->execute(array($comment,$comid));
      //echo succsess massage
         $theMsg= "<div class='alert alert-success'> Record Updated</div>";
          redirectHome($theMsg,'back','2');
        

    }else{
    $theMsg= '<div vlass="alert alert-danger">sorry you can not browes this page directry</div>';
        redirectHome($theMsg);
    }
    echo "<div/>";
       
   }elseif($do=='delete'){// delete comment page
   

    $Cid=isset($_GET['Cid']) && is_numeric($_GET['Cid']) ? intval($_GET['Cid']) : 0;
     
    $check= checkitem("Cid","comments",$Cid);
   
    
  if($check > 0){
      $stmt=$con->prepare('DELETE FROM comments WHERE Cid=:zid');
      $stmt->bindParam(':zid',$Cid);
      $stmt->execute();
      $stmt->rowCount();
     
   }else{
       $theMsg ='<div class="alert alert-danger">this id not existe';
       redirectHome($theMsg);
       echo '</div>';
   } 
  
       }elseif($do=='Approve'){//   approve comment page
       
    
        $cid=isset($_GET['cid']) && is_numeric($_GET['cid']) ? intval($_GET['cid']) : 0;
          
          $check=checkItem('Cid','comments',$cid);
        
      if($check > 0){
          $stmt=$con->prepare('UPDATE comments SET Statuss=1 WHERE Cid=:zid');
          $stmt->bindParam(':zid',$cid);
          $stmt->execute();
          $stmt->rowCount();
         
       }else{
           $theMsg ='<div class="alert alert-danger">this id not existe';
           redirectHome($theMsg);
           echo '</div>';
       } 
     
       }
    include "inc/tamplate/footer.php";
}else{
  
    header('Location:index.php');
    exit();
}
?>