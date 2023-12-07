<?php
  session_start();
  include 'connection.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
     $user=$_SESSION['admin'];
    $oldPass=$_POST['oldPass'];
    $newPass=$_POST['newPass'];
    
    $sqlpass="SELECT * FROM admin where UserName='$user' AND password='$oldPass'";
      $fetchpass=mysqli_query($con , $sqlpass);


      if(mysqli_num_rows($fetchpass)==1){

        $sql="UPDATE admin set password='$newPass' where UserName='$user'";
        if(mysqli_query($con ,$sql))
           $_SESSION['msg']="password has been changed successfully";
           else
           $_SESSION['msg']="wrong password";

      }else{
        $_SESSION['msg']="cannot change password";
      }

      header('location:change_password.php');
}

?>