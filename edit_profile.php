<?php
    include('database_connection.php');
    if(isset($_POST["user_name"])){
       if($_POST["user_new_password"] != ''){
           $query = "
           UPDATE user SET
           name = '".$_POST["user_name"]."',
           email = '".$_POST["user_email"]."',
           password = '".password_hash($_POST["user_new_password"],PASSWORD_DEFAULT)."'
           WHERE id = '".$_SESSION["user_id"]."'
           ";
       } else {
           $query = "
           UPDATE user SET
           name = '".$_POST["user_name"]."',
           email = '".$_POST["user_email"]."'
           WHERE id = '".$_SESSION["user_id"]."'
           ";
       }
       $statement = $connect->prepare($query);
       $statement->execute();
       $result = $statement->fetchAll();
       if(isset($result)){
           echo '<div class="alert alert-success">Hồ sơ đã được sửa</div>';
           $_SESSION["user_name"] = $_POST["user_name"];
       }
    }
?>