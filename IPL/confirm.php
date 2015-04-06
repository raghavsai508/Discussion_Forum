<?php
    session_start();

    if($_SESSION['signuser'] != 0){
       header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
    }

    else if($_SESSION['signuser'] == 0){
       include "dbconnect.php";

       $_SESSION['search_team'] = 9;
        
        $activation_id=$_GET['id'];

        $activation_check = "select activation from proj4_members where activation_code = '$activation_id'";
        $activation_check_res = $con->query($activation_check);
        $activation_value = $activation_check_res->fetch_assoc();

        if($activation_value['activation'] != 0){
            header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
        }
        else if($activation_value['activation'] == 0){

            $sql_confirmation="update proj4_members set activation = 1 where activation_code='$activation_id'";
            $sql_user_confirm=$con->query($sql_confirmation);

            $user_details="select email from proj4_members where activation_code='$activation_id'";
            $execute_user_details=$con->query($user_details);

            $user_email_fetch=$execute_user_details->fetch_assoc();
            $user_email=$user_email_fetch['email'];
            
            // $new_activation_code = md5(time() . $msec);

            // $activation_code = "update proj4_members set activation_code = '$new_activation_code' where activation_code='$activation_id'";
            // $activation_res = $con->query($activation_code);
            

            $to = $user_email;
            $subject = "Account Activated";
            $message = "Welcome to the IPL Discussion Forum <br><br>";
            $message .= "Your Account has been activated.";
            $message .= "<html><a href=\"https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php\">Please Click here to go to Home Page</a></html>";
            $message .= "<br><br>Thanks <br> HallaBol ";
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "Content-Transfer-Encoding: 7bit\r\n";
            $headers .= "From: HallaBol\r\n";

            $mailsent=mail($to,$subject,$message,$headers);

            if($mailsent){ 
                include "header.php";  ?>

                <script>


                    function chooseFile() {
                        $("#fileInput").click();
                    }

                    $(document).ready(function(e){
                        $('#loginform').submit(function(){              

                            $.ajax({                        
                                type: "POST",
                                url: "checklogin.php",
                                data: {
                                    'user': $('#inputUser').val(),
                                    'pass': $('#inputPass').val(),
                                    'remember' : $('#inputCheck').val(),
                                    'checkLoginAuth' : 1
                                },
                                success: function (data){
                                    if(data == 1){
                                        window.location.href = "index.php";                         
                                    }
                                    else if(data == 0){
                                        document.getElementById("loginform").reset();
                                        $("#errorNote").html(" Information provided did not match our records, please retry!");
                                        $("#errorNote").show();                         
                                        setTimeout(function() {
                                            $("#errorNote").hide();
                                        }, 3000);
                                    }
                                }
                            });
                            return false;
                        });
                    });
                </script>

                    <div class="primaryMenu">
                                <div class="wrapper">      
                                    <div class="masthead-menu">
                                        <ul id="yw1">
                                            <li><a href="index.php">Home</a></li>
                                            <?php if ($_SESSION['admin_auth'] == 1){ ?>
                                                <li><a href="admin.php">Admin</a></li>                                  
                                            <?php } ?>
                                           
                                        </ul>            
                                    </div>
                                </div>                              
                            </div><!-- END top-masthead -->
                        </div><!-- END mastheadContent -->
                    </div>

                    <div class="wrapper">
                        <div class="main-content ">
                            <div class="hero">
                                <div class="heroContent">
                                    <br><br><br>
                                    <div class="well well-default">
                                        <div class="panel-body" style="text-align: center">                                 
                                            Your Account has been activated. <br><br>
                                            

                                           <!--  <div style="height:0px;overflow:hidden">
                                               <input type="file" id="fileInput" name="fileInput" />
                                            </div>

                                            <button id="confirmProfilePage" class="btn btn-info btn-sm" onclick="chooseFile();">Click here to upload a Profile image</button><br><br> -->

                                            <a href="index.php"><!-- <a id="modal-1234" href="#modal-container-309289" data-toggle="modal"> -->
                                                <button type="submit" id="confirmHomePage" class="btn btn-info btn-sm">Click here to go to Home Page</button><br><br>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body>
                </html>
            <?php } 
        } 
    } 
?>

	

	

    


