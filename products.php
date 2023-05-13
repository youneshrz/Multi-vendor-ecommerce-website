<?php 
ob_start();//output buffering start
session_start();

include 'init.php'; 
$itemid=isset($_GET['itemid']) &&  is_numeric($_GET['itemid'])?intval($_GET['itemid']):0;
       
$stmt=$con->prepare("SELECT products.*,categories.Catname,categories.Catid,users.Username  FROM products
                    INNER JOIN categories
                    ON categories.Catid=products.category
                    INNER JOIN users
                    ON users.Userid=products.Username
                    WHERE Proid = ? AND Approve =1 ");
$stmt->execute(array($itemid));
$item=$stmt->fetch();
$count=$stmt->rowCount();
    if($count>0){
        $views=$item['Views']+1;
        $stmtt=$con->prepare("UPDATE products SET Views={$views} where Proid={$itemid} ");
        $stmtt->execute();
        ?>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 centent-left">
                    <div class="product__pictures">
                        <div class=" col-md-3 pro-img">
                            <div class=" pictures__container">
                                <img class="picture img-responsive" src="admin/upload/img//<?php echo $item['Proimg1'];  ?>" id="pic1" />
                            </div>
                            <div class=" pictures__container">
                                <img class="picture img-responsive" src="admin/upload/img//<?php echo $item['Proimg2'];  ?>" id="pic2" />
                            </div>
                            <div class=" pictures__container">
                                <img class="picture img-responsive" src="admin/upload/img//<?php echo $item['Proimg3'] ; ?>" id="pic3" />
                            </div>
                            <div class=" pictures__container">
                                <img class="picture img-responsive" src="admin/upload/img//<?php echo $item['Proimg4'] ; ?>" id="pic4" />
                            </div>
                            <div class=" pictures__container">
                                <img class="picture img-responsive" src="admin/upload/img//<?php echo $item['Proimg5'] ; ?>" id="pic5" />
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="product__picture" id="product__picture">                   
                                <div class="picture__container">
                                    <img class="img-responsive " src="admin/upload/img//<?php echo $item['Proimg1']  ?>" id="pic" />
                                </div>
                            </div>
                            <div class="zoom" id="zoom"></div>
                        </div>   
                    </div>   
                    <div class="product-details__btn">
                        <a  onclick="addtocart(<?php echo $item['Proid'];  ?>)"  class="add" >
                            <span>
                                <i class="fa fa-cart-plus"></i>
                            </span>
                                ADD TO CART
                        </a>
                        <a class="buy" href="#">
                            <span>
                                <i class="fa fa-money-check-alt"></i>
                            </span>
                                BUY NOW
                        </a>
                    </div>
                        <br>
                    <div id="error-mms"></div>
                        <script>
                                     
                        </script>
                </div>
                <div class="col-md-6  center-block">
                    <div class="detail-right container">
                        <div class="detail" >
                            <h1><?php echo $item['Proname']  ?></h1><strong class="views"><?php echo $views; ?> veiws</strong>
                            <h2 class="price">$<?php echo $item['Price']  ?></h2>

                            <?php  ///start rating ///////////////////////////////////////////////////////////
                            $stmmmt=$con->prepare( " SELECT  count(Rating) as 'number_rat', round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$item['Proid']} ");
                            $stmmmt->execute();
                            $getrats=$stmmmt->fetchAll();
                            foreach($getrats as $g7){
                                $number_user_rating=$g7['number_rat'] ;
                                $moyenn_rating=$g7['rating'] ;    
                                }
                                ?>
                            <div class="rating">
                                <div class="rating_content">
                                    <div id="rateYo" ></div>
                                    <input type="hidden" value="">
                                    <div class="counter">
                                        (Average <div id="moyenn-rat"> <strong><?php echo  $moyenn_rating ; ?> </strong> </div>
                                        Rating Based  <div id="total-rat"> <strong> <?php echo "  ".  $number_user_rating  ." " ; ?> </strong></div>
                                        on rating)
                                    </div>
                                </div> 
                            </div>
                            <div class="quntity mar form-group">
                                <label for="">Quantity :</label>
                                <span class="mins-btn"><i></i></span>
                                <input class="form-control" type="number" min="1" value="1" max="<?php echo $item['Qnty']  ?>" class="counter-btn">
                                <span class="plus-btn"><i></i></span>
                            </div>
                            <div class="price-total mar">
                                <label for=""> price total :</label>
                                <span>$250</span>
                            </div>
                            <div class="brand mar">
                                <label for=""> brand :</label>
                                <span><?php echo $item['Brand']  ?></span>
                            </div>
                            <div class="categoryy mar">
                                <label for=""> catrgories :</label>
                                <span><a href="categories.php?pageid=<?php echo $item['Catid'] ?>"><?php echo $item['Catname']  ?></a></span>
                            </div>
                            <div class="stock mar">
                                <label for="">Availability : </label>
                                <span>In Stock (<?php echo $item['Qnty']  ?> Items)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<br><br>
        <!-- start description-->
        <div class="product-detail__bottom">
            <div class="title_ container tabs">
                <div class="row back text-center">
                    <div class="col-md-4 cut">
                        <div class="section__titles category__titles ">
                            <div class="section__title detail-btn active" data-id="description">                       
                                <h1 class="primary__title"> <i class="fa fa-list-ul">  <span class="dot"></span></i> Description</h1>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4 cut">
                    <div class="section__titles">
                        <div class="section__title detail-btn" data-id="comments">                      
                            <h1 class="primary__title"><i class="fa fa-comments"><span class="dot"></span></i> Comments</h1>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 cut">
                    <div class="section__titles">
                        <div class="section__title detail-btn" data-id="shipping">              
                            <h1 class="primary__title"> <i class="fa fa-align-left"><span class="dot"></span></i> Shipping Details</h1>
                        </div>
                    </div>
                </div>
            </div>              
            <div class="detail__content">
                <div class="content active" id="description">
                    <p><?php echo $item['Description']  ?></p>
                </div>
                <div class="content" id="comments">
                    <!--start add comment-->
                        <?php
                        if(isset($_SESSION['user'])){ ?>
                            <div class="row">
                                <div class=" ">
                                    <div class="add-comment">
                                        <h3>Add your Comment</h3>
                                        <form class="insComment"  action="<?php echo $_SERVER['PHP_SELF'] .'?itemid=' . $item['itemID']?>" method="POST" >
                                            <textarea  required="required" class="form-control" name="comment" > </textarea>
                                            <input type="hidden" name="proid" value="<?php echo $item['Proid']; ?>">
                                            <br>
                                            <input class="btn btn-primary" type="submit" value="Add Comment" >
                                        </form>
                                        <div class="msg-error text-center center-block"></div>
                                    </div>
                                </div>
                            </div>
                            <?php  
                        }else{
                            echo '<a  href="login.php"> <strong> Login Or Register </strong> </a>  To Add Comment';
                        }                       
                        //<!--fin comments-->
                        $stmt=$con->prepare("SELECT 
                                                    comments.*,users.Username as member ,users.Avatar
                                            from  
                                                    comments
                                            
                                            inner join
                                                    users
                                            on
                                                    users.Userid=comments.userid
                                            WHERE proid =? AND Statuss=1  ORDER BY Cid DESC");
                        $stmt->execute(array($item['Proid']));
                        // assign to variable
                        $comments=$stmt->fetchAll();
                        foreach($comments as $comment){ ?>
                            <div class ="comment-box">
                                <div class="row rows">
                                    <hr>
                                    <div class="col-sm-2 col-md-4 text-center grid ">
                                        <?php
                                        if(!empty($comment['Avatar'])){ ?>
                                            <img class="img-responsive img-thumbnail img-circle center-block avatar" src="admin/upload/avatars/<?php echo $comment['Avatar']; ?> "> <?php echo $comment['member']; ?>
                                            <?php
                                        }else{ ?>
                                            <?php echo $comment['member']; ?><img class="img-responsive img-thumbnail img-circle  avatar" src="images/png.png ">
                                            <?php
                                        } ?>
                                    </div>
                                    <div class="col-sm-10 col-md-8">
                                        <p class="lead"> <?php echo $comment['Comment']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <hr class="custom-hr">                      
                            <?php
                        }   ?>
                </div>
                <div class="content" id="shipping">
                <h3>Returns Policy</h3>
                    <p>You may return most new, unopened items within 30 days of delivery for <br> a full refund. We will also pay
                    the return shipping costs if the return is a result of our errorbt
                    (you received an incorrect or defective
                    item, etc.).</p>
                    <p>You should expect to receive your refund within four weeks of giving your package to the return
                        shipper, however, in many cases you will receive <br> abstract refund more quickly. This time period includes the
                        transit time for us to receive your return from the shipper (5 to 10 business days), the time it takes
                        us to process your return once we receive  <br> it (3 to 5 business days), and the time it takes your bank to
                        process our refund request (5 to 10 business days).
                    </p>
                    <p>If you need to return an item, simply login to your account, view the order using the 'Complete
                        Orders' link under the My Account menu and click the Return Item(s) button. We'll notify you via
                        e-mail of your refund once we've received and processed the returned item.
                    </p>
                    <h3>Shipping</h3>
                    <p>We can ship to virtually any address in the world. Note that there are restrictions on some products,
                        and some products cannot be shipped to international destinations.</p>
                    <p>When you place an order, we will estimate shipping and delivery dates for you based on the
                        availability of your items and the shipping options you choose. Depending on the shipping provider you
                        choose, shipping date estimates may appear <br> on the shipping quotes page.
                    </p>
                    <p>Please also note that the shipping rates for many items we sell are weight-based. The weight of any
                        such item can be found on its detail page. To reflect the policies of the shipping companies we use, all
                        weights will be rounded up to the next full pound.
                    </p>
                </div>
            </div>
        </div>
<!-- fin description-->
<br>
<hr>
<!-- start sub products-->
        <div class="container">          
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Sumilair Products</h3>
                </div>
            <div class="panel-body">
                <div class="row">
                <?php 
                    $sim_child=$item['Child'];
                    $stmtx=$con->prepare("SELECT * from products where Child ={$sim_child} and Approve=1 LIMIT 4");
                    $stmtx->execute();
                    $sims=$stmtx->fetchAll();
                    foreach($sims as $sim){
                        $stmmmt=$con->prepare( " SELECT round(avg(Rating),2) as 'rating'  from rating where  Pro_id={$sim['Proid']} ");
                        $stmmmt->execute();
                        $getrat=$stmmmt->fetch();
                    ?>
                        <div class=" col-sm-6 col-md-3  text-center margintop_pro" >
                            <a href="products.php?itemid=<?php echo $sim['Proid'] ?>">
                            <div><img class="img-responsive" src="admin/upload/img/<?php echo $sim['Proimg1']; ?>" alt=""></div>
                            <div class="titel_pro"><h2><?php echo $sim['Proname']; ?></h2></div>
                            <div><span class="price_sup">$<?php echo $sim['Price']; ?></span></div>
                                    <div  id="stars"><span><i class="glyphicon glyphicon-star"></i> <strong><?php  if(!empty( $getrat['rating'])){ echo $getrat['rating'];}else{echo 'non' ;} ?></strong> </span><span class="date_pro">in Stock(<?php  echo $sim['Qnty']  ?>)</span></div>
                            </a>
                                    <div id="product_btns" ><a  onclick="buy(<?php echo $sim['Proid'];  ?>)"> <button class="product__btn">Buy</button></a>
                        <a onclick="addtocart(<?php echo $sim['Proid'];  ?>)"> <button class="product__btn"> Add To cart</button></a>
                        </div>
                    </div>
                    <?php
                    } ?>
                </div>
            </div>
        </div>
        </div>
<!-- fin sub products--> 
<?php
    }else{
    echo "<div class='alert alert-info'>There Is No Id To Show Any Product !</div>";
    }

include 'inc/tamplate/footer.php'; 
?>
<script>
    var rat=<?php  if(empty($moyenn_rating)){echo 0; }else{echo $moyenn_rating ;} ; ?>;
    var proid=<?php echo $item['Proid'] ; ?>;
    $(function () {
        $("#rateYo").rateYo({  
            rating: rat,
            halfStar: true,
            //precision: 0,
            starWidth: "40px",
        
        onChange: function (rating, rateYoInstance) {   
            $(this).next().val(rating);
        }

        });
        $("#rateYo").click(function() {
                rating=$(this).next().val();
            $.ajax({
                url:'rating.php',
                type:'POST',
                data:{proid:proid,rat:rating},
                dataType: 'json',
                success:function(data){
                //console.log(data.info);
                //console.log(data);
                $('#total-rat').text(data.number_user_rating);
                $('#moyenn-rat').text(data.moyenn_rating);

                },
                error:function(data){
                    alert("Please try again");
                }
            });
        });
    });

</script>
<?php
ob_end_flush();
?>