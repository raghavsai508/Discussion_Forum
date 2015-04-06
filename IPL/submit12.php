<?php

session_start();
$username=$_SESSION['username'];
include "dbconnect.php";	

$viewthread=$_REQUEST['thread'];
$comment1=$_REQUEST['comment1'];
$team_id = $_REQUEST['team_id'];
$post_id = $_REQUEST['post_id'];

//echo 1;
if($viewthread==2)
 {
	$comment1 = trim($comment1);	
	$comment1 = stripslashes($comment1);
	$comment1 = htmlspecialchars($comment1);
	$comment1 = mysqli_real_escape_string($con,$comment1);

	//echo 1;
	
	$rep_user = $_SESSION['username'];
	
	$user_search_query="select username from proj4_members where username='$rep_user'";
	$user_search_exec=$con->query($user_search_query);
	$user_search=$user_search_exec->fetch_assoc();


	
	if($user_search['username']==""){
		echo 1;
	}
	else if (strlen($comment1)==0 ){
	
		if($_FILES['reply_images']['size'][0]>0){
			image_insert($rep_user,$post_id,$team_id,$comment1);			
		}
		else{
			echo 2;
		}
	}
	else{
		image_insert($rep_user,$post_id,$team_id,$comment1);
	}
}


function image_insert($rep_user,$post_id,$team_id,$comment1){
	global $con;
					
	$name = "select username,name,rank from proj4_members where username = '$rep_user'";
	$name_result = $con->query($name) or die ($con->error);
	//echo $rep_user;
	$name_val = $name_result->fetch_assoc();
	$post_user_name = $name_val['name'];
	$post_user_rank=$name_val['rank'];

	$image_limit = "select image_limit from proj4_images_limit where user_rank = '$post_user_rank'";
	$image_limit_res = $con->query($image_limit);
	$image_limit_val = $image_limit_res->fetch_assoc();

	$image_max_limit = $image_limit_val['image_limit'];
	
	$images_array="";
	$ImageDir ="/home/cpallapo/cs418_html/proj4/images/";
	if($_FILES['reply_images']['tmp_name'][0]){
		$num_files=count($_FILES['reply_images']['tmp_name']);
	}
	else{
		$num_files=0;
	}

	$extensions_count=0;
	
	//echo $num_files;
	
	for($j=0;$j<$num_files;$j++)
	{
	//echo 1;
		$user_post_images=stripslashes($_FILES['reply_images']['name'][$j]);
		$extension=pathinfo($user_post_images,PATHINFO_EXTENSION);
		$extension=strtolower($extension);
		if(($extension!="jpeg") && ($extension!="jpg") && ($extension!="png") && ($extension!="gif")){
				
		}
		else{
			$extensions_count++;
		}
	
	}
	
	if($extensions_count==$num_files){
		if($post_user_rank=="master"){
			if($num_files>=0 && $num_files<=$image_max_limit){
				for($i=0;$i<$num_files;$i++){	
						if(is_uploaded_file($_FILES['reply_images']['tmp_name'][$i])){
							$uniq=uniqid();

							$images_array .=$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i].'|';
							$Imagename=$ImageDir.$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i];
							move_uploaded_file($_FILES['reply_images']['tmp_name'][$i],$Imagename);							
						}
					}
					$insert="insert into proj4_reply(team_id,p_post_id,member_name,message,images) values('$team_id','$post_id','$post_user_name','$comment1','$images_array')";
					$insert_result = $con->query($insert)or die($con->error);					
					user_rank($rep_user);
					echo 5;
					
			}
			else{
				echo 3;
			}
		}
		else if($post_user_rank=="journey man"){
			if($num_files>=0 && $num_files<=$image_max_limit){
				for($i=0;$i<$num_files;$i++){
					if(is_uploaded_file($_FILES['reply_images']['tmp_name'][$i])){
						$uniq=uniqid();
						$images_array .=$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i].'|';
						$Imagename=$ImageDir.$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i];
						move_uploaded_file($_FILES['reply_images']['tmp_name'][$i],$Imagename);
							
					}
				}
				$insert="insert into proj4_reply(team_id,p_post_id,member_name,message,images) values('$team_id','$post_id','$post_user_name','$comment1','$images_array')";
				$insert_result = $con->query($insert)or die($con->error);
				user_rank($rep_user);
				echo 5;
			}
			else{
				echo 3;
			}
		}
		else if($post_user_rank=="newbie"){
			if($num_files>=0 && $num_files<=$image_max_limit){
				for($i=0;$i<$num_files;$i++){
					if(is_uploaded_file($_FILES['reply_images']['tmp_name'][$i])){
						$uniq=uniqid();
						$images_array .=$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i].'|';
						$Imagename=$ImageDir.$rep_user."_".$uniq."_".$_FILES['reply_images']['name'][$i];
						move_uploaded_file($_FILES['reply_images']['tmp_name'][$i],$Imagename);
							
					}
				}
				$insert="insert into proj4_reply(team_id,p_post_id,member_name,message,images) values('$team_id','$post_id','$post_user_name','$comment1','$images_array')";
				$insert_result = $con->query($insert)or die($con->error);
				user_rank($rep_user);
				echo 5;
			}
			else{
				echo 3;
			}
		}	
	}
	else{
		echo 4;
	}
}


function user_rank($rep_user){
	global $con;
	$repcount = "select count(reply_id) as repcount from proj4_reply p3r,proj4_members p3m where p3m.name = p3r.member_name and p3m.username = '$rep_user'";
	$repcount_res = $con->query($repcount);
	$repcount_val = $repcount_res->fetch_assoc();

	$postcount = "select count(post_id) as postcount from proj4_posts p3p,proj4_members p3m where p3m.name = p3p.member_name and p3m.username = '$rep_user'";
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

// // header( 'Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id='.$post_id.'&team_id='.$team_id.'&page=1' ) ;
}

?>