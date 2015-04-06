<?php
                require_once('header.php');
                require_once('getDB.php');
                include "expire.php";

?>
<html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

<script>
    $(document).ready(function(e){

       $('#dropdown').on('click',function(){

          $('.dropdownwrap').slideToggle();

       });
       
       
       $('#post_button').on('click',function(){

            //alert("hie");
                    
            var catid = "<?php echo $_REQUEST['catid']?>";
            alert(catid);
            var error = 1;
            var errorFields = "";
                                                    
            // Validate the credentials here
            if($.trim($("#title").val()) == "") 
            {
                error = 0;
                errorFields = errorFields + "Title   ";
                $("#title").addClass("error");

            }
            if($.trim($("#content").val()) == "")
            {              
                error = 0;
                errorFields = errorFields + "content   ";
                $("#content").addClass("error");
            }
                                                    
            if(error == 0)
            {
            //alert("reacher here");                                               
                                                                    
                $(".errorNote").html(errorFields.substring(0,errorFields.length - 2)+" : mandatory field!");
                $(".errorNote").show();
                //alert("now here");
                setTimeout(function() {
                    $(".Note").hide();
                    $(".errorNote").hide();
                }, 4000);
            }
            else
            {
                //$("#loading_div").show();
                // Service call
                                                                    
                $.ajax({
                    type: "POST",
                    url: "insertPost.php",
                    data: {
                        'title': $("#title").val(),
                        'content': $("#content").val(),
                        'catid': catid
                    },
                    success: function (data) {
                        $("#loading_div").hide();
                        if(data)
                        {
                        window.location.href = "home.php?catid="+catid;
                        $('.dropdownwrap').hide();        
                        
                        //alert("posted successfully");
                        }
                        else
                        {
                            $(".errorNote").html("<h4 style=\"color: red;\"> Information provided did not match our records, please retry!</h4>");
                            $(".errorNote").show();
                            
                            setTimeout(function() {
                                $(".errorNote").hide();
                            }, 3000);
                        }
                    },
                    dataType: "json"
                });
            }   
       });


    });
</script>

<body>
<a href="logout.php"  class="logout">logout</a>
                <div class="wrapper">

                                <div class="dropdownwrap" hidden>
                                
                                Title <br/> 
                                                <textarea id="title"  rows="2" cols="50" name="title"></textarea><br/>
                                Content <br/>
                                                <textarea id="content" rows="4" cols="50" name="comment"></textarea><br/>
                                
                                                <input type="button" id="post_button" class="home_button" value="post"><br/>
                                <h4 class="errorNote" style="color: red;" hidden>  </h4>
                                </div>

                <div class="post_bar">
                <a id="dropdown">Click to Post</a><br/>
                </div>
                                <?php
                                                                
                                                                                $sql = "select p.*,u.user_name from threads p, users u where thread_cat=".$_REQUEST['catid']." and p.thread_by=u.user_id order by thread_date";
                                                                                $results = mysql_query($sql) or die(mysql_error());
                                                                                while($row = mysql_fetch_array($results))
                                                                {
                                                                
                                                                                echo '<div class="forumPost"><div style="width : 55%; float:left;"><span style="font-weight:bold"><a href="viewThread.php?thread='.$row['thread_id'].'">'.$row['thread_subject'].'</a><br/></span><span style="font-size:13px">Started by '.$row['user_name'].', '.$row['thread_date'].'</span></div> <div style="width:15%; float:left">Replies: 0<br/>Views: 0</div></div>';
                                                                
                                                                }

                                ?>
                
                </div>

</body>
</html>
