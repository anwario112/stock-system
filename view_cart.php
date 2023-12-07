<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      


    <?php
    include 'connection.php';
    session_start();
    
    if (!isset($_SESSION['logged_user'])) {
        header('location:customer_login.php');
        die();
    }

    $user = $_SESSION['logged_user'];
    $sqlUser = "SELECT * FROM customers WHERE username='$user'";
    $rsUser = mysqli_query($con, $sqlUser);
    $rUser = mysqli_fetch_assoc($rsUser);
    

    $sqlcart = "SELECT ProductName, product_cover,UnitPrice, price, qty,UnitPrice*qty as tot FROM products
    INNER JOIN cart ON cart.product_id = products.ProductID
    WHERE customer_id='" . $rUser['CustomerID'] ."'";

    $rscart = mysqli_query($con, $sqlcart);
    ;
    ?>
</head>
<body>
     <div class="container">
        <div class="t">

        <table class="table">
  <thead>
    <tr>
      
      <th scope="col">ProductName</th>
      <th scope="col">Price</th>
      <th scope="col">Qty</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
  <?php $Gtot = 0;
  while($rcart = mysqli_fetch_assoc($rscart)) { ?>
        <tr>
            <td><?php echo $rcart['ProductName']; ?></td>
            <td><?php echo '$' .number_format($rcart['UnitPrice'],2); ?></td>
            <td><?php echo $rcart['qty']; ?></td>
            <td align="right"><?php echo '$' . number_format($rcart['tot'],2); ?></td>
        </tr>
        <?php $Gtot += $rcart['tot'];
    } ?>
  </tbody>
</table>

     </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>