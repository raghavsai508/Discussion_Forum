<?php	
	$authVal = $_POST['checkLoginAuth'];

	if($authVal != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($authVal == 1){

		session_start();
		include "dbconnect.php";

		$_SESSION['username'] = $_POST['user'];
		$_SESSION['password'] = $_POST['pass'];
		$_SESSION['remember'] = $_POST['remember'];
		$_SESSION['admin_auth'] = 0;
		$_SESSION['signuser'] = 0;		

		function test_input($data){
		   	$data = trim($data);
		   	$data = stripslashes($data);
		   	$data = htmlspecialchars($data);		   	
		   	return $data;
		}

		$username =$_SESSION['username'];		
		$password =$_SESSION['password'];		
		$password = md5($password);		

		$remember = $_SESSION['remember'];

		$username = test_input($username);
		$password = test_input($password);
		$remember = test_input($remember);

		$username = $con->real_escape_string($username);
		$password = $con->real_escape_string($password);
		$remeber = $con->real_escape_string($remeber);
		
		$login_query = "select username,password,role,activation
						from proj4_members
						where username = '$username'
						and password = '$password'";

		$login_result = $con->query($login_query);
		$login_value = $login_result->fetch_assoc();		
		
		if($username != $login_value['username'] || $password != $login_value['password']){
		echo 0; 
		}
		else if ($login_value['username'] == $username && $login_value['password'] == $password){
			if($login_value['activation'] == 0){
				echo 2;
			}
			else if($login_value['activation'] == 1){
				$_SESSION['signuser'] = 1;
				if ($remember == "remember"){
					setcookie(session_name(),session_id(),time()+$life);   /* expire in 10 minute */
				}
				if ($login_value['role'] == 'admin'){
					$_SESSION['admin_auth'] = 1;
					$_SESSION['permission']	= 1;
				}
				else if($login_value['role'] == 'moderator'){
					$_SESSION['mod_auth'] = 1;
					$_SESSION['permission']	= 1;
				}
				echo 1;
			}		
		}		
	}
?>

