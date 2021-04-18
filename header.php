<?php
session_start();
if(!isset($_SESSION["userName"])){
    header("Location:login.php?msg=Direct Access is Unauthorized, please log in first!");
}
include "db_config.php";
include "functions.php";

if(isset($_POST["searchBtn"])){
    $serch_query=$_POST["searchbar"];
    if($serch_query==""){
        header("Location:home.php");
    }else{
        header("Location:search.php?query=$serch_query");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
       <div class="container-fluid">
            <a href="home.php" class="navbar-brand"><h5>beSocial</h5></a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navigation-menu">
                <span class="navbar-toggler-icon"><i class="fa fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navigation-menu">
                <form action="" method="post">
                    <div class="search-div">
                        <div class="input-group">
                            <input type="text" name="searchbar" id="searchbar" autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" name="searchBtn" id="searchBtn"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div id="users-list">
                            
                        </div>
                    </div>
                </form>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a href="" class="nav-link dropdown-toggle" data-toggle="dropdown" id="friend-request-notification-area">
                            <span class="badge badge-danger" id="unseen-friend-requests"></span>
                            <i class="fa fa-user-plus"></i>
                        </a>
                        <ul class="dropdown-menu" id="friend_request_list" style="width:300px;max-height:250px;overflow-y: scroll;">
                            
                        </ul>
                    </li>
                    <li class="nav-item">
                        
                        <a href="profile.php?action=view" class="nav-link">
                            <?php
                            $avatar_path=get_user_avatar($conn,$_SESSION["userID"]);
                            ?>
                            <img src="<?php echo $avatar_path?>" alt="" width="30px" height="30px" class="rounded-circle">    
                            <span> <b>Profile</b></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link"><i class="fa fa-sign-in-alt"></i> <b>Logout</b></a>
                    </li>
                </ul>
            </div>
       </div>
    </nav>


    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
        $(document).ready(function(){
            //function for displaying friend request notification count
            setInterval(function(){
                count_unseen_freind_requests();
            }, 5000);

          function count_unseen_freind_requests(){
              var action="count_unseen_freind_requests";
              $.ajax({
                  url:"friend-request-action.php",
                  type:"POST",
                  data:{action:action},
                  success:function(data){
                    if(data>0){
                        $("#unseen-friend-requests").html(data);
                    }
                  }
              })
          }
          //function for displaying friend request notification count end
          
          //function for displaying friend request list in notification
          $("#friend-request-notification-area").on("click",function(){
            list_friend_request_notification();
            remove_frind_request_notification();            
          })
          function list_friend_request_notification(){
              var action="list_friend_request_notification";
              $.ajax({
                  url:"friend-request-action.php",
                  type:"POST",
                  beforeSend:function(){
                    $("#friend_request_list").html('<i class="fa fa-circle-notch fa-spin text-white"></i>');
                    },
                  data:{action:action},
                  success:function(data){
                    $("#friend_request_list").html(data);
                    
                  }
              })
          }//function for displaying friend request list in notification end

            //function for removing friend request notification 
          function remove_frind_request_notification(){
            var action="remove_frind_request_notification";
            $.ajax({
                  url:"friend-request-action.php",
                  type:"POST",
                  data:{action:action},
                  success:function(data){
                    if(data==1){
                        $("#unseen-friend-requests").html("");
                    }
                  }
              })
          }//function for removing friend request notification end

          //function for accepting friend request
          
              $(".dropdown-menu").on("click",function(event){
                  event.preventDefault();
              var request_id=event.target.getAttribute("id");
              console.log(request_id);
              var action="accept_friend_request";
              if(request_id>0){
                $.ajax({
                  url:"friend-request-action.php",
                  type:"POST",
                  data:{action:action,request_id:request_id},
                  success:function(){
                        list_friend_request_notification();
                        load_accepted_friends();   
                  }
          })
              }
          return false;
              })//function for accepting friend request end

//function for displaying accepted friend requests
              $("#list-accepted-friends").html('<div class="loader-icon"><i class="fa fa-circle-notch fa-spin"></i></div>');
            setTimeout(function(){
                load_accepted_friends();
            }, 3000);
            function load_accepted_friends(query=""){
                var action="load_accepted_friends";
            $.ajax({
                  url:"friend-request-action.php",
                  type:"POST",
                  data:{action:action,query:query},
                  success:function(data){
                    $("#list-accepted-friends").html(data);
                  }
              })
            }//function for displaying accepted friend requests

            $(document).on("keyup","#search-friend",function(){
                var s_query=$(this).val();
                if(s_query!=""){
                    load_accepted_friends(s_query);
                }else{
                    load_accepted_friends();
                }
            })

    })
    </script>

<?php 
include "footer.php";
?>
</body>
</html>

