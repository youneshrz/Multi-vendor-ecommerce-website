
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="inc/css/bootstrap.css"/>
    <link rel="stylesheet" href="inc/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="inc/css/backend.css"/>
    
    


    <title>Document</title>
</head>
<body>
    
<!--navbar 1-->
<nav class="navbar navbar-inverse navbar-fixed-top nav-2">
  <div class="container-fluid">
   
    <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
     
      <a class="navbar-brand" href="#">Titch shop</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="app-nav">
      <ul class="nav navbar-nav">
        <li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-home "></span> Dashboard <span class="sr-only">(current)</span></a></li>
        <li><a href="members.php">Members</a></li>
        <li><a href="categories.php">Category</a></li>
        <li><a href="items.php">Items</a></li>
        <li><a href="comments.php">Comments</a></li>
        <li><a href="carts.php">Carts</a></li>
        




      </ul>
      
     
      
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
    <!-- end navbar 1-->
    <br><br>
  <nav>
  <div class="my-info">
            
             <div class='btn-group center-block   '>
             <img class="img-thumbnail img-sircle my-img img-responsive " src="../images/png.png" alt="" />
   
                     <span class='btn btn-warning dropdwn-toggle btn-info pull-right' data-toggle="dropdown">
                   <?php echo $_SESSION['admin']; ?>
                     
                     <span class="caret"></span>
                     </span>
                       <ul class="dropdown-menu" style="background: repeating-radial-gradient(#8dbce2, #3F51B5 100px);">
                         <li><a href="profile.php"><i class="fa fa-id-card"></i> My Profile</a></li>
                         <li><a href="newad.php"><i class="fa fa-plus"></i> New Item</a></li>
                         <li><a href="profile.php#my-ads"> <i class="fa fa-product-hunt"></i> My Item</a></li>
                         <li><a href="../index.php"><i class="fa fa-shopping-bag"></i> Go to shop</a></li>
                         <li><a href="../logout.php"><i class="glyphicon glyphicon-log-out"></i> Logout</a></li>
                       </ul>
                  </div>
             </div>
  </nav>
<hr class="div">


