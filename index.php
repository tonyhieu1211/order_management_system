<?php
    include ('database_connection.php');
    if(!isset($_SESSION["role"])){
        header("location:login.php");
    }

    include ('header.php');
?>