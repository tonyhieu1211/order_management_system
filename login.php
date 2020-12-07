<?php
    include ('database_connection.php');
    if(isset($_SESSION['type'])){
        header("location:index.php");
    }

    $message = '';
    if(isset($_POST["login"])){
        $query = "SELECT * FROM user 
                  WHERE email = :user_email";
        $statement = $connect->prepare($query);
        $statement->execute(
                array(
                    'user_email' => $_POST["user_email"]
                )
        );
        $count = $statement->rowCount();
        if($count > 0){
            $result = $statement->fetchAll();
            foreach ($result as $row){

                if($_POST["user_password"] == $row["password"]){
                    $message = "Right pass";
                    if($row["status"] == 'Hoạt động'){
                        $_SESSION["role"] = $row["role"];
                        $_SESSION["user_id"] = $row["id"];
                        $_SESSION["user_name"] = $row["name"];
                        header("location:index.php");
                    }else{
                        $message = "<label>Tài khoản của bạn đã bị khoá.Liên lạc Admin để mở khoá.</label>";
                    }
                } else {
                    $message = "Wrong pass";
                }
            }
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lý đơn hàng</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <div class="container">
        <h2 align="center">Quản lý đơn hàng</h2>
        <br>
        <div class="panel panel-default">
            <div class="panel-heading">Đăng Nhập</div>
            <div class="panel-body">
                <form method="post">
                    <?php echo $message;?>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="user_email" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Mật Khẩu</label>
                        <input type="password" name="user_password" class="form-control" required/>
                    </div>
                    <div class="form-group">

                        <input type="submit" name="login" value="Login" class="btn btn-info" required/>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>