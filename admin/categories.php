<?php 
ob_start();//output buffering start
session_start();
if(isset($_SESSION['admin'])){
   

    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 
     
    include "init.php";

    if ($do=='manage' || $do=='edit') {
        $cats=getallfrom('*','categories','where Parent=0','','Catid','asc' );

        ?>
        
        <h2 class="text-center">Table  Categories</h2>
        <hr>
        <div class="container">
            <div class="row">
                <div class="option pull-right">
                <i class="fa fa-eye"></i>View: [<span class='active' data-view='full'>Full</span> ||
                                                        <span data-view='classic' >Classic</span>]
                </div>
                <br><br><br>
                <div class="col-md-4">
             <?php if($do=='edit'){
                  $catid=$_GET['catid']; 
                //$editcats=getallfrom('*','categories',"where Catid={$catid}",'','Catid','asc' );
                $stmt=$con->prepare("SELECT *  FROM categories WHERE Catid = ? ");
                $stmt->execute(array($catid));
                $editcats=$stmt->fetch();
                $count= $stmt->rowCount();
             }
                ?>
                  <h3 class="text-center"><?php if($do=='edit'){echo 'Edit ';}else{ echo 'Add New';}  ?>Category</h3>
                  <br><br>
                  <form  action="<?php if($do=='edit'){echo '?do=update ';}else{ echo '?do=insert'; } ?>" method="POST">
                      <div class="form-group">
                          <label class="control-lable" for="">Name Of Category</label>
                          <input type="hidden" name="catid" value="<?php if($do=='edit'){echo $editcats['Catid'];}?>">
                          <input class="form-control" type="text" name="catname" <?php if($do=='edit'){echo 'value=" '.$editcats['Catname'].'"';} ?> >
                      </div>
                      <?php   $addcats=getallfrom('*','categories','where Parent = 0','','Catid','asc' ); ?>
                      <div class="form-group">
                          <label class="control-lable" for="">Parent</label>
                          <select class="form-control" name="parent">
                              <option value="0">...</option>
                             
                         <?php foreach($addcats as $addcat){?>
                
                        <option value="<?php echo $addcat['Catid']; ?>"> <?php echo $addcat['Catname'];?></option>
                        
                          <?php }?> 
                          </select>
                         
                      </div>
                     
                      <input type="submit" value="<?php if($do=='edit'){ echo 'Edit category';}else{ echo 'Add category';}?>" class="btn btn-success">
        
                  </form>
                  <?php isset($_GET['catid'])? print ('<a class="btn btn-default" href="categories.php">Cancel</a>'): print (''); ?>
                  <div class="caterror-msg"></div>
                 </div>
                 <div class="col-md-8">
        <table class="table table-resopnsive">
            <tr>
                <th>Catid</th> <th>Catname</th>  <th>Parent</th>  <th>Delete</th> <th>Edite</th>
            </tr>
            <?php foreach($cats as $cat){ 
            $parentid=$cat['Catid'];
            $childs=getallfrom('*','categories',"where Parent ={$parentid}",'','Catid','asc' );

                ?>
            <tr class="bg-primary">
                 <td><?php echo $cat["Catid"] ?> </td>
                 <td><?php echo $cat["Catname"] ?> </td> 
                 <td>Parent </td>
                
                 <td><a class="btn btn-danger"  href="?do=delete&catid=<?php echo $cat['Catid']?>"><i class="fa fa-close"></i>delete</a></td>
                 <td><a  class="btn btn-info" href="?do=edit&catid=<?php echo $cat["Catid"] ?>"><i class="fa fa-edit"></i>Edit</a></td>
               
            </tr>
            
            <?php foreach($childs as $child){ ?>
                <tr  class="bg-info" id="delete<?php echo $child['Catid'] ;?>">
                 <td><?php echo $child["Catid"] ?> </td>
                 <td><?php echo $child["Catname"] ?> </td> 
                 <td><?php echo $cat["Catname"] ?> </td>
                
                 <td><a class="btn btn-danger btn-xs"  onclick="deletebyajax(<?php echo $child['Catid']?>)"><i class="fa fa-close"></i>delete</a></td>
                 <td><a  class="btn btn-info btn-xs" href="?do=edit&catid=<?php echo $child["Catid"] ?>"><i class="fa fa-edit"></i>Edit</a></td>
               
            </tr>
           
            <?php }} ?>
            <script>
                     function deletebyajax(id){
                            if(confirm('are you sure ?')){
        
                            $.ajax({
                                url:'categories.php?do=delete',
                                type: 'GET',
                                data:{catid:id},
                                success:function (data){
                                $(".errr-msg").html(data);
                                $('#delete'+id).hide('slow');
                                },
                               
                                });};}
                    </script>
        </table>
        

        </div>
    </div>
  
</div>
    <?php 
    }elseif($do=='insert'){
        if($_SERVER['REQUEST_METHOD']== 'POST'){
            $catname=$_POST['catname'];
            $parent=$_POST['parent'];
                
            $check=checkitem("Catname","categories",$catname);
            if($check== 1){
               $theMsg='<div class="alert alert-danger"> sorry this category is exist </div>';
               redirectHome($theMsg,'back');
            }elseif( !empty($_POST['catname'])){
         //insert category to database with this info
         $stmt=$con->prepare("INSERT INTO categories ( Catname ,Parent) VALUES(:zname,:zparent )");
         $stmt->execute(array(
          'zname' => $catname,     
          'zparent' =>$parent 
           ));
         //echo succsess massage
         header('Location:categories.php');
    exit();
          
                   }else{ 
                    $theMsg= '<div class="alert alert-danger"> Sorry There Is  Error</div>';
                    redirectHome($theMsg,'back');
                   }
            }
   
    }elseif($do=='update') {
        if($_SERVER['REQUEST_METHOD']=='POST'){
            // get variable from the form
            $id    =$_POST['catid'];
            $name =$_POST['catname'];
            $parent  =$_POST['parent'];
 
           
            
          //update the database with this info
          $stmt=$con->prepare("UPDATE categories SET  Catname =? ,Parent=?  WHERE Catid=? ");
          $stmt->execute(array($name,$parent,$id));
          //echo succsess massage
         
          $theMsg= '<div vlass="alert alert-success">Recored Update</div>';
          redirectHome($theMsg);
            
    
        }else{
        $theMsg= '<div vlass="alert alert-danger">sorry you can not browes this page directry</div>';
            redirectHome($theMsg);
        
        }
    }elseif($do=='delete'){
        $catid=isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $stmt=$con->prepare("SELECT *  FROM categories WHERE Catid = ? ");
        $stmt->execute(array($catid));
        $deletcat=$stmt->fetch();
          if($deletcat['Parent']== 0){
            $stmt=$con->prepare('DELETE FROM categories WHERE Parent=:zid ' );
            $stmt->bindParam(':zid',$catid );
            $stmt->execute();
          }
        $check=checkItem('Catid','categories',$catid);
      
    if($check > 0){
        $stmt=$con->prepare('DELETE FROM categories WHERE Catid=:zid ' );
        $stmt->bindParam(':zid',$catid );
        $stmt->execute();
        $stmt->rowCount();
        header('location:categories.php');
     }else{
         $theMsg ='<div class="alert alert-danger">this id not existe</div>';
         redirectHome($theMsg);
         
     } 
    }
    include "inc/tamplate/footer.php";
}else{
  
    header('Location:index.php');
    exit();
}
ob_end_flush();
?>