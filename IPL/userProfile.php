<?php
	session_start();	

	if($_SESSION['signuser'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1){
		
		include 'dbconnect.php';

		$username = $_GET['seeUser'];

		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$username = test_input($username);
		$username = $con->real_escape_string($username);


		$user_check = "select username,name from proj4_members where username ='$username'";
		$user_check_res = $con->query($user_check);
		$user_check_val = $user_check_res->fetch_assoc();

		if($user_check_val['username'] != $username){
			header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		}
		else if($user_check_val['username'] == $username){ 
		include 'header.php'; ?>

		<script>		
			$( document ).ready(function() {		
				
				$("#showPosts1").click(function(){			
					$("#profilePosts").slideToggle("slow");
				});	
			});
		</script>

					<div class="primaryMenu">
						<div class="wrapper">      
							<div class="masthead-menu">
								<ul id="yw1">
									<?php if($_SESSION['signuser'] == 1){ ?>
										<li ><a href="index.php">Home</a></li>
									<?php } ?>								
									<?php if ($_SESSION['admin_auth'] == 1){ ?>
										<li><a href="admin.php">Admin</a></li>									
									<?php }else if($_SESSION['mod_auth'] == 1){ ?>
										<li><a href="admin.php">Moderator</a></li>	
									<?php } ?>
									<?php if ($_SESSION['signuser'] == 1){ ?>
										<li class="right">  
											<?php
											$username1 = $_SESSION['username'];
											$name="select name,role,rank from proj4_members where username = '$username1'";
											$name_result = $con->query($name) or die ($con->error);
											$row = $name_result->fetch_assoc(); ?>
											<a href="profile.php"><?php echo $row['name'];?>&nbsp;
												(<?php echo $row['role']; ?>)&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $row['rank']; ?>
											</a>
										</li>
									<?php } ?>			
								</ul>            
							</div>
						</div>                              
					</div>
				</div>
			</div>

			<?php

				$pres_user = $username; 
				$member="select username,name,email,role,rank,time_joined,suspension,activation
							from proj4_members p4m
							where p4m.username = '$username'";
				$member_result = $con->query($member) or die ($con->error);
				$member_stats = $member_result->fetch_assoc();
				$user = $member_stats['username'];

				$pres_user1 = "select name from proj4_members where username = '$pres_user'";
				$pres_user1_result = $con->query($pres_user1) or die ($con->error);
				$pres_user1_val = $pres_user1_result->fetch_assoc();

				$member_posts = "select name,post_id,post_title,message,t_team_id,time_created,time_edited,freeze,deleted
									from proj4_members p4m,proj4_posts p4p 
									where p4m.name = p4p.member_name 
									and p4m.username = '$username'
									group by name,post_id,post_title,message,t_team_id,time_created
									order by time_created";
				$member_posts_result = $con->query($member_posts) or die ($con->error);

				$member_posts1 = "select time_created,time_edited
									from proj4_members p4m,proj4_posts p4p 
									where p4m.name = p4p.member_name 
									and p4m.username = '$username'
									group by name,post_id,post_title,message,t_team_id,time_created
									order by time_edited";
				$member_posts_result1 = $con->query($member_posts1) or die ($con->error);
				$member_posts_val1 = $member_posts_result1->fetch_assoc();

				$member_posts_total ="select count(post_id) as tot_posts
										from proj4_members p4m,proj4_posts p4p 
										where p4m.name = p4p.member_name 
										and p4m.username = '$username'
										order by time_created";
				$member_posts_total_result = $con->query($member_posts_total) or die ($con->error);
				$member_posts_total_val = $member_posts_total_result->fetch_assoc();

				$member_reply = "select reply_id,team_id,p_post_id,message,time
									from proj4_reply p4r,proj4_members p4m
									where p4r.member_name = p4m.name
									and p4m.username = '$username'
									order by time";
				$member_reply_result = $con->query($member_reply) or die ($con->error);

				$member_reply_total = "select count(p_post_id) as tot_reply
										from proj4_reply p4r,proj4_members p4m
										where p4r.member_name = p4m.name
										and p4m.username = '$username'
										order by time";
				$member_reply_total_res = $con->query($member_reply_total) or die ($con->error);
				$member_reply_total_value = $member_reply_total_res->fetch_assoc();

				$freeze_check = "select freeze from proj4_posts where post_id = '$post_id'";
				$freeze_res = $con->query($freeze_check);
				$freeze_value = $freeze_res->fetch_assoc();

				/*$profile_pages = "select pages from proj4_profile_pages where user = '$pres_user'";
				$profile_pages_result = $con->query($profile_pages) or die ($con->error);
				$profile_pages_val = $profile_pages_result->fetch_assoc();

				$num_posts_per_page=$profile_pages_val['pages'];*/

				$num_posts_per_page=5;
				if($_GET['page']){
					$page=$_GET['page'];
				}else{
					$page=1;
				}
				$pageno=($page-1)*$num_posts_per_page;
				$tot_posts = "select post_id, member_name,role,post_title,message,time_created,team_id,deleted,freeze,rank,team_name from proj4_posts p4p,proj4_teams p4t, proj4_members p4m where p4p.t_team_id = p4t.team_id and p4m.name = p4p.member_name and p4m.username = '$pres_user' order by team_id,time_created desc limit $pageno,$num_posts_per_page";
				$tot_posts_result = $con->query($tot_posts) or die ($con->error);

				$tot_posts_result_rows = mysqli_num_rows($tot_posts_result);

				$posts = "select post_id,time_created from proj4_posts p4p, proj4_members p4m where p4p.member_name = p4m.name and p4m.username = '$pres_user' order by time_created desc";
				$posts_result = $con->query($posts) or die ($con->error);

				$num_rows=$posts_result->num_rows;
				$totalpages=ceil($num_rows/$num_posts_per_page);

				$image_display_query="select image,image_type,image_id from proj4_avatar_images where image_username='$username'";
				$image_display_exec=$con->query($image_display_query)or die($con->error);

				$image_display_rows =  mysqli_num_rows($image_display_exec);

				$image_result=$image_display_exec->fetch_assoc();				

				$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);
			
			?>
			

			<div class="wrapper">
				<div class="main-content">
					<div class="hero">
						<div class="heroContent">
							<br><br>
							<ol class="breadcrumb">
								  <li><a href="index.php">Home</a></li>	
								  <li class="active">Profile &nbsp;(<?php echo $user_check_val['name']; ?>) </li>
							</ol><br>

							<div class="well well-lg well-primary">
								<div class="panel-body" >
									<div style="text-transform:uppercase; line-height:30px;">
										<div style="float:right; margin-right: 20px;">	
											<?php if($image_display_rows == 0){ ?>
												<img border="10" src="./images/default.png" width="100" height="100"/>
											<?php }else if($image_display_rows > 0){ ?>
												<a id="image_modal" href="imageDisplay.php?id=<?php echo $image_result['image_id'];?>" target="_blank"><img border="10" src="<?php echo $uri;?>" width="100" height="100"/></a><br/>								
												<!-- <img border="0" src="./assets/img/CSK.png" width="100" height="75"/> -->
											<?php } ?>											
										</div>
										
										<strong>Member Name: </strong><?php echo $member_stats['name']; ?><br>
										<strong>User Name: </strong><?php echo $member_stats['username']; ?><br>	
										<strong>Registered Email: </strong><?php echo $member_stats['email']; ?><br>							
										<strong>User Role: </strong><?php echo $member_stats['role']; ?><br>
										<strong>User Rank: </strong><?php echo $member_stats['rank']; ?><br>
										<?php 
											$regdate = date('M d, Y', strtotime($member_stats['time_joined']));
											$regtime = date('g:i a', strtotime($member_stats['time_joined']));
										?>
										<strong>Registered On: </strong><?php echo $regdate;?>, <?php echo $regtime ?><br>
										
										<!-- <a><strong>Total Replies: </strong><?php echo $member_reply_total_value['tot_reply']; ?></a><br> -->
										<strong>last posted on: </strong>
										<?php if($member_posts_val1['time_created'] > $member_posts_val1['time_edited']){
												$editdate = date('M d, Y', strtotime($member_posts_val1['time_created']));
												$edittime = date('g:i a', strtotime($member_posts_val1['time_created']));
												echo $editdate; ?>, <?php echo $edittime;
												}else if($member_posts_val1['time_created'] < $member_posts_val1['time_edited']){
													$editdate = date('M d, Y', strtotime($member_posts_val1['time_created']));
													$edittime = date('g:i a', strtotime($member_posts_val1['time_created']));
													echo $editdate; ?>, <?php echo $edittime;
												} ?><br>
										<strong>Total Posts: </strong><?php echo $member_posts_total_val['tot_posts']; ?><br><br>
									</div>									
                                </div>
                            </div>
                            <?php if($tot_posts_result_rows > 0){ ?>
	                            <div id="profilePosts">
									<div class="panel panel-primary" >
									  	<div class="panel-heading">
										 	<h3 class="panel-title">Posts</h3>
										</div>
										<div class="panel-body"> 
											<table class="table">
												<thead>      
													<tr >        
														<td><strong>Team</strong></td> 
														<td><strong>Post Title</strong></td>
														<td><strong>Message</strong></td> 													
														<td><strong>Created on</strong></td>  
													</tr>  
												</thead>
												<tbody> 
													<?php while($tot_posts_val = $tot_posts_result->fetch_assoc()){	?>
														<tr class="member"> 												
															<td class="first team">     
																<!-- <a href="viewTeam.php?team_id=<?php echo $tot_posts_val['team_id']; ?>"> --> <?php echo $tot_posts_val['team_name']; ?>
																<!-- </a> -->													
															</td>        
															
															<td><a href="viewThread.php?post_id=<?php echo $tot_posts_val['post_id'];?>&team_id=<?php echo $tot_posts_val['team_id'];?>" ><?php echo $tot_posts_val['post_title']; ?></a> <!-- <br><br> In: <a> </a> --></td> 
															<td><?php echo $tot_posts_val['message']; ?> </td>

															<td class="last" style="width:11%;">
																<?php 
																	$postdate = date('M d, Y', strtotime($tot_posts_val['time_created']));
																	$posttime = date('g:i a', strtotime($tot_posts_val['time_created']));
																?>
																<?php echo $postdate;?> <?php echo $posttime ?>
															</td>

														</tr>
													<?php }	?>
												</tbody>  
											</table>																			
										</div>
									</div>
									<div style="margin-left: 20px;">
										<ul id='bp-3-element-test'></ul>
									</div>
								</div>
							<?php }else if($tot_posts_result_rows ==0){ ?>
								<div id="profilePosts">
									<div class="panel panel-primary" >
									  	<div class="panel-heading">
										 	<h3 class="panel-title">No Posts made by <?php echo $user_check_val['name']; ?></h3>
										</div>
									</div>
								</div>
							<?php } ?>

  						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">
	   			 $(function(){
			        test("Test bootstrap v3 rendering", function(){

			            var element = $('#bp-3-element-test');

			            var options = {
			                bootstrapMajorVersion:3,
			                currentPage: <?php echo $page;?>,
			                totalPages:<?php echo $totalpages;?>,
							size:'small',
							onPageClicked: function(e,originalEvent,type,page){
			               		window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/userProfile.php?seeUser=<?php echo $username; ?>&page='+page;
			            	}
						}
			            element.bootstrapPaginator(options);
			            var list = element.children();		           
			        })
			    });
			</script>



		<?php }

	}



?>