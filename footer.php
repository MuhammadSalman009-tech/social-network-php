<script>
    $(document).ready(function(){
        $("#searchbar").on("keyup", function(e){
            e.preventdefault;
            var query=$(this).val();

            if(query!=""){
                $.ajax({
                    url:"search_action.php",
                    type:"POST",
                    data:{sQuery:query},
                    success:function(data){
                        $("#users-list").fadeIn();
                        $("#users-list").html(data);

                    }
                })
            }else{
                $("#users-list").html("");
            }
        })//search action function

        $(document).on("click","#users-list ul li a.list",function(){
            var listText=$(this).text();
            console.log(listText);
            $("#searchbar").val(listText);
            $("#users-list").fadeOut();
        })//getting clicked list value in searchbar
    })
</script>