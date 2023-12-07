<?php

include 'connection.php';
session_start();

$sqluser = "SELECT CustomerID FROM customers WHERE username='" . $_SESSION['logged_user'] . "'";
$rsuser = mysqli_query($con, $sqluser);
$rUser = mysqli_fetch_assoc($rsuser);

$catID = $rUser['CustomerID'];
      //productID
     $productID=$_GET['PID'];

      //fetch price
$sqlproduct = "SELECT UnitPrice FROM products WHERE ProductID='$productID'";
$rsproduct = mysqli_query($con, $sqlproduct);
$rproduct = mysqli_fetch_assoc($rsproduct);

       $price=$rproduct['UnitPrice'];

       $Insert="INSERT INTO cart(customer_id,product_id,price,qty)Value('$catID','$productID','$price','1')";

       if($rsInsert-mysqli_query($con,$Insert)){
        header('location:home.php');
       }else{
        echo 'cannot insert the records';
       }

    


?>