<?php

	$authVal1 = $_POST['checkForgotAuth'];

	session_start();

	include "dbconnect.php";	


	if($authVal1 != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($authVal1 == 1){

		$code = $_POST['code'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		$conpass = $_POST['conpass'];

		if($pass != $conpass){
			echo 2;
		}
		else if($pass == $conpass){
			$code_check = "select code,email from proj4_forgot where email = '$email' and code = '$code'";
			$code_check_res = $con->query($code_check);
			$code_check_value = $code_check_res->fetch_assoc();

			if($code_check_value['code'] != $code || $code_check_value['email'] != $email){
				echo 0;
			}
			else if($code_check_value['code'] == $code && $code_check_value['email'] == $email){
				$pass = md5($pass);

				$forgot_pass = "update proj4_members set password = '$pass' where email = '$email'";
				$forgot_pass_res = $con->query($forgot_pass);

				$_SESSION['forgotpassword'] = 1;

				echo 1;
			}
		}		
	}
?>