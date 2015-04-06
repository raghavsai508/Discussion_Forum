<?php

	session_start();

    if($_SESSION['signuser'] == 0){
       header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
    }

    else if($_SESSION['signuser'] == 1){
    	include "dbconnect.php";

    	$_SESSION['profileUpdate'] = 0;

    	$user = $_SESSION['username'];
    	$role = $_GET['role'];

    	if($role = 7){
    		$num_pages = $_GET['num_pages'];

    		$update = "update proj4_profile_pages set pages ='$num_pages' where user = '$user'";
			$update_result = $con->query($update) or die ($con->error);	

			if ($update_result > 0){
				$_SESSION['profileUpdate'] = 1;
				header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/profile.php');

			}
    	}
    }
    else{
    	header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
    }
?>
