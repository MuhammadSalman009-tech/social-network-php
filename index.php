<?php
session_start();
if(isset($_SESSION["userName"])){
    header("Location:home.php");
}

include "db_config.php";
include "functions.php";

$error_msg="";
    $error_user_name="";
    $error_user_email="";
    $error_user_password="";
    $user_name="";
    $user_email="";
    $user_password="";
    $salt="%salman@009%";
if(isset($_POST["register"])){
    

    if(empty($_POST["user_name"])){
        $error_user_name='<div class="text-danger">Enter Name</div>';
    }else{
        $user_name=trim($_POST["user_name"]);
        $user_name=htmlentities($user_name);
    }

    if(empty($_POST["user_email"])){
        $error_user_email='<div class="text-danger">Enter Email</div>';
    }else{
        $user_email=trim($_POST["user_email"]);
        if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
            $error_user_email='<div class="text-danger">Enter Valid Email</div>';
        }
    }

    if(empty($_POST["user_password"])){
        $error_user_password='<div class="text-danger">Enter Password</div>';
    }else{
        $user_password=trim($_POST["user_password"]);
        $user_password=md5($salt.$user_password);
    }

    if($error_user_name=="" && $error_user_email=="" && $error_user_password==""){
        
        $createdOn=date("d m Y H:i:s am");
        $user_activation_code=md5(rand());
        $user_otp=rand(100000,999999);
        $user_varification_status=0; // 0=Not Verified , 1=Verified;
        
        $check_email="select * from registration where u_name='$user_name'";
        $check_email_res=mysqli_query($conn,$check_email) or die("Check Email Query Failed");
        if(mysqli_num_rows($check_email_res)>0){
            $error_msg='<div class="text-danger">User Already Exists!</div>';
        }else{
            $user_avatar=make_avatar($user_name[0]);
            $insert="insert into registration(u_name,u_email,u_password,
            u_activation_code,u_otp,u_verification_status,createdOn,u_avatar)
            values('$user_name','$user_email','$user_password','$user_activation_code','$user_otp','$user_varification_status','$createdOn','$user_avatar');
            ";
            $insert_res=mysqli_query($conn,$insert) or die("Insertion Query Failed");

            //sending otp mail
            require 'PHPmailer/PHPmailerAutoload.php';
            $mail=new PHPMailer;
            $mail->isSMTP();
            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            // use
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // if your network does not support SMTP over IPv6

            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;

            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';

            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;

            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "salmansumra009@gmail.com";

            //Password to use for SMTP authentication
            $mail->Password = "Faarsa009";
            $mail->SMTPDebug = 2;

            //Set who the message is to be sent from
            $mail->setFrom('salmanbawa009@gmail.com','beSocial');
            $mail->addReplyTo('salmanbawa009@gmail.com');
            //Set who the message is to be sent to
            $mail->addAddress($user_email);

            $mail->isHTML(true);

            //Set the subject line
            $mail->Subject = 'Verification Code for Your Email Address';
            
            $mail->Body='
            <p>For verify your email address, enter this verification code when prompted
<b>'.$user_otp.'</b></p>
<a href="">click here</a>
<p>Thank You</p>
<p>From beSocial</p>
            ';

            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
        // $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

            // //Replace the plain text body with one created manually
            // $mail->AltBody = 'This is a plain-text message body';

            // //Attach an image file
            // $mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            } else {
                header("Location:email-verify.php?code=".$user_activation_code." && msg=An OTP has been sent to you email address, check your inbox!");
                //Section 2: IMAP
                //Uncomment these to save your message in the 'Sent Mail' folder.
                if (save_mail($mail)) {
                    echo "Message saved!";
                }
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
    <title>beSocial || Registration Form</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="user-style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Registration Form</h5>
                    </div>
                    <div class="card-body">
                        <?php echo $error_msg;?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="name">Enter Name</label>
                                <input type="text" name="user_name" id="user_name" placeholder="Enter Your Name" class="form-control">
                                <?php echo $error_user_name;?>
                            </div>
                            <div class="form-group">
                                <label for="email">Enter Email</label>
                                <input type="email" name="user_email" id="user_email" placeholder="Enter Your Email" class="form-control">
                                <?php echo $error_user_email;?>
                            </div>
                            <div class="form-group">
                                <label for="password">Enter Password</label>
                                <input type="password" name="user_password" id="user_password" placeholder="Enter Your Password" class="form-control">
                                <?php echo $error_user_password;?>
                            </div>

                            <div class="form-group">
                                <input type="submit" name="register" id="register" value="Register" class="btn btn-success">
                                <span><a href="login.php">Log In</a></span>
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