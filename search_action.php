
<?php
session_start();
include "db_config.php";
include "functions.php";
if(isset($_POST["sQuery"])){
    $search_query=trim($_POST["sQuery"]);
    
    $search_array=explode(" ",$search_query);

    $bold_array=array_map("bold_query",$search_array);

    $search_string=implode(" ",$search_array);
    $bold_string=implode(" ",$bold_array);

            $sQuery="select * from registration where u_name like '%$search_string%' limit 10";
            $sResult=mysqli_query($conn,$sQuery) or die("Serach Query Failed");
            $output='<ul>';
            if(mysqli_num_rows($sResult)>0){
                while($sRow=mysqli_fetch_assoc($sResult)){
                    $tempText=$sRow["u_name"];
                    $tempText=str_ireplace($search_string,$bold_string,$tempText);
        
                    $avatar_path=get_user_avatar($conn,$sRow["u_reg_id"]);
                    $output.='<li><a href="#" class="list"><img src="'.$avatar_path.'" alt="" width="30px" height="30px" class="rounded-circle"> '.$tempText.'</a></li>';
                    
                }
            }else{
                $output.='<li><a href="#">No Record Found</a></li>';
            }
            $output.='</ul>';

            echo $output;

}//search suggestion list




if(isset($_POST["searchQuery"])){
    $searchQuery=trim($_POST["searchQuery"]);
    $page=trim($_POST["page"]);
    $limit=5;
    if($page>1){
        $offset=($page-1)*$limit;
    }else{
        $offset=0;
    }
    $sQuery="select * from registration as r inner join country as c on c.country_id=r.u_country where u_name like '%$searchQuery%' and u_reg_id!='$_SESSION[userID]' limit $offset,$limit";
    $sResult=mysqli_query($conn,$sQuery) or die("serachQuery Query Failed");
    $output='';
    if(mysqli_num_rows($sResult)>0){
        $output.='<div class="search-result">
        <span>Search result for "<b>'.$searchQuery.'</b>"</span>
    </div>';
        while($sRow=mysqli_fetch_assoc($sResult)){
            $avatar_path=get_user_avatar($conn,$sRow["u_reg_id"]);
            $request_status=get_request_status($conn,$_SESSION["userID"],$sRow["u_reg_id"]);
            if($request_status=="Pending"){
                $request_button='<button class="btn btn-primary requestBtn" name="requestBtn" disabled>Pending...</button>';
            }elseif($request_status=="Reject"){
                $request_button='<button class="btn btn-primary requestBtn" name="requestBtn" disabled>Rejected</button>';
            }else{
                $request_button='<button class="btn btn-primary requestBtn" id="'.$sRow["u_reg_id"].'" name="requestBtn"><i class="fa fa-user-plus text-white"></i> Add Friend</button>';
            }
            $output.='
            
        <div class="row search-area mt-10">
            <div class="col-md-2">
                <img src="'.$avatar_path.'" alt="" width="100px" height="100px" class="rounded-circle">
            </div>
            <div class="col-md-7">
                <h4>'.$sRow["u_name"].'</h4>
                <i>From '.$sRow["country_name"].'</i>
            </div>
            <div class="col-md-3" align="right">
                '.$request_button.'
            </div>
        </div><!--search area row-->';
            
        }

        //pagination code start
        $sQuery1="select * from registration as r inner join country as c on c.country_id=r.u_country where u_name like '%$searchQuery%' and u_reg_id!='$_SESSION[userID]'";
        $sResult1=mysqli_query($conn,$sQuery1) or die("serachQuery Query Failed");
        if(mysqli_num_rows($sResult1)>5){
        $total_rocords=mysqli_num_rows($sResult1);
        $total_pages=ceil($total_rocords/$limit);
        $output.='<div class="row">
        <div class="col-12 mt-20">
            <ul class="pagination justify-content-center">';
            if($page>1){
                $output.='<li class="page-item"><a href="search.php?query='.$searchQuery.'&&page='.($page-1).'" class="page-link">Previous</a></li>';
            }
                
                for($i=1;$i<=$total_pages;$i++){
                    if($page==$i){
                        $active="active";
                    }else{
                        $active="";
                    }
                    $output.='<li class="page-item '.$active.'" id="'.$i.'"><a href="search.php?query='.$searchQuery.'&&page='.$i.'" class="page-link">'.$i.'</a></li>';
                }
                if($page<$total_pages){
                  $output.='<li class="page-item"><a href="search.php?query='.$searchQuery.'&&page='.($page+1).'" class="page-link">Next</a></li>';  
                }    
        $output.='</ul> 
        </div>
    </div>';
    //pagination code end
            }
    }else{
        $output.='<h2>No Record Found</h2>';
    }

    echo $output;
}//displaying searched friend list
?>