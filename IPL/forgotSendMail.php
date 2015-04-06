<?php
	$authVal = $_POST['checkForgotMail'];	

	if($authVal != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}

	else if($authVal == 1){ 
		session_start();

		$_SESSION['search_team'] = 9;

		include "dbconnect.php";		

		$user =  $_POST['user'];
		$email = $_POST['email'];

		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$user = test_input($user);
		$email = test_input($email);

		$user = $con->real_escape_string($user);
		$email = $con->real_escape_string($email);

		$check_query = "select username from proj4_members where username = '$user'";
		$check_res = $con->query($check_query);
		$check_value = $check_res->fetch_assoc();

		if($check_value['username'] != $user){
			echo 0;
		}
		else if($check_value['username'] == $user){
			$check_query1 = "select email from proj4_members where email = '$email'";
			$check_res1 = $con->query($check_query1);
			$check_value1 = $check_res1->fetch_assoc();

			if($check_value1['email'] != $email){
				echo 1;
			}
			else if($check_value1['email'] == $email){

				function generateRandomString($length) {
				    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				    $randomString = '';
				    for ($i = 0; $i < $length; $i++) {
				        $randomString .= $characters[rand(0, strlen($characters) - 1)];
				    }
				    return $randomString;
				}

				$code = generateRandomString(8);

				$forgot_email = "select email from proj4_forgot where email = '$email'";
				$forgot_res = $con->query($forgot_email);
				$forgot_email_value = $forgot_res->fetch_assoc();

				if($forgot_email_value['email'] == $email){
					$code_update = "update proj4_forgot set code = '$code' where email = '$email'";
					$code_up_res = $con->query($code_update);
				}
				else if($forgot_email_value['email'] != $email){
					$code_insert = "insert into proj4_forgot(email,code,username) values('$email','$code','$user')";
					$code_res = $con->query($code_insert);
				}

				$to = $email;
	            $subject = "Reset Password";
	            $message = "Please enter the following code <br><br>";
	            $message .= $code;
	            $message .= "<br><br>Thanks! <br> HallaBol ";
	            $headers = "MIME-Version: 1.0\r\n";
	            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	            $headers .= "Content-Transfer-Encoding: 7bit\r\n";
	            $headers .= "From: HallaBol\r\n";

	            $mailsent = mail($to, $subject, $message, $headers);

	            if($mailsent){
	            	echo 2;
	            }
			}
		}
	}
?>