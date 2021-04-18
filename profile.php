<?php
include "header.php";
$profile_error_msg="";
if(isset($_POST["update"])){
    if(!empty($_POST["user_name"])){
        if(isset($_FILES["user_avatar"]["name"])){
            $upload_ok=1;
                $file_name=$_FILES["user_avatar"]["name"];
                $file_tmpname=$_FILES["user_avatar"]["tmp_name"];
                $file_size=$_FILES["user_avatar"]["size"];
                
                $file_type=strtolower(pathinfo($file_name,PATHINFO_EXTENSION));
                $file_path="avatar/".time().".".$file_type;
            
            
                //checking file type
                if($file_type!="png" && $file_type!="jpg" && $file_type!="jpeg"){
                    $profile_error_msg='<div class="alert alert-danger">Only JPG, PNG, JPEG Images Allowed!</div>'; 
                    $upload_ok=0;
                }
            
                //checkin file size
                if($file_size>2097152){
                    $profile_error_msg='<div class="alert alert-danger">Image size should less than 2MB!</div>';
                    $upload_ok=0;
                }
            
                if($upload_ok==1){
                   
                    move_uploaded_file($file_tmpname,$file_path) or die("file not uploaded");
                    $user_avatar=$file_path;
                        
                    
                }
        }else{
            $user_avatar=$_POST["hidden_user_avatar"];
        }

        if($profile_error_msg==""){
            $update_record="update registration set u_name='$_POST[user_name]' , u_avatar='$user_avatar' ,
                        u_dob='$_POST[user_dob]' , u_gender='$_POST[user_gender]' , u_address='$_POST[user_address]' , 
                        u_city='$_POST[user_city]' , u_country='$_POST[user_country]' where u_reg_id='$_POST[user_reg_id]'";
                        
                        mysqli_query($conn,$update_record) or die("Update Record Query Failed");
                        header("Location:profile.php?action=view&&success=1");
        }

    }else{
        $profile_error_msg='<div class="alert alert-danger">User name is required.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beSocial || User Profile</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row mt-80">
            <div class="col-md-9">
                <?php
                    if(isset($_GET["action"])){
                        if($_GET["action"]=="view"){
                            if(isset($_GET["success"])){
                                echo '<div class="alert alert-success">Profile updated successfully!</div>';
                            }
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 class="card-title">User Profile</h5>
                                            </div>
                                            <div class="col-md-3" align="right">
                                                <a href="profile.php?action=edit" class="btn btn-primary btn-sm" >Edit</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            echo get_user_profile_data($_SESSION["userID"],$conn);
                                        ?>
                                    </div>
                                </div>
                            <?php
                        }//action==view end

                        if($_GET["action"]=="edit"){
                            ?>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <h5 class="card-title">Edit Profile</h5>
                                            </div>
                                            <div class="col-md-3" align="right">
                                                <a href="profile.php?action=view" class="btn btn-primary btn-sm" >View</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <?php
                                            echo $profile_error_msg;
                                            $result=get_data($_SESSION["userID"],$conn);
                                            if(mysqli_num_rows($result)>0){
                                                $row=mysqli_fetch_assoc($result);
                                                ?>
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_name">Name</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $row["u_name"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_dob">Date of Birth</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="date" name="user_dob" id="user_dob" class="form-control" value="<?php echo $row["u_dob"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_gender">Gender</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <select name="user_gender" id="user_gender" class="form-control">
                                                                    <?php
                                                                    $male="";
                                                                    $female="";
                                                                    if($row["u_gender"]=="Male"){
                                                                        $male="selected";
                                                                        $female="";
                                                                    }
                                                                    if($row["u_gender"]=="Female"){
                                                                        $female="selected";
                                                                        $male="";
                                                                    }
                                                                    ?>
                                                                    <option value="Male" <?php echo $male?>>Male</option>
                                                                    <option value="Female" <?php echo $female?>>Female</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_address">Address</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" name="user_address" id="user_address" class="form-control" value="<?php echo $row["u_address"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_city">City</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" name="user_city" id="user_city" class="form-control" value="<?php echo $row["u_city"]?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_country">Country</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <select name="user_country" id="user_country" class="form-control">
                                                                    <?php
                                                                    $get_country="select * from country";
                                                                    $get_country_res=mysqli_query($conn,$get_country);
                                                                    if(mysqli_num_rows($get_country_res)>0){
                                                                        while($c=mysqli_fetch_assoc($get_country_res)){
                                                                            if($row["u_country"]==$c["country_id"]){
                                                                                $select="selected";
                                                                            }else{
                                                                                $select="";
                                                                            }
                                                                            echo '<option value="'.$c["country_id"].'" '.$select.'>'.$c["country_name"].'</option>';
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                            <label for="user_profile">Profile</label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="file" name="user_avatar" id="user_avatar">
                                                            </div>
                                                            <?php
                                                                $get_img="select * from registration where u_reg_id='$_SESSION[userID]'";
                                                                $get_img_res=mysqli_query($conn,$get_img) or die("Avatar Query Failed");
                                                                if(mysqli_num_rows($get_img_res)>0){
                                                                    $a=mysqli_fetch_assoc($get_img_res);
                                                                    $user_avatar=$a["u_avatar"];
                                                                }
                                                            ?>
                                                            <img src="<?php echo $user_avatar?>" alt="" width="80px" height="80px" class="rounded-circle">
                                                            <br>
                                                            <input type="hidden" name="hidden_user_avatar" value="<?php echo $row["u_avatar"]?>">
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-2">
                                                        </div>
                                                        <div class="col-md-3" align="right">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group mt-20">
                                                            <?php
                                                            $result1=get_data($_SESSION["userID"],$conn);
                                                            if(mysqli_num_rows($result1)>0){
                                                                $row1=mysqli_fetch_assoc($result1);
                                                            ?>
                                                                <input type="hidden" name="user_reg_id" value="<?php echo $row1["u_reg_id"]?>">
                                                                <?php }?>
                                                                <input type="submit" value="Update" class="btn btn-primary btn-sm" name="update">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>
                                                    </div>
                                                </form>
                                                <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            <?php
                        }//action==edit end
                    }

                ?>
            </div>
            <div class="col-md-3">

            </div>
        </div>
    </div>
</body>
</html>