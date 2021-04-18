<?php
include "db_config.php";
$otp_error_msg="";
$error_msg="";
$msg="";
if(isset($_GET["code"]) && isset($_GET["msg"])){
        $otp_verification_code=$_GET["code"];
        $msg=$_GET["msg"];
        if(isset($_POST["otpBtn"])){
            if(empty($_POST["otp"])){
                $otp_error_msg='<div class="text-danger">Enter OTP</div>';
            }else{
                $otp=trim($_POST["otp"]);
                $verify_otp="select * from registration where u_activation_code='$otp_verification_code'
                AND u_otp='$otp'";
                $verify_otp_res=mysqli_query($conn,$verify_otp) or die("OTP Verification Query Failed");
                if(mysqli_num_rows($verify_otp_res)>0){
                    $update_status="update registration set u_verification_status=1 
                    where u_activation_code='$otp_verification_code'";
                    $update_status_res=mysqli_query($conn,$update_status) or die("Update Status Query Failed");
                    if($update_status_res){
                        header("Location:login.php?register=success");
                    }
                    
                }else{
                    $error_msg='<div class="text-danger">Invalid OTP!</div>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beSocial || OTP Form </title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="user-style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php echo '<div class="text-success">'.$msg.'</div>';?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Verify Your OTP</h5>
                    </div>
                    <div class="card-body">
                        <?php echo $error_msg;?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="otp">Enter Your OTP</label>
                                <input type="text" name="otp" id="otp" placeholder="123456" class="form-control">
                                <?php echo $otp_error_msg;?>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="otpBtn" id="otpBtn" value="Submit" class="btn btn-success">
                                <button class="btn btn-light">Resend OTP</button>
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