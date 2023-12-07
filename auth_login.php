<?php  
session_start();
include 'connection.php';


if(!isset($_SESSION['logged_user'])){
  
    header('location:customer_login.php');
    die();

}

?>