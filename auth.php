<?php
include 'connection.php';
session_start();

if(!isset($_SESSION['admin'])){
    header('location:admin_login.php');
    exit;
}

?>