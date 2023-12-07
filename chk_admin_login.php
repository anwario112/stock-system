<?php
    session_start();
    include 'connection.php';
if($_SERVER['REQUEST_METHOD']=="POST"){

    $user=$_POST['user'];
    $pass=$_POST['pass'];

    $sqllogin="SELECT * from admin where username='$user' AND password='$pass'";

    $fetch=mysqli_query($con,$sqllogin);

    if(mysqli_num_rows($fetch) == 1){
        $_SESSION['admin']=$user;

        header('location:dashboard.php');
        
    }else{
        $_SESSION['msg']="invalid user or pass";
        $_SESSION['user']=$user;

        header('location:admin_login.php');
    }
}


?>