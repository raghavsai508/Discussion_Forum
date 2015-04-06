<?php
	session_start();
	
	$pres_user=$_SESSION['username'];

	/*echo "<br><br>".$_SESSION['admin_auth'];
	echo $_SESSION['update'];
	echo $_SESSION['signuser'];*/
		
	if ($_SESSION['signuser'] == 0 || $_SESSION['permission'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1){
		if($_SESSION['admin_auth'] == 1 || $_SESSION['mod_auth'] == 1){
		
			$username=$_SESSION['username'];
			include "dbconnect.php";	

			$role=$_GET['role'];	
			$user=$_GET['name'];
				
			//echo $num_pages;
			//echo $page_name;
			if ($role == 1 || $role ==2 || $role == 3){	
					$user_roles = "select role from proj4_role where role_id = $role";
					$user_role_result = $con->query($user_roles) or die ($con->error);
					$user_role_value = $user_role_result->fetch_assoc();			

					$user_role=$user_role_value['role'];			
					
					$update = "update proj4_members set role ='$user_role' where username = '$user'";
					$update_result = $con->query($update) or die ($con->error);	
					//echo "HI";
					//echo $user_role;
					
					
					if ($update_result > 0){	
						$admin_check = "select username,role from proj4_members where username = '$pres_user'";
						$admin_check_result =  $con->query($admin_check) or die ($con->error);
						$admin_check_value = $admin_check_result->fetch_assoc();			
						//echo $admin_check_value['username'];				
						if ($admin_check_value['username'] == $pres_user ){					
							if ($admin_check_value['role'] != "admin"){
								echo $user_role;
								$_SESSION['admin_auth'] = 0;
								header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
							}
							else{
								header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/members.php');
							}					
						}
						else if($admin_check_value['username'] != $pres_user){
							header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/members.php');
						}
					}
			}		
			else if ($role == 0){

					$get_user = "select email from proj4_members where username = '$user'";
					$get_res = $con->query($get_user);
					$get_value = $get_res->fetch_assoc();


					$delete = "delete from proj4_members where username = '$user'";
					$delete_result = $con->query($delete) or die ($con->error);
					
						$admin_check = "select username,role from proj4_members where username = '$pres_user'";
						$admin_check_result =  $con->query($admin_check) or die ($con->error);				
					
					if ($delete_result > 0){

						$to = $get_value['email'];
			            $subject = "Account Deleted";
			            $message = "Hello $user, <br><br>";
			            $message .= "Your account has been deleted from the IPL Discussion Forum.";
			            $message .= "<br>Reason: You have been using offensive language quite frequently in the posts ";
			            $message .= "<br><br>Thanks! <br> From Admin <br> HallaBol ";
			            $headers = "MIME-Version: 1.0\r\n";
			            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			            $headers .= "Content-Transfer-Encoding: 7bit\r\n";
			            $headers .= "From: HallaBol\r\n";

			            $mailsent = mail($to, $subject, $message, $headers);

			            if($mailsent){
			            	if (mysqli_num_rows($admin_check_result) == 0 ){
							$_SESSION['admin_auth'] = 0;
							header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/session.php');
							}
							header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/members.php');
			            }				
					}
			}
			else if ($role == 5){
					$num_pages = $_GET['num_pages'];
					$page_name = $_GET['page_name'];
					$update = "update proj4_pages set num_pages ='$num_pages' where page_name = '$page_name'";
					$update_result = $con->query($update) or die ($con->error);	

					if ($update_result > 0){
						header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/pagination.php');

					}
			}
			else if ($role == 4){

					$content =$_POST['suspendreason'];

					$suspend_email = "select email from proj4_members where username = '$user' ";
					$suspend_res = $con->query($suspend_email) or die ($con->error);
					$suspend_email_val = $suspend_res->fetch_assoc();

					$to = $suspend_email_val['email'];
					$subject = "Account suspension";
					$message = "Hi $user, <br><br>";
					$message .= "Your account has been suspended from the IPL Discussion Forum.<br>";
			        $message .= "<br>Reason: $content";
			        $message .= "<br><br>Thanks! <br> From Admin <br> HallaBol ";
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= "Content-Transfer-Encoding: 7bit\r\n";
					$headers .= "From: HallaBol\r\n";

					$mailsent = mail($to, $subject, $message, $headers);

					if($mailsent){
						$update = "update proj4_members set suspension = 1 where username = '$user'";
						$update_result = $con->query($update) or die ($con->error);	

						if ($update_result > 0){
							header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$user);
						}
					}			
			}
			else if ($role == 6){

					$suspend_email = "select email from proj4_members where username = '$user' ";
					$suspend_res = $con->query($suspend_email) or die ($con->error);
					$suspend_email_val = $suspend_res->fetch_assoc();

					$to = $suspend_email_val['email'];
					$subject = "Account suspension Lifted";
					$message = "Hi $user, <br><br>";
					$message .= "Your Suspension has been lifted.";
			        $message .= "<br>Now you can post the messages in the Forum";
			        $message .= "<br><br>Thanks! <br> From Admin <br> HallaBol ";
					$headers = "MIME-Version: 1.0\r\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					$headers .= "Content-Transfer-Encoding: 7bit\r\n";
					$headers .= "From: HallaBol\r\n";	

					$mailsent = mail($to, $subject, $message, $headers); 

					if($mailsent){
						$update = "update proj4_members set suspension = 0 where username = '$user'";
						$update_result = $con->query($update) or die ($con->error);	

						if ($update_result > 0){
							header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$user);
						}
					}			
			}
			else if ($role == 7){
				$image_value = $_GET['image_value'];
				$rank = $_GET['rank'];

				$update = "update proj4_images_limit set image_limit ='$image_value' where user_rank = '$rank'";
				$update_result = $con->query($update) or die ($con->error);	

				if ($update_result > 0){
					header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/imageLimit.php');
				}
			}
			else{
				header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
			}
		}
	}	
?>