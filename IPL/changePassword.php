<?php 

	$authVal = $_POST['checkChangeAuth'];	
	$authName = $_POST['changeNameAuth'];

	if($authVal != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}

	else if($authVal == 1){

		if($authName == 1){

			session_start();

			$_SESSION['changePassword'] = 0;

			include "dbconnect.php";

			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$changeUser = $_SESSION['username'];

			$oldPass = $_POST['oldPass'];
			$newPass = $_POST['newPass'];
			$conNewPass = $_POST['conNewPass'];

			$oldPass = test_input($oldPass);
			$newPass = test_input($newPass);
			$conNewPass = test_input($conNewPass);

			$oldPass = $con->real_escape_string($oldPass);
			$newPass = $con->real_escape_string($newPass);
			$conNewPass = $con->real_escape_string($conNewPass);

			$check_pass = "select password from proj4_members where username = '$changeUser'";
			$check_pass_res = $con->query($check_pass);
			$check_pass_val = $check_pass_res->fetch_assoc();

			$oldPass = md5($oldPass);

			if($check_pass_val['password'] != $oldPass){
				echo 0;
			}
			else if($check_pass_val['password'] == $oldPass){
				if($newPass != $conNewPass){
					echo 1;
				}
				else if($newPass == $conNewPass){
					$newPass = md5($newPass);
					if($oldPass == $newPass){
						echo 3;
					}
					else if($oldPass != $newPass){
						$update_pass = "update proj4_members set password ='$newPass' where username = '$changeUser'";
						$update_pass_result = $con->query($update_pass) or die ($con->error);

						$_SESSION['changePassword'] = 1;		
						echo 2;	
					}			
				}
			}
		}
		else if($authName == 2){
			session_start();

			$_SESSION['changeName'] = 0;

			include "dbconnect.php";

			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$changeUser = $_SESSION['username'];

			$newName = $_POST['cName'];
			$newName = test_input($newName);
			$newName = $con->real_escape_string($newName);

			$name_check = "select name from proj4_members where username = '$changeUser'";
			$name_check_res = $con->query($name_check);
			$name_check_val = $name_check_res->fetch_assoc();

			$curName = $name_check_val['name'];

			if($curName == $newName){
				echo 0;
			}
			else if($curName != $newName){

				$update_member_name = "select name from proj4_members where username = '$changeUser'";
				$update_member_res = $con->query($update_member_name) or die ($con->error);
				$update_member_val = $update_member_res->fetch_assoc();

				$changeMember = $update_member_val['name'];


				$update_name = "update proj4_members set name ='$newName' where username = '$changeUser'";
				$update_name_result = $con->query($update_name) or die ($con->error);				

				

				$update_name_posts = "update proj4_posts set edited_by ='$newName' where edited_by = '$changeMember'";
				$update_name_res = $con->query($update_name_posts) or die ($con->error);

				$update_name_reply = "update proj4_reply set reply_edited_by ='$newName' where reply_edited_by = '$changeMember'";
				$update_name_resr = $con->query($update_name_reply) or die ($con->error);


				$_SESSION['changeName'] = 1;		
				echo 1;	
			}
		}
		else if($authName == 3){
			
			include "dbconnect.php";

			session_start();

			$_SESSION['changeUpload'] = 0;			

			$image_username=$_SESSION['username'];
			$user_image_change_name=$_FILES['profile_pic_change']['name'];

			$user_image_tmp=$_FILES['profile_pic_change']['tmp_name'];
			if($user_image_change_name){
				$user_image_change_name=stripslashes($_FILES['profile_pic_change']['name']);
				$extension=pathinfo($user_image_change_name,PATHINFO_EXTENSION);
				$extension=strtolower($extension);
				
				if(($extension!="jpeg") && ($extension!="jpg") && ($extension!="png") && ($extension!="gif")){
					echo 2;
				}
				else{
					$user_image_search_query="select image_username from proj4_avatar_images where image_username='$image_username'";
					$user_image_search_exec=$con->query($user_image_search_query) or die($con->error);
					$user_image_search=$user_image_search_exec->fetch_assoc();
					
					$change_image=addslashes(file_get_contents($_FILES['profile_pic_change']['tmp_name']));
					$size=getimagesize($_FILES['profile_pic_change']['tmp_name']);
					$type=$size['mime'];
					
					if($user_image_search['image_username']==""){
						$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$change_image','$image_username','$type')";
						$image_exec=$con->query($image_query) or die('image not inserted');
						$_SESSION['changeUpload'] = 1;
						echo 1;
					}
					else{
						$change_image=addslashes(file_get_contents($_FILES['profile_pic_change']['tmp_name']));
						$size=getimagesize($_FILES['profile_pic_change']['tmp_name']);
						$type=$size['mime'];
						$change_profile_pic_query="update proj4_avatar_images set image='$change_image',image_type='$type' where image_username='$image_username'";
						$change_profile_pic_exec=$con->query($change_profile_pic_query) or die('image not updated'.$con->error);
						$_SESSION['changeUpload'] = 1;
						echo 1;
					}
				}									
			}
			else if(!$user_image_change_name){
				echo 3;
			}
		}		
	}
?>