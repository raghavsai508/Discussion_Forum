<?php


	$con=mysqli_connect("localhost","cpallapo","getlost1","cpallapo");

		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}

	$post_id=$_REQUEST['post_id'];
	$team_id=$_REQUEST['team_id'];

	//echo 1;
	$from=$_REQUEST['from'];
	$edit_user=$_REQUEST['edited_user'];
	$page=$_REQUEST['curpage'];

	if($from==1){
		$edit_message = $_REQUEST['textarea'];
		$edit_message = trim($edit_message);
		$edit_message = stripslashes($edit_message);
		$edit_message = htmlspecialchars($edit_message);
		$edit_message = mysqli_real_escape_string($con,$edit_message);
		
		//$date_time=date("y/m/d G:i:s<br>", time());
		$date_time=$con->query("select NOW()");
		$date_time_fetch=$date_time->fetch_assoc();
		$date_time_result=$date_time_fetch['NOW()'];
		
		$edit_team_comment="update proj4_posts set message='$edit_message',time_edited='$date_time_result',edited_by='$edit_user' where post_id='$post_id' and t_team_id='$team_id'";
		$edit_team_comment_result=$con->query($edit_team_comment) or die ($con->error); 
		
		header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id);
	}
	if($from==2){

		$edit_message = $_REQUEST['textarea'];
		$edit_message = trim($edit_message);
		$edit_message = stripslashes($edit_message);
		$edit_message = htmlspecialchars($edit_message);
		$edit_message = mysqli_real_escape_string($con,$edit_message);

		$date_time=$con->query("select NOW()");
		$date_time_fetch=$date_time->fetch_assoc();
		$date_time_result=$date_time_fetch['NOW()'];

		$team_search_query="select t_team_id from proj4_posts where post_id='$post_id'";
		$team_search_exec=$con->query($team_search_query);
		$team_search=$team_search_exec->fetch_assoc();
		if($team_search['t_team_id']==""){
			echo 0;
		}
		else{
			if (strlen($edit_message)==0){
				echo 1;
			}
			else{
				$edit_team_comment="update proj4_posts set message='$edit_message',time_edited='$date_time_result',edited_by='$edit_user' where post_id='$post_id' and t_team_id='$team_id'";
				$edit_team_comment_result=$con->query($edit_team_comment) or die ($con->error); 

				echo 2;
			}
		}
		
	}

	if($from==3)
	{
		$reply_id=$_REQUEST['reply_id'];

		$edit_message = $_REQUEST['textarea'];
		$edit_message = trim($edit_message);
		$edit_message = stripslashes($edit_message);
		$edit_message = htmlspecialchars($edit_message);
		$edit_message = mysqli_real_escape_string($con,$edit_message);
		
	
		$date_time=$con->query("select NOW()");
		$date_time_fetch=$date_time->fetch_assoc();
		$date_time_result=$date_time_fetch['NOW()'];

		$team_search_query="select t_team_id from proj4_posts where post_id='$post_id'";
		$team_search_exec=$con->query($team_search_query);
		$team_search=$team_search_exec->fetch_assoc();
		if($team_search['t_team_id']==""){
			echo 0;
		}
		else{
			if (strlen($edit_message)==0){
				echo 1;
			}
			else{
		
				$edit_team_comment="update proj4_reply set message='$edit_message',reply_time_edited='$date_time_result',reply_edited_by='$edit_user' where p_post_id='$post_id' and team_id='$team_id' and reply_id='$reply_id'";
				$edit_team_comment_result=$con->query($edit_team_comment) or die ($con->error); 
				echo 2;
			}
		}			
	}
?>