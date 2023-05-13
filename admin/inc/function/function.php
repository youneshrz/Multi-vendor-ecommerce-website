<?php 
// function to get all from databas
function getallfrom($field,$table,$where=null,$and=null,$orderfield,$ordering="DESC" ){
    global $con;
   
    $getall=$con->prepare("SELECT $field FROM $table $where $and   ORDER BY $orderfield $ordering ");
    $getall->execute();
    $all=$getall->fetchAll();
    return $all;
}
//function to check item in database
function checkitem($select,$from,$value){
    global $con;
    $statement= $con->prepare("SELECT $select FROM $from WHERE $select= ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}
//redirect function 
function  redirecthome($theMsg,$url=null,$seconds=3){
    if($url== null){
        $url='index.php';
    } else{

        $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !==''? $url= $_SERVER['HTTP_REFERER']:'index.php';
        
    }
    echo $theMsg;
    echo "<div class='alert alert-info'> you will redirected to $url after $seconds seconds .</div>";
    header("refresh:$seconds;url=$url");
    exit();

}

//function to count nember in databas
function countItems($item,$table){
    GLOBAL $con;
    $stmt2= $con->prepare("SELECT COUNT($item) FROM $table");
    $stmt2->execute();
   
    return $stmt2->fetchColumn();

}
?>