<?php 
	$comAuthVal = $_POST['commentAuth'];	

	if($comAuthVal != 1){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}

	else if($comAuthVal == 1){ 

		$authVal = $_POST['threadCommentAuth'];


		session_start();

		include "dbconnect.php";

		if($authVal == 1){


			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$post_user = $_SESSION['username'];
			$commentVal = $_POST['threadComment'];
			$commentVal = test_input($commentVal);

			/*echo $commentVal;
			echo strlen($commentVal);*/

			$team_id = $_POST['team_id'];
			$post_id = $_POST['post_id'];

			$delete_check = "select username from proj4_members where username = '$post_user'";
			$delete_check_res = $con->query($delete_check) or die ("1:".$con->error);;
			$delete_check_val = $delete_check_res->fetch_assoc();

			if($delete_check_val['username'] != $post_user){
				echo 0; // user deleted
			}
			else if($delete_check_val['username'] == $post_user){
				if(strlen($commentVal) == 0){
					echo 1; // comment value 0
				}
				else if(strlen($commentVal) != 0){
					
				//echo $commentVal;
					$name = "select username,name from proj4_members where username = '$post_user'";
					$name_result = $con->query($name) or die ($con->error);
					$name_val = $name_result->fetch_assoc();
					$post_user_name = $name_val['name'];
					
					$insert="insert into proj4_reply(team_id,p_post_id,member_name,message) values('$team_id','$post_id','$post_user_name','$commentVal')";
					$insert_result = $con->query($insert)or die($con->error);

					$repcount = "select count(reply_id) as repcount from proj4_reply p4r,proj4_members p4m where p4m.name = p4r.member_name and p4m.username = '$post_user'";
					$repcount_res = $con->query($repcount);
					$repcount_val = $repcount_res->fetch_assoc();

					$postcount = "select count(post_id) as postcount from proj4_posts p4p,proj4_members p4m where p4m.name = p4p.member_name and p4m.username = '$post_user'";
					$postcount_res = $con->query($postcount);
					$postcount_val = $postcount_res->fetch_assoc();

					$repcnt = $repcount_val['repcount'];
					$postcnt = $postcount['postcount'];

					$totcount = $repcnt + $postcnt;

					if($totcount <= 2){
						$update_rank = "update proj4_members set rank = 'newbie' where username = '$post_user'";
						$update_rank_res = $con->query($update_rank);
					}
					if($totcount > 2 && $totcount <=4){
						$update_rank = "update proj4_members set rank = 'journey man' where username = '$post_user'";
						$update_rank_res = $con->query($update_rank);
					}
					if($totcount > 4){
						$update_rank = "update proj4_members set rank = 'master' where username = '$post_user'";
						$update_rank_res = $con->query($update_rank);
					}
					echo 2;
				}
			}
		}
		else if($authVal == 2){
			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$post_user = $_SESSION['username'];
			$discTitle = $_POST['discussionname'];
			$discComment = $_POST['discussioncomment'];


			$discTitle = test_input($discTitle);
			$discComment = test_input($discComment);

			$discTitle = $con->real_escape_string($discTitle);
			$discComment = $con->real_escape_string($discComment);

			/*echo $commentVal;
			echo strlen($commentVal);*/

			$team_id = $_POST['team_id'];

			$delete_check = "select username,rank,role from proj4_members where username = '$post_user'";
			$delete_check_res = $con->query($delete_check) or die ("1:".$con->error);;
			$delete_check_val = $delete_check_res->fetch_assoc();

			$post_user_rank = $delete_check_val['rank'];
			$role_user = $delete_check_val['role'];

			$image_limit = "select image_limit from proj4_images_limit where user_rank = '$post_user_rank'";
			$image_limit_res = $con->query($image_limit);
			$image_limit_val = $image_limit_res->fetch_assoc();

			$image_max_limit = $image_limit_val['image_limit'];

			if($delete_check_val['username'] != $post_user){
				echo 0; // user deleted
			}
			else if($delete_check_val['username'] == $post_user){				
				if( (strlen($discTitle) == 0) || (strlen($discComment) == 0) ){
					echo 1;
				}
				else if( (strlen($discTitle) != 0) && (strlen($discComment) != 0) ){

					$name ="select username,name from proj4_members where username = '$post_user'";
					$name_result = $con->query($name) or die ("1:".$con->error);
					
					$name_val = $name_result->fetch_assoc();

					$post_user_name = $name_val['name'];
					/*echo hi;
					echo $post_user_name;*/
					
					$images_array="";
					$ImageDir ="/home/cpallapo/cs418_html/proj4/images/";

					if($_FILES['discussion_image']['tmp_name'][0]){
						$num_files=count($_FILES['discussion_image']['tmp_name']);
					}
					else{
						$num_files=0;
					}

					$extensions_count=0;

					for($j=0;$j<$num_files;$j++){
						$user_post_images=stripslashes($_FILES['discussion_image']['name'][$j]);
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
							if($num_files>=0 && $num_files<= $image_max_limit){
								for($i=0;$i<$num_files;$i++){	
									if(is_uploaded_file($_FILES['discussion_image']['tmp_name'][$i])){
										//echo "entered";
										$id=uniqid();
										$images_array .=$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i].'|';
										$Imagename=$ImageDir.$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i];
										move_uploaded_file($_FILES['discussion_image']['tmp_name'][$i],$Imagename);										
									}
								}
								$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id,images) values('$post_user_name','$discTitle','$discComment','$team_id','$images_array')";
								$insert_result = $con->query($insert) or die ("2:".$con->error);								
							}
							else{
								echo 3;
							}							
						}
					
						else if($post_user_rank=="journey man"){
							if($num_files>=0 && $num_files<= $image_max_limit){
								for($i=0;$i<$num_files;$i++){	
									if(is_uploaded_file($_FILES['discussion_image']['tmp_name'][$i])){
										$id=uniqid();
										$images_array .=$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i].'|';
										$Imagename=$ImageDir.$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i];
										move_uploaded_file($_FILES['discussion_image']['tmp_name'][$i],$Imagename);								
									}
								}
								$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id,images) values('$post_user_name','$discTitle','$discComment','$team_id','$images_array')";
								$insert_result = $con->query($insert) or die ("2:".$con->error);
							}							
							else{
								echo 3;
							}
						}
						else if($post_user_rank=="newbie"){
							if($num_files>=0 && $num_files<= $image_max_limit){
								for($i=0;$i<$num_files;$i++){	
									if(is_uploaded_file($_FILES['discussion_image']['tmp_name'][$i])){
										$id=uniqid();
										$images_array .=$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i].'|';
										$Imagename=$ImageDir.$post_user."_".$id."_".$_FILES['discussion_image']['name'][$i];
										move_uploaded_file($_FILES['discussion_image']['tmp_name'][$i],$Imagename);
										
									}
								}
								$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id,images) values('$post_user_name','$discTitle','$discComment','$team_id','$images_array')";
								$insert_result = $con->query($insert) or die ("2:".$con->error);								
							}
							else{
								echo 3;
							}	
						}

						if($insert_result){
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
							echo 2;
						}
						
					}
					else{
						echo 6;
					}
					/*$insert ="insert into proj4_posts(member_name,post_title,message,t_team_id) values('$post_user_name','$discTitle','$discComment','$team_id')";
					$insert_result = $con->query($insert) or die ("2:".$con->error);*/					
				}
			}
		}		
	}
?>

