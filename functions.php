<?php
//function for creating an initial avatar image
function make_avatar($character){
    $path="avatar/".time().".png";
    $image=imagecreate(200,200);
    $red=rand(0,255);
    $green=rand(0,255);
    $blue=rand(0,255);
    imagecolorallocate($image,$red,$green,$blue);
    $textcolor=imagecolorallocate($image,255,255,255);
    imagettftext($image,100,0,50,150,$textcolor,realpath("fonts/Roboto-Regular.ttf"),$character);
    imagepng($image,$path);
    return $path;
}

//function for getting registration table data
function get_data($uid,$conn){
    $get_data="select * from registration where u_reg_id='$uid'";
    $get_data_res=mysqli_query($conn,$get_data) or die("Get Data Query Failed");
    return $get_data_res;
}

//function for dislplaying user avatar
function get_user_avatar($conn,$uid){
    $get_img="select * from registration where u_reg_id='$uid'";
    $get_img_res=mysqli_query($conn,$get_img) or die("Avatar Query Failed");
    if(mysqli_num_rows($get_img_res)>0){
        $row=mysqli_fetch_assoc($get_img_res);
        $user_avatar=$row["u_avatar"];
        return $user_avatar;
    }
                    
}

//function for getting users whole record
function get_whole_data($uid,$conn){
    $output="";
    $get_whole="select * from registration as r inner join country as c on c.country_id=r.u_country where u_reg_id='$uid'";
    $result=mysqli_query($conn,$get_whole) or die("Get whole Query failed ");
    return $result;
}

//function for getting user profile data
function get_user_profile_data($uid,$conn){
    $output="";
    $get_all="select * from registration as r inner join country as c on c.country_id=r.u_country where u_reg_id='$uid'";
    
    $result=mysqli_query($conn,$get_all) or die("Get all Query failed ");
    if(mysqli_num_rows($result)>0){
        $row=mysqli_fetch_assoc($result);
        $output.='<div class="table-responsive">
        <table class="table">
            <tr>
                <td align="center" colspan="2">
                    <img src="'.$row["u_avatar"].'" alt="" class="rounded-circle" height="200px" width="200px">
                </td>
            </tr>
    
            <tr>
                <td>
                    Name
                </td>
                <td>
                    '.$row["u_name"].'
                </td>
            </tr>
            <tr>
                <td>
                    Date of Birth
                </td>
                <td>
                    '.$row["u_dob"].'
                </td>
            </tr>
            <tr>
                <td>
                    Gender
                </td>
                <td>
                
                    '.$row["u_gender"].'
                </td>
            </tr>
            <tr>
                <td>
                    Address
                </td>
                <td>
                    '.$row["u_address"].'
                </td>
            </tr>
            <tr>
                <td>
                    City
                </td>
                <td>
                    '.$row["u_city"].'
                </td>
            </tr>
            <tr>
                <td>
                    Country
                </td>
                <td>
                    '.$row["country_name"].'
                </td>
            </tr>
        </table>
    </div>';
    }
    return $output;
}

//bold search array
function bold_query($array){
    return "<b>".$array."</b>";
}

//function for getting request-status
function get_request_status($conn,$from_user_id,$to_user_id){
    $output="";
    $get_requset_status="select request_status from friend_request where
    (request_from_id='$from_user_id' and request_to_id='$to_user_id') or 
    (request_from_id='$to_user_id' and request_to_id='$from_user_id') and request_status!='Confirm'";

    $get_requset_status_res=mysqli_query($conn,$get_requset_status) or die("get_request_status Query Failed");
    if(mysqli_num_rows($get_requset_status_res)>0){
        $req_row=mysqli_fetch_assoc($get_requset_status_res);
        $output=$req_row["request_status"];
    }
    return $output;
}
?>



