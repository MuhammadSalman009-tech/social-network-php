<?php
include "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>beSocial || HOME</title>
    
</head>
<body>
<div class="container">
        <div class="row mt-80">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Timeline</h5>
                    </div>
                    <div class="card-body">
                        <h1>Welcome : <?php echo $_SESSION["userName"];?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-5">
                                <h5 class="card-title">User Details</h5>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="search-friend" id="search-friend" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="list-accepted-friends">
                                                                  
                    </div>
                </div><!--card-->
            </div>
        </div>
    </div>


    
</body>
</html>
