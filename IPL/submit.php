<?php
	
	session_start();
	$username=$_SESSION['username'];
	include "dbconnect.php";	

	$newdisc = $_POST['newdisc'];
	$viewthread = $_GET['viewthread'];
	$team_id = $_POST['team_id'];
	$post_id = $_POST['post_id'];
	//echo $viewthread;

	if ($newdisc == 1){
		
		$team_id = $_GET['team_id'];

		$comment = $_POST['discussioncomment'];
		$comment = trim($comment);	
		$comment = stripslashes($comment);
		$comment = htmlspecialchars($comment);
		$comment = mysqli_real_escape_string($con,$comment);
		//echo $comment;

		$title = $_POST['discussionname'];
		$title = trim($title);	
		$title = stripslashes($title);
		$title = htmlspecialchars($title);
		$title = mysqli_real_escape_string($con,$title);

		
			$name ="select username,name from proj4_members where username = '$username'";
			$name_result = $con->query($name) or die ("1:".$con->error);
			
			$name_val = $name_result->fetch_assoc();

			$post_user_name = $name_val['name'];

			

			$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id) values('$post_user_name','$title','$comment','$team_id')";
			$insert_result = $con->query($insert) or die ("2:".$con->error);

			$rep_user = $_SESSION['username'];
			
			$repcount = "select count(reply_id) as repcount from proj4_reply p4r,proj4_members p4m where p4m.name = p4r.member_name and p4m.username = '$rep_user'";
			$repcount_res = $con->query($repcount);
			$repcount_val = $repcount_res->fetch_assoc();

			$postcount = "select count(post_id) as postcount from proj4_posts p4p,proj4_members p4m where p4m.name = p4p.member_name and p4m.username = '$rep_user'";
			$postcount_res = $con->query($postcount);
			$postcount_val = $postcount_res->fetch_assoc();

			$repcnt = $repcount_val['repcount'];
			$postcnt = $postcount['postcount'];

			$totcount = $repcnt + $postcnt;

			if($totcount <= 2){
				$update_rank = "update proj4_members set rank = 'newbie' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}
			if($totcount > 2 && $totcount <=4){
				$update_rank = "update proj4_members set rank = 'journey man' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}
			if($totcount > 4){
				$update_rank = "update proj4_members set rank = 'master' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}
			header( 'Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewTeam?team_id='.$team_id );	
	}
	else if($viewthread == 2){

		$team_id = $_POST['team_id'];
		$post_id = $_POST['post_id'];
		$comment1 = $_POST['comment1'];

		$comment1 = trim($comment1);	
		$comment1 = stripslashes($comment1);
		$comment1 = htmlspecialchars($comment1);
		$comment1 = mysqli_real_escape_string($con,$comment1);

		$rep_user = $_SESSION['username'];

		if (strlen($comment1)==0){

			echo "<script>alert('You need to type something before you submit');</script>";
			header( 'refresh:0,https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1' ) ;
		}

		else{
			$name = "select username,name from proj4_members where username = '$username'";
			$name_result = $con->query($name) or die ($con->error);
			$name_val = $name_result->fetch_assoc();
			$post_user_name = $name_val['name'];
			
			$insert="insert into proj4_reply(team_id,p_post_id,member_name,message) values('$team_id','$post_id','$post_user_name','$comment1')";
			$insert_result = $con->query($insert)or die($con->error);

			$repcount = "select count(reply_id) as repcount from proj4_reply p4r,proj4_members p4m where p4m.name = p4r.member_name and p4m.username = '$rep_user'";
			$repcount_res = $con->query($repcount);
			$repcount_val = $repcount_res->fetch_assoc();

			$postcount = "select count(post_id) as postcount from proj4_posts p4p,proj4_members p4m where p4m.name = p4p.member_name and p4m.username = '$rep_user'";
			$postcount_res = $con->query($postcount);
			$postcount_val = $postcount_res->fetch_assoc();

			$repcnt = $repcount_val['repcount'];
			$postcnt = $postcount['postcount'];

			$totcount = $repcnt + $postcnt;

			if($totcount <= 2){
				$update_rank = "update proj4_members set rank = 'newbie' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}
			if($totcount > 2 && $totcount <=4){
				$update_rank = "update proj4_members set rank = 'journey man' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}
			if($totcount > 4){
				$update_rank = "update proj4_members set rank = 'master' where username = '$rep_user'";
				$update_rank_res = $con->query($update_rank);
			}

			header( 'Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1' ) ;
			
		}
	}


	else{
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}


		
	$name_result->free();
	$insert_result->free();
	$con->close();
?>
