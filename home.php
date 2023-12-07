<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.2.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  
    <style>
        .header{
            position: fixed;
            background-color: #2E8B57;
            width:100%;
            height:90px;
            right:0px;
            top:0;
            box-shadow:3px 3px 3px 3px #DFFF00;
            z-index: 1;
        }

        .menu{
            position: fixed;
            box-shadow: 3px 3px 3px 3px #888888;
            width:250px;
            height:100%;
            left:0; 
        }
        div.menu ul{
            position: relative;
            top:80px;
           
            list-style: none; 
            padding:0;
           
        }
        div.menu ul li a {
            position: relative;
            text-decoration: none;
            padding:10px 14px;
            font-size: 18px;
            display:block;
        }

        div.menu ul li a:hover{
            background-color: #2E8B57;
        }

        .logout{
            position: relative;
            text-decoration: none;
            color:white;
            left:1100px;
          

        }

        .products {
    width: 80%;
    margin-left: 20%;
    background-color: white;
    overflow: auto;
}
.trolley{
    width:68px;
    height:68px;
}


       
    </style>


   <?php
      
      include 'connection.php';
      include 'auth_login.php';

       //fetching categories
      $sqlcategories="SELECT * FROM  categories ";
      $rscategories=mysqli_query($con,$sqlcategories);


      if(isset($_GET['catID']))
           $catID=$_GET['catID'];
        else
        $catID=1;  


      //fetching products
      $sqlproducts="SELECT ProductID,ProductName,UnitPrice,product_cover FROM products where CategoryID='$catID'";
      $rsproducts=mysqli_query($con,$sqlproducts);


      //fetch customers
      $usersql="SELECT * from customers where username='" . $_SESSION['logged_user'] .  "'";
      $ruser=mysqli_query($con,$usersql);
      $userfetch=mysqli_fetch_assoc($ruser);

  
   ?> 
   <title>Welcome <?php echo $userfetch['ContactName']; ?></title>
   
</head>
<body>
    <div class="container">
     
         <div class="header">
         <div><a href="view_cart.php"><img class="trolley" src="public/icons/trolley.png" alt=""></a></div>
         <DIV><div><a href="customer_logout.php" class="logout">logout</a></div> </DIV>
           
         </div>

         <div class="menu">
            <ul>
                
            <?php foreach($rscategories as $rscategory ){?>
               <li><a href="home.php?catID=<?php echo $rscategory['CategoryID']?>" ><?php echo $rscategory['CategoryName'];?></a></li>
               <?php } ?>
            </ul>
         </div>
                 


         <div class="products">
    <?php $counter = 0; ?>
    <div class="row">
        <?php foreach ($rsproducts as $product) { ?>
            <div class="col-md-3" style="width: 13rem;">
                <div class="card">
                    <?php if ($product['product_cover'] == "") { ?>
                        <img src="public/products/images/product.png" alt="" style="width: 100%; height: auto;">
                    <?php } else { ?>
                        <img src="public/products/images/<?php echo $product['product_cover']; ?>" alt="" style="width: 100%; height: auto; top: 60px;">
                    <?php } ?>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['ProductName']; ?></h5>
                        <h5 class="card-title"><?php echo $product['UnitPrice']; ?></h5>
                        <button type="button" class="productinfo btn btn-primary" data-bs-toggle="modal" data-bs-target="#product_detail" data-id="<?php echo $product['ProductID'];?>">
                            Learn more
                        </button>
                    </div>
                </div>
            </div>

            <?php
            $counter++;
            if ($counter % 4 == 0) {
                echo '</div><div class="row">';
            }
            ?>
        <?php } ?>
    </div>
</div>

     <!-- Modal -->
     <div class="modal fade" id="product_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog custom-modal" style="max-width: 600px; max-height: 100px;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>

    </div>


    <script src="https://code.jquery.com/jquery-3.6.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js"></script>
    <script>
 $(document).ready(function() {
    $('.productinfo').click(function(e) {
        e.preventDefault();
        var productID = $(this).data('id');
      

        // Make an AJAX request to get product details
        $.ajax({
            method: 'post',
            url: 'homeprocess.php',
            data: { productID: productID },
            dataType: 'html',
            success: function(data) {
                if (data.error) {
                    // Handle the error (e.g., show an error message)
                    console.error(data.error);
                } else {
                    
                    // Modify this part to display the received data
                    // For example, you can display product details in the modal
                    $('#product_detail .modal-body').html(data);

                    // Open the modal
                    $('#product_detail').modal('show');
                }
            },
            error: function(error) {
                // Handle AJAX error
                console.error(error);
            }
        });
    });
});
   </script>
</body>
</html>