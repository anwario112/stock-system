<?php
include 'connection.php';
include 'password_policy.php';
include 'encrypt.php';
session_start();

$user   =$_POST['user'];
$pass   =$_POST['pass'];
$company=$_POST['company'];
$contact=$_POST['contact'];
$title  =$_POST['title'];
$city   =$_POST['city'];
$address=$_POST['address'];
$phone  =$_POST['phone'];


$_SESSION['user']   =$user;
$_SESSION['pass']   =$pass;
$_SESSION['company']=$company;
$_SESSION['contact']=$contact;
$_SESSION['title']  =$title;
$_SESSION['city']   =$city;
$_SESSION['address']=$address;
$_SESSION['phone']  =$phone;


if(empty($user)){
    $_SESSION['msg']="Enter username";
}else{
    $sqluser="SELECT * FROM customers where username='$user'";
    $ruser=mysqli_query($con,$sqluser);

    if(mysqli_num_rows($ruser)>0)
        $_SESSION['msg']="This Username is taken";
    else if(empty($pass))
         $_SESSION['msg']="Enter password";
    else if(strlen($pass)<6)
        $_SESSION['msg']="Password should be more than 6 characters";
    else if(!chkPass($pass))
        $_SESSION['msg']="Enter one capital letter , one small letter , one symbol, and one Digit";    
    else if(empty($contact))
        $_SESSION['msg']="Enter contact Name";
    else if(empty($title))
        $_SESSION['msg']="Enter Contact title";
    else if($city=='0')
       $_SESSION['msg']="Enter city";
    else if(empty($address))
       $_SESSION['msg']="Enter Address";
    else if(empty($phone))
       $_SESSION['msg']="Enter phone number";
    else{
        $pass=encrypt($pass);
        $insert="INSERT INTO customers (CustomerID,username,password,CompanyName,ContactName,ContactTitle,CityID,Address,Phone)value('$user','$user','$pass','$company','$contact','$title','$city','$address','$phone')";

        if (mysqli_query($con, $insert)) {
            header('location:home.php');
            die();
        } else {
            $_SESSION['msg'] = "cannot save record";
        }

    }   
  }
   header('location:reg.php');
?>