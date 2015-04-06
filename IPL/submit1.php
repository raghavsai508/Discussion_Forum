<?php
	
	
	
	session_start();
	$username=$_SESSION['username'];
	$con=mysqli_connect("localhost","cpallapo","getlost1","cpallapo");
	//Check connection

	if (mysqli_connect_errno()){
		 echo "Failed to connect to MySQL: " . mysqli_connect_error();
	 }

	$newdisc = $_REQUEST['newdisc'];
	$viewthread = $_REQUEST['viewthread'];
	$team_id = $_REQUEST['team_id'];
	$post_id = $_REQUEST['post_id'];
	
	//echo 1;
	
	// if($viewthread == 2){
	
	// echo 1;
	
	// }
	
	// //echo $viewthread;

	if ($newdisc == 1){
		
		$team_id = $_REQUEST['team_id'];

		$comment = $_REQUEST['comment'];
		$comment = trim($comment);	
		$comment = stripslashes($comment);
		$comment = htmlspecialchars($comment);
		$comment = mysqli_real_escape_string($con,$comment);
		echo $comment;

		$title = $_REQUEST['name'];
		$title = trim($title);	
		$title = stripslashes($title);
		$title = htmlspecialchars($title);
		$title = mysqli_real_escape_string($con,$title);

		if ((strlen($comment)==0) || (strlen($title)==0)){

			echo "<script>alert('You need to type both title and comment before you submit');</script>";
			header( 'refresh:0,https://weiglevm.cs.odu.edu/~rcheedal/proj2_5/viewTeam?team_id='.$team_id ) ;
		}

		else{
			$name ="select username,name from proj4_members where username = '$username'";
			$name_result = $con->query($name) or die ("1:".$con->error);
			
			$name_val = $name_result->fetch_assoc();

			$post_user_name = $name_val['name'];

			$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id) values('$post_user_name','$title','$comment','$team_id')";
			$insert_result = $con->query($insert) or die ("2:".$con->error);


			header( 'Location: https://weiglevm.cs.odu.edu/~rcheedal/proj2_5/viewTeam?team_id='.$team_id );
		}
	}
	else if($viewthread == 2){

		//echo 1;
		
		$team_id = $_REQUEST['team_id'];
		$post_id = $_REQUEST['post_id'];
		$comment1 = $_REQUEST['comment1'];

		$comment1 = trim($comment1);	
		$comment1 = stripslashes($comment1);
		$comment1 = htmlspecialchars($comment1);
		$comment1 = mysqli_real_escape_string($con,$comment1);

		$team_search_query="select t_team_id from proj4_posts where post_id='$post_id'";
		$team_search_exec=$con->query($team_search_query);
		$team_search=$team_search_exec->fetch_assoc();
		if($team_search['t_team_id']=="")
		{
			echo 0;
		}
		else
		 {
			//echo 1;
			if (strlen($comment1)==0)
			{
				echo 1;
			}
			// {

				// echo "<script>alert('You need to type something before you submit');</script>";
				// header( 'refresh:0,https://weiglevm.cs.odu.edu/~rcheedal/proj2_5/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1' ) ;
			
			// }
			//echo 1;
		else{
				$name = "select username,name from proj4_members where username = '$username'";
				$name_result = $con->query($name) or die ($con->error);
				$name_val = $name_result->fetch_assoc();
				$post_user_name = $name_val['name'];
				
				$insert="insert into proj4_reply(team_id,p_post_id,member_name,message) values('$team_id','$post_id','$post_user_name','$comment1')";
				$insert_result = $con->query($insert)or die($con->error);
				
				echo 2;
				//header( 'refresh:0,https://weiglevm.cs.odu.edu/~rcheedal/proj2_5/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1' ) ;
			
		}
		
		}

		
	}


		
	// $name_result->free();
	// $insert_result->free();
	// $con->close();
?>
