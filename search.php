<?php
//getting page number for pagination
$page="";
if(isset($_GET["page"])){
    $page=$_GET["page"];
}//getting page number for pagination end

//displaying search.php page only if the searched query is set
if(isset($_GET["query"])){
    include "header.php";
    $searchQuery=$_GET["query"];
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
                <div class="loader">
                    <span><i class="fa fa-circle-notch fa-spin"></i></span>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            var searchQuery="<?php echo $searchQuery;?>";
            var getpage="<?php echo $page;?>";
            $("#searchbar").val(searchQuery);
            if(getpage==""){
                page=1;
            }else{
                page=getpage;
            }
            load_result(searchQuery,page);

            function load_result(searchQuery,page){
                $.ajax({
                    url:"search_action.php",
                    type:"POST",
                    data:{searchQuery:searchQuery,page:page},
                    success:function(data){
                        $(".search-page").html(data);
                    }
                })
            }//function for displaying searched friend list

            $(document).on("click",".requestBtn",function(){
                var to_id=$(this).attr("id");
                console.log(to_id);
                var action="send_request";
                if(to_id>0){
                    
                        $.ajax({
                        url:"friend-request-action.php",
                        type:"POST",
                        data:{to_id:to_id,action:action},
                        beforeSend:function(){
                            $("#"+to_id).attr("disabled","disabled");
                            $("#"+to_id).html('<i class="fa fa-circle-notch fa-spin text-white"></i> Sending...');
                            },
                        success:function(data){
                            if(data==1){
                                $("#"+to_id).html('Request Sent');
                            }
                            
                        }
                    })
                        }
                    
            })//function for add friend button

        })
    </script>
    </body>
    </html>
    <?php
}
?>