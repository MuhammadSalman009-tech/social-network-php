<?php
session_start();
$error_msg="";
$user_email_error="";
$user_password_error="";
include "db_config.php";

if(isset($_POST["login"])){
    $user_email=$_POST["user_email"];
    $user_password=$_POST["user_password"];
    $salt="%salman@009%";
    if($user_email==""){
        $user_email_error='<div class="text-danger">Email is required!</div>';
    }elseif($user_password==""){
        $user_password_error='<div class="text-danger">Password is required!</div>';
    }else{
        $epassword=md5($salt.$user_password);
        $check_user="select * from registration where u_email='$user_email' and u_password='$epassword'";
        $check_user_res=mysqli_query($conn,$check_user) or die("Check User Query Failed");
        if(mysqli_num_rows($check_user_res)>0){
            $row=mysqli_fetch_assoc($check_user_res);
            $_SESSION["userID"]=$row["u_reg_id"];
            $_SESSION["userName"]=$row["u_name"];
            $last_activity=date("d-m-Y H:i:s");

            $insert="insert into login(user_id,last_activity) values('$row[u_reg_id]','$last_activity')";
            $insert_res=mysqli_query($conn,$insert) or die("Insert Query Failed");
                header("Location:home.php"); 
        }else{
            $error_msg='<div class="text-danger">User Not Found!</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beSocial || Login Form</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="user-style.css">
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Log In  Form</h5>
                    </div>
                    <div class="card-body">
                        <?php echo $error_msg;?>
                        <?php if(isset($_GET["msg"])){ echo '<div class="text-danger">'.$_GET["msg"].'</div>';}?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="email">Enter Email</label>
                                <input type="email" name="user_email" id="user_email" placeholder="Enter Your Email" class="form-control">
                                <?php echo $user_email_error;?>
                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input type="password" name="user_password" id="user_password" placeholder="Enter Your Password" class="form-control">
                                <?php echo $user_password_error;?>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="login" id="login" value="Log In" class="btn btn-success">
                                <span><a href="social-register.php">Register</a></span>
                            </div>
                            <div class="form-group">
                                <span> or <a href="#">Forgot Password?</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
</body>
</html>

