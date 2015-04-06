<?php

	$authVal = $_POST['checkRegisterAuth'];	

	if($authVal != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}

	else if($authVal == 1){ 
		session_start();

		include "dbconnect.php";

		/*require 'CaptchasDotNet.php';*/
		
		/*$captchas = new CaptchasDotNet ('cpallapo', 'hdwXW3ggKcrcY0Foyidg1EHtTJ2OOuzqmc3uGHir',
		                                '/tmp/captchasnet-random-strings','3600',
		                                'abcdefghkmnopqrstuvwxyz','6',
		                                '268','80','000000');*/

		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['sent_mail'] = 0;	
		$_SESSION['success'] = 0;	

		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$name = $_POST['name'];
		$username = $_SESSION['username'];
		$email = $_POST['email'];
		$password = $_SESSION['password'];
		$confirmpassword = $_POST['confirmpassword'];
		$captcha = $_POST['captcha_code'];
		$random = $_POST['random'];
		$emailoption = $_POST['option'];

		$name = test_input($name);
		$username = test_input($username);
		$email = test_input($email);
		$password = test_input($password);
		$confirmpassword = test_input($confirmpassword);
		$captcha = test_input($captcha);
		$random = test_input($random);
		$emailoption = test_input($emailoption);

		$name = $con->real_escape_string($name);
		$username = $con->real_escape_string($username);
		$email = $con->real_escape_string($email);
		$password = $con->real_escape_string($password);
		$confirmpassword = $con->real_escape_string($confirmpassword);
		$captcha = $con->real_escape_string($captcha);
		$random = $con->real_escape_string($random);
		$emailoption = $con->real_escape_string($emailoption);

		include_once "./securimage/securimage.php";
		$securimage = new Securimage();
		if ($securimage->check($captcha) == false) 
		{
			echo 5;
			
		}
		else
		{


		/*if(!$captchas->validate($random)){
			echo 6;
			//please go back and reload the page
		}
		else if(!$captchas->verify($captcha)){
			echo 5;
			//entered wrong captcha
		}
		else{*/
			list($user, $domain) = split('[@]', $email);

			$user_query = "select username from proj4_members where username = '$username'";
			$user_result = $con->query($user_query);
			$user_check = $user_result->fetch_assoc();

			if($username == $user_check['username']){
				echo 0;
			}
			else if($username != $user_check['username']){
				/*if($domain != 'cs.odu.edu'){
					echo 1;
				}*/
				//else if($domain == 'cs.odu.edu'){
					$email_query = "select email from proj4_members where email = '$email'";
					$email_result = $con->query($email_query);
					$email_check = $email_result->fetch_assoc();

					/*if($email_check['email'] == $email){
						echo 4;
					}
					else if($email_check['email'] != $email){*/
						if($password != $confirmpassword){
							echo 2;
						}
						else if($password == $confirmpassword){		

							$image = $_FILES['image_filename']['name'];
							$uploadedfile=$_FILES['image_filename']['tmp_name'];

							if($image){
								$image_filename = stripslashes($_FILES['image_filename']['name']);
								$extension=pathinfo($image_filename,PATHINFO_EXTENSION);
								$extension=strtolower($extension);

								if(($extension!="jpeg") && ($extension!="jpg") && ($extension!="png") && ($extension!="gif")){									
									echo 7; // not in file type
								}
								else{
									if($extension=="jpg"||$extension=="jpeg"){
										$uploadedfile=$_FILES['image_filename']['tmp_name'];
										$src=imagecreatefromjpeg($uploadedfile);
										$uploadimage=addslashes(file_get_contents($_FILES['image_filename']['tmp_name']));
										
										list($width,$height)=getimagesize($uploadedfile);
										$size=getimagesize($_FILES['image_filename']['tmp_name']);
										$type=$size['mime'];
										$tmp=imagecreatetruecolor($width,$height);
										// $newwidth=100;
										// $newheight=($height/$width)*$newwidth;
										// $tmp=imagecreatetruecolor($newwidth,$newheight);
										
										imagecopyresampled($tmp,$src,0,0,0,0,$width,$height,$width,$height);
										
										//$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$uploadimage','1','$type')";
										//$image_exec=$con->query($image_query) or die('image not inserted');
										
										$filename="/home/cpallapo/cs418_html/proj4/images/".uniqid().$_FILES['image_filename']['name'];
										
										imagejpeg($tmp,$filename,100);
									}
									else if($extension=="png"){
										$uploadedfile=$_FILES['image_filename']['tmp_name'];
										$src=imagecreatefrompng($uploadedfile);
										$uploadimage=addslashes(file_get_contents($_FILES['image_filename']['tmp_name']));

										list($width,$height)=getimagesize($uploadedfile);
										$size=getimagesize($_FILES['image_filename']['tmp_name']);
										$type=$size['mime'];
										$tmp=imagecreatetruecolor($width,$height);
										// $newwidth=100;
										// $newheight=($height/$width)*$newwidth;
										// $tmp=imagecreatetruecolor($newwidth,$newheight);
										
										imagecopyresampled($tmp,$src,0,0,0,0,$width,$height,$width,$height);
										
										$filename="/home/cpallapo/cs418_html/proj4/images/".uniqid().$_FILES['image_filename']['name'];
										
										imagepng($tmp,$filename,100);
									}
									else{
										$uploadedfile=$_FILES['image_filename']['tmp_name'];
										$src=imagecreatefromgif($uploadedfile);
										$uploadimage=addslashes(file_get_contents($_FILES['image_filename']['tmp_name']));

										list($width,$height)=getimagesize($uploadedfile);
										$size=getimagesize($_FILES['image_filename']['tmp_name']);
										$type=$size['mime'];
										
										$tmp=imagecreatetruecolor($width,$height);
										// $newwidth=100;
										// $newheight=($height/$width)*$newwidth;
										// $tmp=imagecreatetruecolor($newwidth,$newheight);
										
										imagecopyresampled($tmp,$src,0,0,0,0,$width,$height,$width,$height);
										
										$filename="/home/cpallapo/cs418_html/proj4/images/".uniqid().$_FILES['image_filename']['name'];
										
										imagegif($tmp,$filename,100);
									}									
								}

								if($emailoption == "html"){
									$activation_code=md5(time() . $msec);
									$password = md5($password);
									$to = $email;
									$subject = "Account Activation";
									$message = "Welcome to the IPL Discussion Forum <br><br>";
									$message .= "<html><a href=\"https://weiglevm.cs.odu.edu/~cpallapo/proj4/confirm.php"."?id=$activation_code\">Click here to confirm</a></html>";
									$message .= "<br><br>Thanks <br> HallaBol ";
									$headers = "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= "Content-Transfer-Encoding: 7bit\r\n";
									$headers .= "From: HallaBol\r\n";

									$mailsent = mail($to, $subject, $message, $headers);
									if($mailsent){
										$insert_query = "insert into proj4_members(name,username,password,email,activation_code) values('$name','$username','$password','$email','$activation_code')";
										$insert_result = $con->query($insert_query);
										$_SESSION['success'] = 1;	
										$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$uploadimage','$username','$type')";
										$image_exec=$con->query($image_query) or die('image not inserted');

										$profile_page = "insert into proj4_profile_pages(user) values ('$username') ";
										$profile_page_res = $con->query($profile_page);

										$profile_entered_query = "insert into proj4_profile_page_display (username) values ('$username')";
										$profile_entered_exec = $con->query($profile_entered_query)or die($con->error);

																
									}
								}

								if($emailoption == "plain"){
									$activation_code = md5(time() . $msec);
									$password = md5($password);
									$to = $email;
									$subject = "Account Activation";
									$message = "Welcome to the IPL Discussion Forum\n\n";
									$message .= "Copy and Paste the below URL in address bar to activate your account!!\n\n";
									$message .= "https://weiglevm.cs.odu.edu/~cpallapo/proj4/confirm.php"."?id=$activation_code\n";
									$message .= "\r\n\nThanks \n HallaBol";
									$headers = "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= "Content-Transfer-Encoding: 7bit\r\n";
									$headers .= "From: HallaBol\r\n";

									$mailsent = mail($to, $subject, $message, $headers);
									if($mailsent){
										$insert_query = "insert into proj4_members(name,username,password,email,activation_code) values('$name','$username','$password','$email','$activation_code')";
										$insert_result = $con->query($insert_query);
										$_SESSION['success'] = 1;							
										$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$uploadimage','$username','$type')";
										$image_exec=$con->query($image_query) or die('image not inserted');

										$profile_page = "insert into proj4_profile_pages(user) values ('$username') ";
										$profile_page_res = $con->query($profile_page);

										$profile_entered_query = "insert into proj4_profile_page_display (username) values ('$username')";
										$profile_entered_exec = $con->query($profile_entered_query)or die($con->error);

										
									}
								}
								echo 3;
							}
							else if(!$image){
						
								if($emailoption == "html"){
									$activation_code=md5(time() . $msec);
									$password = md5($password);
									$to = $email;
									$subject = "Account Activation";
									$message = "Welcome to the IPL Discussion Forum <br><br>";
									$message .= "<html><a href=\"https://weiglevm.cs.odu.edu/~cpallapo/proj4/confirm.php"."?id=$activation_code\">Click here to confirm</a></html>";
									$message .= "<br><br>Thanks <br> HallaBol ";
									$headers = "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= "Content-Transfer-Encoding: 7bit\r\n";
									$headers .= "From: HallaBol\r\n";

									$mailsent = mail($to, $subject, $message, $headers);
									if($mailsent){
										$insert_query = "insert into proj4_members(name,username,password,email,activation_code) values('$name','$username','$password','$email','$activation_code')";
										$insert_result = $con->query($insert_query);
										$_SESSION['success'] = 1;	
										$avatar_default=addslashes(file_get_contents("./images/default.png"));
										$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$avatar_default','$username','image/png')";
										$image_exec=$con->query($image_query) or die('image not inserted'.$con->error);

										$profile_page = "insert into proj4_profile_pages(user) values ('$username') ";
										$profile_page_res = $con->query($profile_page);

										$profile_entered_query = "insert into proj4_profile_page_display (username) values ('$username')";
										$profile_entered_exec = $con->query($profile_entered_query)or die($con->error);

																
									}
								}

								if($emailoption == "plain"){
									$activation_code = md5(time() . $msec);
									$password = md5($password);
									$to = $email;
									$subject = "Account Activation";
									$message = "Welcome to the IPL Discussion Forum\n\n";
									$message .= "Copy and Paste the below URL in address bar to activate your account!!\n\n";
									$message .= "https://weiglevm.cs.odu.edu/~cpallapo/proj4/confirm.php"."?id=$activation_code\n";
									$message .= "\r\n\nThanks \n HallaBol";
									$headers = "MIME-Version: 1.0\r\n";
									$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
									$headers .= "Content-Transfer-Encoding: 7bit\r\n";
									$headers .= "From: HallaBol\r\n";

									$mailsent = mail($to, $subject, $message, $headers);
									if($mailsent){
										$insert_query = "insert into proj4_members(name,username,password,email,activation_code) values('$name','$username','$password','$email','$activation_code')";
										$insert_result = $con->query($insert_query);
										$_SESSION['success'] = 1;							
										$avatar_default=addslashes(file_get_contents("./images/default.png"));
										$image_query="insert into proj4_avatar_images(image,image_username,image_type) values ('$avatar_default','$username','image/png')";
										$image_exec=$con->query($image_query) or die('image not inserted'.$con->error);

										$profile_page = "insert into proj4_profile_pages(user) values ('$username') ";
										$profile_page_res = $con->query($profile_page);

										$profile_entered_query = "insert into proj4_profile_page_display (username) values ('$username')";
										$profile_entered_exec = $con->query($profile_entered_query)or die($con->error);

									
										
									}
								}
								echo 3;
							}
						}
					/*}*/				
				//}				
			}
		}
	}
?>

