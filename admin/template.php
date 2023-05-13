<?php 
ob_start();//output buffering start
/*
====================================================
==manage members page 
==you can add |edit| deletemember from here
====================================================
*/
session_start();
$pageTitle="Mempers";
if(isset($_SESSION['Username'])){
    
    include "int.php";

    $do =isset($_GET['do'])? $_GET['do']: 'manage'; 

    if ($do=='manage') {
        echo 'welcome';
    }elseif($do=='Add'){ 
    }elseif($do=='Insert'){
    }elseif($do=='Edit'){ 
    }elseif($do=='Update') {
    }elseif($do=='Delete'){
    }elseif($do=='Activate'){
    }
    include $tp1."footer.php";
}else{
  
    header('Location:index.php');
    exit();
}
ob_end_flush();
?>
<script src="<?php echo $js ?>jquery-ui.min.js"></script>
<script src="<?php echo $js ?>jquery.selectBoxIt.min.js"></script>