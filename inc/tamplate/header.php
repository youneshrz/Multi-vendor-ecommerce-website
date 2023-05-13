
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="inc/css/bootstrap.css"/>
<!--<link rel="stylesheet" href="inc/css/font-awesome.min.css"/>-->
<link rel="stylesheet" href="inc/fontawesome-free-5.15.1-web/css/all.min.css"/>
<link rel="stylesheet" href="inc/css/swiper-bundle.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
<!-- Animate On Scroll -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link rel="stylesheet" href="inc/css/front.css"/>
    <title> <?php echo $title; ?> </title>
</head>
<body>
    
<!--navbar 1-->
<nav class="navbar navbar-inverse navbar-fixed-top nav-2">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand"  >Titch shop</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home "></span> HOME <span class="sr-only">(current)</span></a></li>
       <?php 
       
        $cats= getallfrom('*','categories','where Parent=0','','Catid','asc') ;
       foreach($cats as $cat){
         ?>
        <li><a href="categories.php?pageid=<?php echo $cat['Catid']; ?>"><?php echo $cat['Catname']; ?></a></li>
        
       <?php } ?>
      </ul>
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <!-- end navbar 1-->
    
    <!-- start navbar 2-->
        <div class="secand_nav container-fluid ">
          <div class="row">
            <div class="col-sm-6">
          <form action="search.php" method="GET">
            <div class="search_nav form-inline ">
                <input class="search form-control form-control-sm" name="search" type="search"><button class="btn btn-info" type="submit"><i class="fa fa-search"></i>
                </button>
            </div>
          </form>
            </div>
            <div class="col-sm-6">
            <div class="icon_nav form-inline  ">
              
              <button class="btn btn-outline-info card"><a  href="cart.php"><i class="fa fa-shopping-cart"></i></a><span class="total_card"><?php    
                   if(isset($_SESSION['user'])){ $stmt2= $con->prepare("SELECT COUNT(Cartid) FROM carts WHERE user_id={$_SESSION['uid']} and status=0 ");
                      $stmt2->execute();
                      
                     echo $numcart= $stmt2->fetchColumn();
                          }else{echo 0;}
                       ?></span></button>

              <?php 
               if(isset($_SESSION['user'])){
                $stmt2= $con->prepare("SELECT Avatar FROM users WHERE Userid={$_SESSION['uid']}");
                $stmt2->execute();
                $img=$stmt2->fetch();
                 if(empty($img['Avatar'])){
                 ?>
              <img class="img-thumbnail img-sircle my-img" src="images/png.png" alt="" />
             <?php 
                 }else{ ?>
                  <img class="img-responsive img-thumbnail img-circle " src="admin/upload/avatars/<?php echo $img['Avatar']; ?> ">
               <?php  }
             ?>
              <div class='btn-group my-info '>
    
                      <span class='btn btn-primary dropdwn-toggle'style="
                                  background-color: darkgrey;
                                  border: groove" data-toggle="dropdown">
                    <?php echo $_SESSION['user'] ;?>
                      
                      <span class="caret"></span>
                      </span>
                        <ul class="dropdown-menu drp-menu">
                          <li><a href="profile.php"><i class="fa fa-id-card"></i> My Profile</a></li>
                          <li><a href="profile.php#my-ads"><i class="fa fa-dolly-flatbed"></i> My Item</a></li>
                          <li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                        </ul>
                    
              </div>
              <?php }else{ ?>
                <a href="login.php"><span class="btn btn-default pull-right " id="link-login"><i class="glyphicon glyphicon-log-out"></i> Login-Signup</span></a>

              <?php }?>
              </div> 
            </div>
          </div>
  </div> 
       <!-- end navbar 2-->
<hr class="div">


