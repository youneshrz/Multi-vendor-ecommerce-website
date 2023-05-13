<?php 
include '../connect.php';
include 'inc/function/function.php';

$parentid=(int)$_POST['keyname'];
$childid=(int)$_POST['selected'];

$childs=getallfrom('*','categories',"where Parent ={$parentid}",'','Catid','' );
ob_start(); ?>

<option value=""></option>
<?php foreach($childs as $child){ ?>
    <option value="<?php echo $child['Catid']?>" <?= (($childid == $child['Catid'])?  'selected':'') ?>><?php echo $child['Catname']?></option>

<?php } ?>
<?php echo ob_get_clean(); ?>