<?php
  
  include 'connection.php';
  session_start();

if($_SERVER['REQUEST_METHOD']=='POST'){
  $productName=$_POST['productName'];
  $SupplierID=$_POST['SupplierID'];
  $CategoryID=$_POST['CategoryID'];
  $quantityPerUnit=$_POST['quantityPerUnit'];
  $unitPrice=$_POST['unitPrice'];
  $unitsInStock=$_POST['unitsInStock'];
  $unitsOnOrder=$_POST['unitsOnOrder'];
 
  
  $targetDir='public/products/images/';
  $targetFile=$targetDir . basename($_FILES['productImage']['name']);
  

  if(move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)){
    $uploadImage=basename($_FILES['productImage']['name']);
       
    $sql="INSERT INTO products (productname,supplierID,categoryID,quantityPerUnit,unitPrice,unitsInStock,unitsOnOrder,product_cover)VALUE('$productName','$SupplierID','$CategoryID','$quantityPerUnit','$unitPrice','$unitsInStock','$unitsOnOrder','$uploadImage')";
          
          if(mysqli_query($con,$sql))
              $_SESSION['msg']="Record has been add successfully";
              else
              $_SESSION['msg']="failed to insert";


  }else{
    $_SESSION['msg']="invalid image";
  }

  header('location: addproduct.php');



}

  


?>