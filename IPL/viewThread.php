<?php	
	session_start();

	include "dbconnect.php";				
	
		
	if ($_SESSION['signuser'] == 0 ){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1 ){
		$pres_user = $_SESSION['username'];
		$delete_check = "select username from proj4_members where username = '$pres_user'";
		$delete_check_res = $con->query($delete_check);
		$delete_check_val = $delete_check_res->fetch_assoc();

		if($delete_check_val['username'] != $pres_user){
			header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/session.php');
		}
		else if($delete_check_val['username'] == $pres_user){
			function test_input($data){
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}

			$post_id=$_GET['post_id'];
			$team_id=$_GET['team_id'];

			$post_id = test_input($post_id);
			$team_id = test_input($team_id);

			$post_id = $con->real_escape_string($post_id);
			$team_id = $con->real_escape_string($team_id);/**/

			

			include "header1.php";

			$_SESSION['search_team'] = $team_id;

			//echo $_SESSION['search_team'];
			
			if(!is_numeric($post_id) || !is_numeric($team_id)){ ?>


								<div class="primaryMenu">
									<div class="wrapper">      
										<div class="masthead-menu">
											<ul id="yw1">
												<li ><a href="index.php">Home</a></li>
												<li ><a href="newDiscussion.php?team_id=<?php echo $team_id; ?>">New Discussion</a></li>
												<?php if ($_SESSION['admin_auth'] == 1){ ?>
													<li><a href="admin.php">Admin</a></li>									
												<?php }else if($_SESSION['mod_auth'] == 1){ ?>
													<li><a href="admin.php">Moderator</a></li>	
												<?php } ?>
												<?php if ($_SESSION['signuser'] == 1){ ?>
												<li class="right">  
													<?php
													$username = $_SESSION['username'];
													$name="select name,role,rank from proj4_members where username = '$username'";
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
								</div><!-- END top-masthead -->
							</div><!-- END mastheadContent -->
						</div>	


						<div class="wrapper">
							<div class="main-content ">
								<div class="hero">
									<div class="heroContent">
										<br><br><br>
										<div class="well well-default">
											<div class="panel-body" style="text-align: center">
											 	The post you are looking for is not a part Discussion Forum<br><br>
												<a href="index.php">
													<button type="submit" class="btn btn-info">
														Ok!!
													</button>
												</a>			 	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
				
			<?php }else if(is_numeric($post_id) && is_numeric($team_id)){ 

				$post_check = "select post_id from proj4_posts where post_id = '$post_id' and t_team_id = '$team_id'";
				$post_check_res = $con->query($post_check);
				$post_check_val = $post_check_res->fetch_assoc();

				if($post_check_val['post_id'] != $post_id || $team_id > 8){ ?>

							<div class="primaryMenu">
								<div class="wrapper">      
									<div class="masthead-menu">
										<ul id="yw1">
											<li ><a href="index.php">Home</a></li>
											<li ><a href="newDiscussion.php?team_id=<?php echo $team_id; ?>">New Discussion</a></li>
											<?php if ($_SESSION['admin_auth'] == 1){ ?>
										<li><a href="admin.php">Admin</a></li>									
									<?php }else if($_SESSION['mod_auth'] == 1){ ?>
										<li><a href="admin.php">Moderator</a></li>	
									<?php } ?>
									<?php if ($_SESSION['signuser'] == 1){ ?>
										<li class="right">  
											<?php
											$username = $_SESSION['username'];
											$name="select name,role,rank from proj4_members where username = '$username'";
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
							</div><!-- END top-masthead -->
						</div><!-- END mastheadContent -->
						</div>	


						<div class="wrapper">
							<div class="main-content ">
								<div class="hero">
									<div class="heroContent">
										<br><br><br>
										<div class="well well-default">
											<div class="panel-body" style="text-align: center">
											 	The post you are looking for is not a part Discussion Forum<br><br>
												<a href="index.php">
													<button type="submit" class="btn btn-info">
														Ok!!
													</button>
												</a>			 	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

				<?php }else if($post_check_val['post_id'] == $post_id && $team_id < 9){ ?> 

						<script>		
							$( document ).ready(function(e) {		
								
								/*$("#commentareasubmitfull").click(function(){			
									if (($("#comment1").val()).length != 0 ) {
										$("#submissionfull").submit();
									}
									else if( ($("#comment1").val()).length == 0 ){
										$("#modal-container-309291").show();
									}
								});	
	*/

								$(".flap").click(function(){
									$("#pane"+this.id).slideToggle("slow");
							  	});
							 	

							 	$(".reply_flap").click(function(){
									$("#reply"+this.id).slideToggle("slow");
							 	});

								/*$('#submissionfull').submit(function(){
									/*var post = $("#comment1").val();
									alert(post);*
						 			$.ajax({								
										type: "POST",
										url: "commentSubmit.php",
										data:{
											'threadComment' : $("#comment1").val(),
											'team_id' : $("#team_id").val(),
											'post_id' : $("#post_id").val(),
											'commentAuth' : 1,
											'threadCommentAuth' : 1
											},
										success:function(data){
											if(data==2){
												window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=1';
											}
											else if(data==0){
												//$("#modal-container-deleted").show();
												alert('You have been deleted from the Forum. You cannot Post anymore!!');
												window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/session.php';

											}
											else if(data==1){
												//$("#modal-container-309291").show();
												alert('Please enter something to post');
											}
										}
								    }); return false;
								});		
	*/

								$("#submissionfull").submit(function(){
									
									var formDataimg=new FormData($(this)[0]);
									
									$.ajax({								
										type:"POST",
										url:"submit12.php?thread=2",
										async:false,
										cache:false,
										contentType:false,
										processData:false,
										data:formDataimg,
										success:function(data){
											if(data == 5)
											{
												window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>';
											}	
											else if(data == 1){
												alert("You have been deleted from the forum. You cannot post any messages!!");
												window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/session.php';
											}
											else if(data == 2){
												alert("Please Enter Something to post or upload an Image!!");

											}
											else if(data == 3){
												alert("Too Many Images!!");
											}
											else if(data == 4){
												alert('Image format did not match. Please upload either jpg/jpeg/png/gif !!');

											}									
										}							
									});							
								});

							 	 $(".btn1").click( function() {
										
										var test=$(this).attr("value");
										var text1=$.trim($("#textarea"+test).val());								
										$.ajax({
										
											type: "POST",
											url: "editsubmit.php",
											data:{
												  'post_id':test,
												  'team_id':$('#hidden_team_id').val(),
												  'from': 2,
												  'textarea':$.trim($("#textarea"+test).val()),
												  'edited_user':$('#edited_user').val()
												},
											success:function(data){
												if(data==0){
													alert("the post has been deleted");
													window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>';
												}
												else if(data==1){
													$("#modal-container-edit").show();
												}
												else if(data==2){
													//$("#modal-container-posted").show();
													window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>';
												}
											}
									    });							
									});
							 		$(".btn2").click( function() {
										
										var test1=$(this).attr("value");

										//alert("test1"+test1);

										var text1=$.trim($("#thisreply"+test1).val());	
										//alert("text is : "+text1);							
										$.ajax({
										
											type: "POST",
											url: "editsubmit.php",
											data:{
												  'post_id':$('#hidden_reply_post_id').val(),
												  'team_id':$('#hidden_reply_team_id').val(),
												  'from': 3,
												  'textarea':$.trim($("#thisreply"+test1).val()),
												  'edited_user':$('#edited_user').val(),
												  'reply_id':test1
												},
											success:function(data){
												if(data==0){
													//alert("the post has been deleted");
													window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>';
												}
												else if(data==1){
													//alert("type something before you submit");
													$("#modal-container-posted").show();
												}
												else if(data==2){
													//alert("your reply has been posted");
													//$("#modal-container-posted").show();
													window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>';
												}
											}
									    });							
									});

							});	
						</script>

						<?php  
							$team = "select team_id,team_name from proj4_teams where team_id = $team_id";
							$team_result = $con->query($team) or die ($con->error);
							$team_value = $team_result->fetch_assoc(); 
						?>

							<div class="primaryMenu">
									<div class="wrapper">      
										<div class="masthead-menu">
											<ul id="yw1">
												<li ><a href="index.php">Home</a></li>
												<li ><a href="newDiscussion.php?team_id=<?php echo $team_id; ?>">New Discussion</a></li>
												<?php if ($_SESSION['admin_auth'] == 1){ ?>
												<li><a href="admin.php">Admin</a></li>									
												<?php }else if($_SESSION['mod_auth'] == 1){ ?>
													<li><a href="admin.php">Moderator</a></li>	
												<?php } ?>
												<?php if ($_SESSION['signuser'] == 1){ ?>
													<li class="right">  
														<?php
														$username = $_SESSION['username'];
														$name="select name,role,rank from proj4_members where username = '$username'";
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
								</div><!-- END top-masthead -->
							</div><!-- END mastheadContent -->
						</div>	


						<?php
							$view_thread_pages = "select page_name,num_pages from proj4_pages where page_name = 'view thread'";
							$view_thread_pages_result = $con->query($view_thread_pages) or die ($con->error);
							$view_thread_pages_val = $view_thread_pages_result->fetch_assoc();

							$num_posts_per_page=$view_thread_pages_val['num_pages'];
							if($_GET['page']){
								$page=$_GET['page'];
							}else{
								$page=1;
							}

							if(!is_numeric($page)){ ?>


								<div class="wrapper">
									<div class="main-content ">
										<div class="hero">
											<div class="heroContent">
												<br><br><br>
												<div class="well well-default">
													<div class="panel-body" style="text-align: center">
													 	The page you are looking is not available!!<br><br>
														<a href="index.php">
															<button type="submit" class="btn btn-info">
																Ok!!
															</button>
														</a>			 	
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php }else if(is_numeric($page)){ ?>

							<?php 
								$pageno=($page-1)*$num_posts_per_page;
								$query="select post_id,t_team_id,member_name,username,suspension,images,role,rank,message,post_title,time_created,time_edited from proj4_posts p4p,proj4_members p4m where p4p.member_name = p4m.name and post_id='$post_id'";
								$result = $con->query($query) or die ($con->error);
								$row = $result->fetch_assoc(); 

								$pres_user1 = "select name,suspension from proj4_members where username = '$pres_user'";
								$pres_user1_result = $con->query($pres_user1) or die ($con->error);
								$pres_user1_val = $pres_user1_result->fetch_assoc();

								$query1="select reply_id,p_post_id,team_id,member_name,username,message,images,time,suspension,role,rank,reply_time_edited from proj4_reply p4r,proj4_members p4m where p4m.name = p4r.member_name and p_post_id='$post_id' and team_id='$team_id' order by time desc limit $pageno,$num_posts_per_page";
								$reply_message=$con->query($query1) or die ($con->error);

								$query2="select p_post_id,member_name,message,time from proj4_reply where p_post_id='$post_id' and team_id='$team_id'";
								$rows_count=$con->query($query2) or die ($con->error);

								$delete_check = "select deleted from proj4_posts where post_id = '$post_id' and t_team_id = '$team_id'";
								$delete_check_res = $con->query($delete_check);
								$delete_check_value = $delete_check_res->fetch_assoc();

								//echo $team_id;

								$image_limit_res = $con->query("select image_limit,username from proj4_images_limit p4il,proj4_members p4m where p4m.rank = p4il.user_rank and p4m.username = '$pres_user'");
								$image_limit_val = $image_limit_res->fetch_assoc();

								$image_max_limit = $image_limit_val['image_limit'];

								$team_name = "select team_name from proj4_teams where team_id = '$team_id'";
								$team_name_res = $con->query($team_name);
								$team_name_value = $team_name_res->fetch_assoc();

								$num_rows=$rows_count->num_rows;
								$totalpages=ceil($num_rows/$num_posts_per_page);

								if($totalpages == 0){
									$totalpages = 1;
								}
								else if($totalpages > 0){
									$totalpages = $totalpages;
								}

								if($page > $totalpages){ ?>

									<div class="wrapper">
										<div class="main-content ">
											<div class="hero">
												<div class="heroContent">
													<br><br><br>
													<div class="well well-default">
														<div class="panel-body" style="text-align: center">
														 	The page you are looking is not available!!<br><br>
															<a href="index.php">
																<button type="submit" class="btn btn-info">
																	Ok!!
																</button>
															</a>			 	
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php }else if($page <= $totalpages){ 
									if($delete_check_value['deleted'] == 1){ ?>
										<div class="wrapper">
											<div class="main-content ">
												<div class="hero">
													<div class="heroContent">
														<br><br><br>
															<div class="panel panel-primary">
															  	<div class="panel-heading">
															    	<h3 class="panel-title">
																   		<?php echo $row['post_title']; ?>
																   	</h3>
																</div>
															</div>
																<div class="well well-default">
																	<div class="panel-body" style="text-align: center">
																	 	This post has been deleted. You cannot post anymore!!<br><br>
																		<a href="viewTeam.php?team_id=<?php echo $team_id ?>">
																			<button type="submit" class="btn btn-info">
																				Ok!!
																			</button>
																		</a>			 	
																	</div>
																</div>
													</div>
												</div>
											</div>
										</div>


									<?php }else if($delete_check_value['deleted'] == 0){

										$show = 0;

										$suspend_check = "select suspension from proj4_members where username = '$pres_user' ";
										$suspend_res = $con->query($suspend_check);
										$suspend_value = $suspend_res->fetch_assoc();

										$freeze_check = "select freeze from proj4_posts where post_id = '$post_id'";
										$freeze_res = $con->query($freeze_check);
										$freeze_value = $freeze_res->fetch_assoc(); ?>

										


										<div class="wrapper">
											<div class="main-content ">
												<div class="hero">
													<div class="heroContent">
														<br><br>
														<ol class="breadcrumb">
															<li><a href="index.php">Home</a></li>
															<li><a href="viewTeam.php?team_id=<?php echo $team_id; ?>"><?php echo $team_name_value['team_name']; ?></a></li>
															<li class="active"><?php echo $row['post_title']; ?></li>														
														</ol><br>
															<div class="panel panel-primary">
															  	<div class="panel-heading">
															    	<h3 class="panel-title">
																   		<?php echo $row['post_title']; ?>
																   		<?php if($_SESSION['admin_auth'] == 1 || $_SESSION['mod_auth'] == 1){ ?>
																   		<div style="float:right">
																   				<?php if($freeze_value['freeze'] == 1){ ?>
																					<a href="delete.php?post_id=<?php echo $post_id; ?>&team_id=<?php echo $team_id; ?>&from=6&page=<?php echo $page;?>" >
																						<button id="commentsubmit" class="btn btn-warning btn-sm" type="submit" value="submit" style="margin-left: 20px;">Un-Freeze</button></a>
																				<?php }else if($freeze_value['freeze'] == 0){ ?>
																					<a href="delete.php?post_id=<?php echo  $post_id; ?>&team_id=<?php echo $team_id; ?>&from=7&page=<?php echo $page;?>" >
																						<button id="commentsubmit" class="btn btn-warning btn-sm" type="submit" value="submit" style="margin-left: 20px;">Freeze</button>
																					</a>
																				<?php } ?>
																   		</div>
																   		<?php } ?>
															   		</h3>
															    </div>
															    <?php 
															    	$image_of_user = $row['username'];
																	$image_display_query="select image,image_type,image_id from proj4_avatar_images where 
																	image_username='$image_of_user'";
																	$image_display_exec=$con->query($image_display_query)or die($con->error);
																	$image_display_rows =  mysqli_num_rows($image_display_exec);
																	
																	$image_result=$image_display_exec->fetch_assoc();			

																	$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);		
																
															    ?>
															  	<div class="panel-body">
																	<table class="table">
																		<thead>
																			<tr>
																				<td >
																					<?php if($image_display_rows == 0){ ?>
																						<img border="10" src="./images/default.png" width="100" height="100"/><br>
																					<?php }else if($image_display_rows > 0){ ?>
																						<a id="image_modal" href="imageDisplay.php?id=<?php echo $image_result['image_id'];?>" target="_blank"><img border="10" src="<?php echo $uri;?>" width="100" height="100"/></a><br/>								
																						<!-- <img border="0" src="./assets/img/CSK.png" width="100" height="75"/> -->
																					<?php } ?>
																						<strong>Author: </strong>
																					<?php if($_SESSION['username'] == $row['username']){ ?>
																						<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br>
																					<?php }else if($_SESSION['username'] != $row['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br>
																					<?php } ?>
																					 
																	    			<!-- <a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>) -->
																					<strong>On: </strong>
																					<?php

																						$com1date = date('M d, Y', strtotime($row['time_created']));
																						$com1time = date('g:i a', strtotime($row['time_created']));
																						echo $com1date;?> <?php echo $com1time
																					?>	
																					<br><?php echo $row['rank'];?>
																					

																				</td>
																				<td class="view">
																					<?php echo $row['message'];?><br>
																					<?php 
																					if($row['images']){
																						$image_display=explode("|",$row['images']);
																						$count_images=count($image_display);
																						for($i=0;$i<$count_images-1;$i++){ ?>
																						 	<a href="./images/<?php echo $image_display[$i];?>" target="_blank">
																								<img src="./images/<?php echo $image_display[$i];?>" height=100 width=100></img>
																							</a>
																						<?php } ?>
																					<?php } ?>
																					<div id="pane<?php $post_id1=$row['post_id']; 
																						echo $row['post_id']; ?>" hidden>
																							<textarea name="textarea" rows="5" cols="50" style="resize:none" id="textarea<?php echo $row['post_id']?>" ><?php echo $row['message'];?></textarea><br>
																							<input type="hidden" name="hidden_post_id" id="hidden_post_id" value="<?php echo $row['post_id'];?>"/>
																							<input type="hidden" name="hidden_team_id" id ="hidden_team_id" value="<?php echo $row['t_team_id'];?>"/>
																							<input type="hidden" name="edited_user" id="edited_user" value="<?php echo $pres_user1_val['name'];?>"/>
																							<!-- <div >
																								<input type="file" name="discussion_image[]" id="discussion_image" accept="image/jpeg,image/png,image/jpg,image/gif" multiple><br>
																							</div> -->
																							<a id="modal-3" href="#modal-container-edit" role="button"  data-toggle="modal">
																								<button id="edit_submit" type="submit" class="btn1 btn btn-info" value="<?php echo $row['post_id']?>">Submit</button>
																							</a>	
																					</div>
																				</td>							    		
																	    		<!-- <td>
																	    			<strong>Author: </strong>
																					<?php if($_SESSION['username'] == $row['username']){ ?>
																						<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br>
																					<?php }else if($_SESSION['username'] != $row['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br>
																					<?php } ?>
																					 
																	    			<!-- <a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>) -->
																					<!--<strong>On: </strong>
																					<?php

																						$com1date = date('M d, Y', strtotime($row['time_created']));
																						$com1time = date('g:i a', strtotime($row['time_created']));
																						echo $com1date;?> <?php echo $com1time
																					?>	
																					<br><?php echo $row['rank'];?>
																				</td> -->
																				<?php if($row['time_created']<$row['time_edited']) { ?>
																				<td>
																	    			<strong>Edited By: </strong>
																					<?php
																					/*retreiving edited user*/
																					$edited_user=$con->query("select edited_by from proj4_posts where post_id='$post_id1'");
																					$edited_user_result=$edited_user->fetch_assoc();
																					//echo $edited_user_result['edited_by'];
																					$edit_user=$edited_user_result['edited_by'];
																					/*retreiving edited user role*/
																					$edited_role=$con->query("select role,rank,username from proj4_members where name='$edit_user'");
																					$edited_role_result=$edited_role->fetch_assoc();
																					//echo "(".$edited_role_result['role'].")";
																					?> 

																					<?php if($_SESSION['username'] == $edited_role_result['username']){ ?>
																						<a href="profile.php"><?php echo $edited_user_result['edited_by']?></a> (<?php echo $edited_role_result['role'];?>)<br>
																					<?php }else if($_SESSION['username'] != $edited_role_result['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $edited_role_result['username']; ?>"><?php echo $edited_user_result['edited_by']?></a> (<?php echo $edited_role_result['role'];?>)<br>
																					<?php } ?>
																					
																					<strong>On: </strong>
																					<?php
																						$edit1date = date('M d, Y', strtotime($row['time_edited']));
																						$edit1time = date('g:i a', strtotime($row['time_edited']));
																						echo $edit1date;?> <?php echo $edit1time
																					?>	
																					<br><?php echo $edited_role_result['rank'];?>
																				</td>
																				<?php }else{ ?>
																					<td> </td>
																				<?php } ?>
																				<?php if($pres_user1_val['suspension'] == 0){ ?>	
																					<?php if ($_SESSION['admin_auth'] == 1){ ?>
																					<td >
																						<a href="delete.php?post_id=<?php echo $row['post_id']; ?>&team_id=<?php echo $row['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1" >Delete</a><br>
																						<a id="<?php echo $row['post_id']; ?>" class="flap">Edit</a>
																					</td>
																					<?php }else if ($row['member_name'] == $pres_user1_val['name']){ ?>
																					<td class="last">
																						<a href="delete.php?post_id=<?php echo $row['post_id']; ?>&team_id=<?php echo $row['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1" >Delete</a><br>
																						<a id="<?php echo $row['post_id']; ?>" class="flap">Edit</a>
																					</td>
																					<?php }	?>
																				<?php }else if($pres_user1_val['suspension'] == 1){ ?>
																					<td></td>
																				<?php } ?>
																	    	</tr>
																		</thead>
																	</table>
																</div>
															</div>
																			
															<div class="panel panel-default">
															 	<div class="panel-heading">
															   		<h3 class="panel-title">
																   		<?php echo "Re: ".$row['post_title'];?>
															    	</h3>
															   	</div>

															<div class="panel-body">
																<table class="table">					
																	<thead> 
																		<?php while($row1=$reply_message->fetch_assoc()){ ?>
																				<tr> 

																					<?php 
																						$image_of_user1 = $row1['username'];
																						$image_display_query="select image,image_type,image_id from proj4_avatar_images where 
																						image_username='$image_of_user1'";
																						$image_display_exec=$con->query($image_display_query)or die($con->error);
																						$image_display_rows =  mysqli_num_rows($image_display_exec);
																						
																						$image_result=$image_display_exec->fetch_assoc();			

																						$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);
																					?>
																					<td>
																						<?php if($image_display_rows == 0){ ?>
																							<img border="10" src="./images/default.png" width="100" height="100"/><br>
																						<?php }else if($image_display_rows > 0){ ?>
																							<a id="image_modal" href="imageDisplay.php?id=<?php echo $image_result['image_id'];?>" target="_blank"><img border="10" src="<?php echo $uri;?>" width="100" height="100"/></a><br/>								
																						<!-- <img border="0" src="./assets/img/CSK.png" width="100" height="75"/> -->
																						<?php } ?>
																						<strong>Commented By: </strong>
																						<!-- <a href="profile.php"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>) -->

																						<?php if($_SESSION['username'] == $row1['username']){ ?>
																						<a href="profile.php"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>)<br>
																						<?php }else if($_SESSION['username'] != $row1['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $row1['username']; ?>"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>)<br>
																						<?php } ?>
																						<strong>On: </strong>
																							<?php

																								$comdate = date('M d, Y', strtotime($row1['time']));
																								$comtime = date('g:i a', strtotime($row1['time']));
																								echo $comdate;?> <?php echo $comtime
																							?>	
																						<br><?php echo $row1['rank'];?>
																					</td>												
																					<td class="view">
																						<?php echo $row1['message']; ?><br>
																						<?php if($row1['images']){
																							$image_display=explode("|",$row1['images']);
																							$count_images=count($image_display);
																							//echo $count_images-1;
																							for($i=0;$i<$count_images-1;$i++) { ?>
																								<a href="./images/<?php echo $image_display[$i];?>" target="_blank">
																									<img src="./images/<?php  echo $image_display[$i];?>" width="100px" height="100px"></img>
																								</a>
																							<?php } ?>
																						<?php } ?>

																						<div id="reply<?php $reply_id=$row1['reply_id']; 
																							echo $row1['reply_id']; ?>" hidden>
																							<!--<form method="post" action="editsubmit.php?post_id=<?php //echo $row1['p_post_id']; ?>&team_id=<?php  //echo $row1['team_id']; ?>&reply_id=<?php //echo $row1['reply_id'];?>&curpage=<?php //echo $page; ?>&from=3">-->
																							<textarea name="textarea" rows="5" cols="50" style="resize:none" id="thisreply<?php echo $row1['reply_id']?>" ><?php echo $row1['message'];?></textarea><br>
																							<input type="hidden" name="edited_user" id="edited_user" value="<?php echo $pres_user1_val['name'];?>"/>
																							<input type="hidden" name="hidden_reply_post_id" id="hidden_reply_post_id" value="<?php echo $row1['p_post_id'];?>"/>
																							<input type="hidden" name="hidden_reply_team_id" id="hidden_reply_team_id" value="<?php echo $row1['team_id'];?>"/>
																							<input type="hidden" name="hidden_reply_id" id="hidden_reply_id" value="<?php echo $row1['reply_id'];?>"/>
																							<!-- <div >
																								<input type="file" name="discussion_image[]" id="discussion_image" accept="image/jpeg,image/png,image/jpg,image/gif" multiple><br>
																							</div> -->
																							<a id="modal-3ewewe" href="#modal-container-posted" role="button"  data-toggle="modal">
																								<button id="reply_submit" type="submit" class="btn2 btn btn-info" value="<?php echo $row1['reply_id']?>">Submit</button>
																							</a>
																							<!--</form>-->
																						</div>	
																					</td>   
																					<!-- <td>																
																						<strong>Commented By: </strong>
																						<!-- <a href="profile.php"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>) -->

																						<!--<?php if($_SESSION['username'] == $row1['username']){ ?>
																						<a href="profile.php"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>)<br>
																						<?php }else if($_SESSION['username'] != $row1['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $row1['username']; ?>"><?php echo $row1['member_name'];?></a> (<?php echo $row1['role'];?>)<br>
																						<?php } ?>
																						<strong>On: </strong>
																							<?php

																								$comdate = date('M d, Y', strtotime($row1['time']));
																								$comtime = date('g:i a', strtotime($row1['time']));
																								echo $comdate;?> <?php echo $comtime
																							?>	
																						<br><?php echo $row1['rank'];?>
																					</td>  -->
																					<?php if($row1['time']<$row1['reply_time_edited']) { ?>
																					<td>
																						<strong>Edited By: </strong>
																						<?php
																							/*retreiving edited user*/
																							$edited_user=$con->query("select reply_edited_by from proj4_reply where reply_id='$reply_id'");
																							$edited_user_result=$edited_user->fetch_assoc();
																							//echo $edited_user_result['reply_edited_by'];
																							$edit_user=$edited_user_result['reply_edited_by'];
																							/*retreiving edited user role*/
																							$edited_role=$con->query("select role,rank,username from proj4_members where name='$edit_user'");
																							$edited_role_result=$edited_role->fetch_assoc();
																							//echo "(".$edited_role_result['role'].")";
																						?>	
																						<?php if($_SESSION['username'] == $edited_role_result['username']){ ?>
																						<a href="profile.php"><?php echo $edited_user_result['reply_edited_by']?></a> (<?php echo $edited_role_result['role'];?>)<br>
																						<?php }else if($_SESSION['username'] != $edited_role_result['username']){ ?>
																						<a href="userProfile.php?seeUser=<?php echo $edited_role_result['username']; ?>"><?php echo $edited_user_result['reply_edited_by']?></a> (<?php echo $edited_role_result['role'];?>)<br>
																						<?php } ?>																				 
																						<strong>On: </strong>
																						<?php
																							$editdate = date('M d, Y', strtotime($row1['reply_time_edited']));
																							$edittime = date('g:i a', strtotime($row1['reply_time_edited']));
																							echo $editdate;?> <?php echo $edittime
																						?>
																						<br><?php echo $edited_role_result['rank'];?>	
																					</td>
																					<?php }else{ ?>
																						<td> </td>
																					<?php } ?>

																					<?php if($pres_user1_val['suspension'] == 0){ ?>	
																						<?php if ($_SESSION['admin_auth'] == 1){ ?>
																							<td class="last">
																								<a href="delete.php?post_id=<?php echo $row1['p_post_id']; ?>&reply_id=<?php echo $row1['reply_id']; ?>&team_id=<?php echo $row1['team_id']; ?>&curpage=<?php echo $page; ?>&from=12" >Delete</a><br>									
																								<a id="<?php echo $row1['reply_id']; ?>" class="reply_flap">Edit</a>
																							</td>
																						<?php } else if ($row1['member_name'] == $pres_user1_val['name']){ ?>
																							<td class='last'>
																								<a href="delete.php?post_id=<?php echo $row1['p_post_id']; ?>&reply_id=<?php echo $row1['reply_id']; ?>&team_id=<?php echo $row1['team_id']; ?>&curpage=<?php echo $page; ?>&from=12" >Delete</a><br>
																								<a id="<?php echo $row1['reply_id']; ?>" class="reply_flap">Edit</a>
																							</td>
																						<?php }else{ ?>
																								<td></td>
																						<?php } ?>
																					<?php }else if($pres_user1_val['suspension'] == 1){ ?>
																						<td></td>
																					<?php } ?>
																				</tr> 
																			<?php }	?>	
																	</thead>  
																</table> 
															</div>
														</div>
																			
														<div style="margin-left: 20px;">
															<ul id='bp-3-element-test'></ul>
														</div>	

														<?php if($freeze_value['freeze'] == 1){ ?>
															<form id ="submission" method="POST" action="submit.php?viewthread=2">													
																<label for="textArea" class="col-lg-2 control-label">Comment Area</label>
																<textarea  class = "form-control" rows="5" name="comment1" id="comment1" placeholder="Comment...." style=" resize:none;"></textarea><br>					
																<input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
																<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

																<a id="modal-309291" href="#modal-container-freeze" role="button"  data-toggle="modal">
																	<button id="commentareasubmit" class="btn btn-info" type="submit" value="submit" style="margin-left: 20px;">Submit</button>
																</a>																									
															</form>		
													
														<?php }else if($freeze_value['freeze'] == 0){ ?>
															<?php if($suspend_value['suspension'] == 1){ ?>
															<form id ="submission" method="POST" action="submit.php?viewthread=2">													
																<label for="textArea" class="col-lg-2 control-label">Comment Area</label>
																<textarea  class = "form-control" rows="5" name="comment1" id="comment1" placeholder="Comment...." style=" resize:none;"></textarea><br>					
																<input type="hidden" name="team_id" value="<?php echo $team_id; ?>">
																<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">

																<a id="modal-309291" href="#modal-container-suspend" role="button"  data-toggle="modal">
																	<button id="commentareasubmit" class="btn btn-info" type="submit" value="submit" style="margin-left: 20px;">Submit</button>
																</a>																									
															</form>	
															<?php }else if($suspend_value['suspension'] == 0){ ?>
																<form id ="submissionfull" role="form" method="POST" action="">								
																	<label for="textArea" class="col-lg-2 control-label">Comment Area</label>
																	<textarea  class = "form-control" rows="5" name="comment1" id="comment1" placeholder="Comment...." style=" resize:none;"></textarea><br>					
																	<input type="hidden" name="team_id" id="team_id" value="<?php echo $team_id; ?>">
																	<input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id; ?>">
																	<div style="margin-left:20px;">
																		<input type="file" name="reply_images[]" id="reply_images" accept="image/jpeg,image/png,image/jpg,image/gif" multiple>
																		<h5 style="color:red;">You can Upload Only Maximum of <?php echo $image_max_limit; ?> Images for your Rank</h5><br>
																	</div>
																	<!-- <a id="modal-309291" href="#modal-container-309291" role="button"  data-toggle="modal"> -->
																		<button id="commentareasubmitfull" class="btn btn-info" type="submit" value="submit" style="margin-left: 20px;">Submit</button>
																	<!-- </a> -->
																																								
																</form>	<br><br><br><br><br><br>	
															<?php }
														} ?>																										
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modal-container-suspend" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																You have been suspended from the Forum.
															</h4>
													</div>
													<div id="modal-30"class="modal-body">
														You cannot post untill your suspension is lifted.<br><br>	
														<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=<?php echo $page; ?>" data-toggle="modal" >
															<button id="suspendclose" class="btn btn-info"> Ok!!</button>
														</a>
													</div>
												</div>
											</div>
										</div>


										<div class="modal fade" id="modal-container-deleted" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																You have been deleted from the Forum.
															</h4>
													</div>
													<div id="modal-30"class="modal-body">
														<a id="modal-309293" href="session.php" data-toggle="modal" >
															<button id="suspendclose" class="btn btn-info"> Ok!!</button>
														</a>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modal-container-freeze" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																You have been suspended from the Forum.
															</h4>
													</div>
													<div id="modal-30"class="modal-body">
														You cannot post untill your suspension is lifted.<br><br>	
														<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=<?php echo $page; ?>" data-toggle="modal" >
															<button id="suspendclose" class="btn btn-info"> Ok!!</button>
														</a>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modal-container-309291" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																Please Enter Something to Post
															</h4>
													</div>
													<div id="modal-309292" class="modal-body">						
														<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=<?php echo $page; ?>" data-toggle="modal" >
															<button class="btn btn-info"> Ok!!</button>
														</a>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modal-container-edit" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																Please Enter Something to Post
															</h4>
													</div>
													<div id="modal-309292" class="modal-body">						
														<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=<?php echo $page; ?>" data-toggle="modal" >
															<button class="btn btn-info"> Ok!!</button>
														</a>
													</div>
												</div>
											</div>
										</div>

										<div class="modal fade" id="modal-container-posted" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
															<h4 class="modal-title" id="myModalLabel">
																Please Enter Something to Post
															</h4>
													</div>
													<div id="modal-309292" class="modal-body">						
														<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page=<?php echo $page; ?>" data-toggle="modal" >
															<button class="btn btn-info"> Ok!!</button>
														</a>
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
										               		 window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewThread.php?post_id=<?php echo $post_id;?>&team_id=<?php echo $team_id;?>&page='+page;
										            	}
													}
										            element.bootstrapPaginator(options);
										            var list = element.children();		           
										        })
										    });
										</script>

									<?php } ?>
								<?php } ?>
							<?php } ?>
				<?php }?>
			<?php } ?>
		<?php } ?>


		<?php	
			$result->free();
			$con->close();
		?>
	<?php } ?>
						


		
			

				


		


				