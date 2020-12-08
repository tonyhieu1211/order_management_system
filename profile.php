<?php
    include('database_connection.php');
    if(!isset($_SESSION['role'])){
        header("location:login.php");
    }

    $query = " SELECT * FROM user
               WHERE id = '".$_SESSION["user_id"]."'
               ";
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $name = '';
    $email = '';
    $user_id = '';
    foreach ($result as $row) {
        $name = $row["name"];
        $email = $row["email"];
    }

    include ('header.php');
    ?>
    <div class="panel panel-default">
    <div class="panel-heading">Sửa hồ sơ</div>
        <div class="panel-body">
            <form method="post" id="edit_profile_form">
                <span id="message"></span>

                <div class="form-group">

                    <label>Tên:</label>
                    <input type="text" name="user_name" value="<?php echo $name; ?>" class="form-control" id="user_name" required/>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="user_email" value="<?php echo $email;?>" class="form-control" id="user_email" required/>
                </div>
                <label>Để trống mật khẩu nếu bạn không muốn thay đổi</label>
                <div class="form-group">
                    <label>Mật khẩu mới:</label>
                    <input type="password" name="user_new_password" class="form-control" id="user_new_password">
                </div>
                <div class="form-group">
                    <label>Nhập lại mật khẩu:</label>
                    <input type="password" name="re_enter_password" class="form-control" id="re_enter_password">
                    <span id="error_password"></span>
                </div>
                <div class="form-group">
                    <input type="submit" name="edit_prfile" id="edit_prfile" value="Edit" class="btn btn-info">
                </div>
            </form>

        </div>
    </div>

<script>
    $(document).ready(function () {
        $('#edit_profile_form').on('submit', function (event) {
            event.preventDefault();
            if($('#user_new_password').val() != ''){
                if($('#user_new_password').val() != $('#re_enter_password').val()){
                    $('#error_password').html('<label class="text-danger">Mật khẩu không khớp</label>');
                } else {
                    $('#error_password').html('');
                }
            }
            $('#edit_prfile').attr('disabled','disabled');
            var form_data = $(this).serialize();
            $.ajax({
                url:"edit_profile.php",
                method:"POST",
                data:form_data,
                success:function (data) {
                    $('#edit_prfile').attr('disabled',false);
                    $('#user_new_password').val('');
                    $('#re_enter_password').val('');
                    $('#message').html(data);

                }
            })


        });
    });
</script>