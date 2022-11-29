<?php 

session_start();

if (!isset($_SESSION['user'])) {
    header("Location:login.php");
}

session_destroy();
header("Location:login.php")

?>