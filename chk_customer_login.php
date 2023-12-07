<?php
include 'connection.php';
include 'encrypt.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){

     $pass =$_POST['pass'];
     $user=$_POST['user'];

    $_SESSION['user']=$user;

    if(empty($user)){
        $_SESSION['msg']="Enter your username";
    }else
       if(empty($pass)){
          $_SESSION['msg']="Enter Password";
       }else{
          $customerlogin="SELECT * FROM customers where username='$user' AND password='$pass'";
          $custresult=mysqli_query($con,$customerlogin);

          $cust=mysqli_num_rows($custresult);

          if($cust == 0){
            $_SESSION['msg']="Invalid username";
          }else{
            $ruser=mysqli_fetch_assoc($custresult);
            if($ruser['password'] != $pass){
                $_SESSION['msg']="Incorrect password";
            }else{
              $_SESSION['logged_user']=$user;
                header('location:home.php');
                die();
            }
          } 
             
       }
       header('location:customer_login.php');
}

?>