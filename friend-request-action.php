<?php
session_start();
include "db_config.php";
include "functions.php";
if(isset($_POST["action"])){
    if($_POST["action"]=="send_request"){
        $output=1;
        $to_id=$_POST["to_id"];
        $insert_request="insert into friend_request(request_from_id,request_to_id)
         values('$_SESSION[userID]','$to_id')";
         $insert_request_res=mysqli_query($conn,$insert_request) or die("insert_request Query Failed");
         echo $output;
        }//code for sending friend request and storing friend requset data
    if($_POST["action"]=="count_unseen_freind_requests"){
        $count_friend_request="select count(request_id) as total from friend_request where 
        request_to_id='$_SESSION[userID]' and request_status='Pending' and request_notification_status='No'";
        $count_friend_request_res=mysqli_query($conn,$count_friend_request) or die("count_friend_request Query Failed");
        $output="";
        if(mysqli_num_rows($count_friend_request_res)>0){
            $count_request=mysqli_fetch_assoc($count_friend_request_res);
            $output=$count_request["total"];
        }
        echo $output;

    }//code for displaying friend request notification count
    
    if($_POST["action"]=="list_friend_request_notification"){
        $list_friend_request="select * from friend_request where 
        request_to_id='$_SESSION[userID]' and request_status='Pending' order by request_id desc";
        $list_friend_request_res=mysqli_query($conn,$list_friend_request) or die("count_friend_request Query Failed");
        $output="";
        if(mysqli_num_rows($list_friend_request_res)>0){
            while($requestRow=mysqli_fetch_assoc($list_friend_request_res)){
                $uid=$requestRow["request_from_id"];
                $request_id=$requestRow["request_id"];
                $result=get_whole_data($uid,$conn);
                if(mysqli_num_rows($result)>0){
                    $row=mysqli_fetch_assoc($result);
                    $username=$row["u_name"];
                    $avatar_path=$row["u_avatar"];
                    $output.='<li class="dropdown-item">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="'.$avatar_path.'" alt="" class="rounded-circle" width="30px" height="30px">
                        </div>
                        <div class="col-md-7">
                            <b><a href="">'.$username.'</a></b>
                        </div>
                        <div class="col-md-3">
                            <button type="button"class="btn btn-primary btn-sm accept_request_btn" id="'.$request_id.'">Accept</button>
                        </div>
                    </div>
                </li>';
                }
                
            }
        }
        echo $output;

    }//code for displaying friend request list in notification

    if($_POST["action"]=="remove_frind_request_notification"){
        $output=1;
        $remove_notification="update friend_request set request_notification_status='Yes' 
        where request_to_id='$_SESSION[userID]' and request_notification_status='No'";
         $remove_notification_res=mysqli_query($conn,$remove_notification) or die("remove_notification Query Failed");
         echo $output;
        }//code for removing friend request notification

    if($_POST["action"]=="accept_friend_request"){
        $request_id=$_POST["request_id"];
        $accept_friend_request="update friend_request set request_status='Confirm' 
        where request_id='$request_id'";
            $accept_friend_request_res=mysqli_query($conn,$accept_friend_request) or die("accept_friend_request Query Failed");
        }//code for accepting friend request end

    if($_POST["action"]=="load_accepted_friends"){
        $search='';
        if(!empty($_POST["query"])){
            $sQuery=$_POST["query"];
            $search.="and registration.u_name like '%$sQuery%'";
        }
        $get_friend_id="select friend_request.request_from_id,friend_request.request_to_id,registration.u_name from friend_request 
        inner join registration on friend_request.request_from_id=registration.u_reg_id or friend_request.request_to_id=registration.u_reg_id where 
        (friend_request.request_to_id='$_SESSION[userID]' or friend_request.request_from_id='$_SESSION[userID]') and friend_request.request_status='Confirm' and 
        registration.u_reg_id!='$_SESSION[userID]' ".$search." group by u_name order by request_id desc";
        $get_friend_id_res=mysqli_query($conn,$get_friend_id) or die("get_friend_id Query Failed");
        $output="";
        $count=0;
        if(mysqli_num_rows($get_friend_id_res)>0){
            while($requestRow=mysqli_fetch_assoc($get_friend_id_res)){
                if($requestRow["request_from_id"]==$_SESSION["userID"]){
                    $uid=$requestRow["request_to_id"];
                }else{
                    $uid=$requestRow["request_from_id"];
                }
                
                $result=get_whole_data($uid,$conn);
                if(mysqli_num_rows($result)>0){
                    $row=mysqli_fetch_assoc($result);
                    $username=$row["u_name"];
                    $avatar_path=$row["u_avatar"];
                }
                $count++;
                if($count==1){
                    $output.='<div class="row">';
                }
                $output.='<div class="col-md-4 mb-12">
                <img src="'.$avatar_path.'" alt="" width="70px" height="70px" class="rounded-circle">
                <div class="friend-title" align="center">
                    <b><a href="#">'.$username.'</a></b>
                </div>
            </div>';

            if($count==3){
                $output.='</div>';
                $count=0;
            }
            }
            
        }else{
            $output.='<h4 align="center">No Friends Found</h4>';
        }
        echo $output;

    }//code for displaying accepted friend requests

    
}//sending friend request to specific user
?>