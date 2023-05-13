<?php

    $pageno =$_POST['pageno'];

    $no_of_records_per_page = 3;
    $offset = ($pageno-1) * $no_of_records_per_page;

    include '../connect.php';
  
    
    $stmt=$con->prepare("SELECT 
            carts.*,users.Username as member,products.*
        from  
            carts

        inner join
        users
        on
        users.Userid=carts.user_id
        inner join
        products
        on
        products.Proid=carts.pro_id
        LIMIT  $offset,$no_of_records_per_page  ");
    $stmt->execute();
    $carts=$stmt->fetchAll();
   
    ob_start();
    if(!empty($carts)){
   ?>

        <table class='main-table text-center table table-bordered'>
                        <tr>
                            <td>#ID</td>
                            <td>Product</td>
                            <td> Name</td>                         
                            <td>Quantity</td>
                            <td>Price Total</td>
                            <td>Username</td>
                            <td> DATE</td>
                            <td>CONTROLE</td>
                            
                        </tr>
                        <?php
                        foreach($carts as $cart){
                            echo "<tr  id='delete ".$cart['Cartid']." '>";
                            echo "<td>" . $cart['Cartid'] . "</td>";
                            echo "<td><img class='img-responsive avatar' src='upload/img/".$cart['Proimg1']."'> </td>";
                            echo "<td>" . $cart['Proname'] . "</td>";                          
                            echo "<td>" . $cart['qnty'] . "</td>";
                            echo "<td>" . $cart['Price'] . "</td>";
                            echo "<td>" . $cart['member'] . "</td>";
                            echo "<td>"  . $cart['Date'] . "</td>";
                            echo "<td>
                                     
                                      <a  onclick='deletebyajax(". $cart['Cartid'].")' class='btn btn-danger confirm'><i class='fa fa-close'></i>DELETE</a>";
                                   
                            echo  "</td>";
                            echo "</tr>";
                        }
                        ?>                  
                </table>
                </div>

    

   
<?php
    }
echo ob_get_clean();
                    
?>