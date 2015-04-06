<?php
	session_start();
	include "dbconnect.php";
	$pres_user=$_SESSION['username'];

	echo "<br><br>".$_SESSION['admin_auth'];
	echo $_SESSION['update'];
	echo $_SESSION['signuser'];
	if ($_SESSION['signuser'] == 0 ){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}

	else {	
		$from = $_GET['from'];
		echo $from;
		if ($from == 1){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['curpage'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$delete_posts = "update proj4_posts set deleted = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$delete_posts_result = $con->query($delete_posts) or die ($con->error);

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


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewTeam.php?team_id='.$team_id.'&page=1');
		}

		else if ($from == 2){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$delete_posts = "update proj4_posts set deleted = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$delete_posts_result = $con->query($delete_posts) or die ($con->error);

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


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewTeam.php?team_id='.$team_id.'&page=1');
		}

		else if ($from == 3){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$delete_posts = "update proj4_posts set deleted = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$delete_posts_result = $con->query($delete_posts) or die ($con->error);

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


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/posts.php?page=1');
		}

		else if ($from == 4){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$page = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$freeze_posts = "update proj4_posts set freeze = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);

			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/posts.php?page='.$page);
		}

		else if ($from == 5){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$page = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$freeze_posts = "update proj4_posts set freeze = 0 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);

			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/posts.php?page='.$page);
		}

		else if ($from == 6){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$freeze_posts = "update proj4_posts set freeze = 0 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1');
		}
		else if ($from == 7){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['page'];
			$from = $_GET['from'];
			//$for = $_GET['for'];

			$freeze_posts = "update proj4_posts set freeze = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1');
		}
		

		else if ($from == 8){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['page'];
			$from = $_GET['from'];
			$name = $_GET['name'];

			$freeze_posts = "update proj4_posts set deleted = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);

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



			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$name);
		}
		

		else if ($from == 9){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['curpage'];
			$from = $_GET['from'];
			$name = $_GET['name'];

			$freeze_posts = "update proj4_posts set freeze = 0 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$name);
		}
		

		else if ($from == 10){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$team_id = $_GET['team_id'];
			$curpage = $_GET['curpage'];
			$from = $_GET['from'];
			$name = $_GET['name'];

			$freeze_posts = "update proj4_posts set freeze = 1 where post_id = '$post_id' and t_team_id = '$team_id'";
			$freeze_posts_result = $con->query($freeze_posts) or die ($con->error);


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$name);
		}

		else if ($from == 11){

			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$reply_id = $_GET['reply_id'];
			$curpage = $_GET['curpage'];
			$from = $_GET['from'];
			$name = $_GET['name'];

			$delete_reply="delete from proj4_reply where reply_id='$reply_id'";
			$delete_reply_exec=$con->query($delete_reply) or die($con_error);

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

			echo $totcount;

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


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name='.$name);
		}
		else if($from==12)
		{
			$post_id = $_GET['post_id'];
			//$p_post_id = $post_id;
			$reply_id = $_GET['reply_id'];
			$curpage = $_GET['curpage'];
			$from = $_GET['from'];
			$name = $_GET['name'];
			$team_id = $_GET['team_id'];

			$delete_reply="delete from proj4_reply where reply_id='$reply_id'";
			$delete_reply_exec=$con->query($delete_reply) or die($con_error);

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


			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1');
		}

		else{
			header('Location:http://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		}
		
		
	}
