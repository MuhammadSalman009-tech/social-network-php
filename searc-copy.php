<?php
include "header.php";
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body class="body">
    <div class="container">
        <div class="row">
            <div class="col-md-9 mt-10 search-page">
                <div class="search-result">
                    <span>Search result for "<b>salman</b>"</span>
                    <i class="fa fa-circle-notch fa-spin"></i>
                </div>
                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary" disabled><i class="fa fa-clock text-white"></i> Add friend</button>
                    </div>
                </div><!--search area row-->

                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->

                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->
                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->
                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->
                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->
                <div class="row search-area mt-10">
                    <div class="col-md-2">
                        <img src="avatar/1600721833.jpg" alt="" width="100px" height="100px" class="rounded-circle">
                    </div>
                    <div class="col-md-7">
                        <h4>Muhammad salman</h4>
                        <i>From Pakistan</i>
                    </div>
                    <div class="col-md-3" align="right">
                        <button class="btn btn-primary">Add friend</button>
                    </div>
                </div><!--search area row-->

                <div class="row">
                    <div class="col-12 mt-20">
                        <ul class="pagination justify-content-center">
                            <li class="page-item"><a href="" class="page-link">Previous</a></li>
                                <li class="page-item"><a href="" class="page-link">1</a></li>
                                <li class="page-item"><a href="" class="page-link">2</a></li>
                                <li class="page-item"><a href="" class="page-link">3</a></li>
                                <li class="page-item"><a href="" class="page-link">4</a></li>
                                <li class="page-item"><a href="" class="page-link">5</a></li>
                            <li class="page-item"><a href="" class="page-link">Next</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>

    <!--home.php-->
    <?php
                        $get_img="select * from registration where u_reg_id='$_SESSION[userID]'";
                        $get_img_res=mysqli_query($conn,$get_img) or die("Avatar Query Failed");
                        if(mysqli_num_rows($get_img_res)>0){
                            $row=mysqli_fetch_assoc($get_img_res);
                            $user_avatar=$row["u_avatar"];
                        }
                        ?>
                        <div class="user-details" align="center">
                            <img src="<?php echo $user_avatar?>" alt="" width="100px" height="100px" class="rounded-circle">
                            <br>
                            <span><?php echo $_SESSION["userName"]?></span>
                            <br><br>
                            <a href="logout.php" class="btn btn-warning">Logout</a>
                        </div>




                        <div class="row">
                            <div class="col-md-4 mb-12">
                                <img src="avatar/1600721833.jpg" alt="" width="70px" height="70px" class="rounded-circle">
                                <div class="friend-title" align="center">
                                    <b><a href="#">Muhamma Salman</a></b>
                                </div>
                            </div>
                            <div class="col-md-4 mb-12">
                                <img src="avatar/1600721833.jpg" alt="" width="70px" height="70px" class="rounded-circle">
                            </div>
                            <div class="col-md-4 mb-12">
                                <img src="avatar/1600721833.jpg" alt="" width="70px" height="70px" class="rounded-circle">
                            </div>
                       </div> 