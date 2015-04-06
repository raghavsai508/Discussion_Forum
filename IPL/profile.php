<?php
	
	session_start();	

	$_SESSION['search_team'] = 9;

	if($_SESSION['signuser'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		//echo 1;
	}else if($_SESSION['signuser'] == 1){
		include "dbconnect.php";
		include "header.php";
		$pres_user = $_SESSION['username']; ?>

		<script>		
			$( document ).ready(function() {		
				
				$("#showPosts1").click(function(){			
					$("#profilePosts").slideToggle("slow");
				});	
						
				$("#forgotPass1").click(function(){			
					$("#ChangePass").slideToggle("slow");
				});	
				$("#changeSuccess").click(function(){			
					$("#ChangePassSuccess").slideToggle("slow");
				});
				$("#changename1").click(function(){			
					$("#changeName").slideToggle("slow");
				});	
				$("#changeSuccess1").click(function(){			
					$("#ChangeNameSuccess").slideToggle("slow");
				});
				$("#changeUpload1").click(function(){			
					$("#changeUpload").slideToggle("slow");
				});	
				$("#changePicSuccess1").click(function(){			
					$("#changePicSuccess").slideToggle("slow");
				});
				
				/* function chooseFile() {
                        $("#fileInput").click();
                    }*/


				$('#ChangePassword').submit(function(){				

	                $.ajax({						
	                    type: "POST",
	                    url: "changePassword.php",
	                    data: {
	                        'oldPass': $('#changeOldPass').val(),
	                        'newPass': $('#changeNewPass').val(),
	                        'conNewPass' : $('#changeConNewPass').val(),
	                        'checkChangeAuth' : 1,
	                        'changeNameAuth' : 1
	                    },
	                    success: function (data){
	                        if(data == 2){
	                            window.location.href = "profile.php";
	    					}
	    					else if(data == 0){
	    						$("#changeNote0").html(" The given Password didn't match with the current Password!");
	    						$("#changeNote0").show();							
	    						setTimeout(function() {
	                                $("#changeNote0").hide();
	                            }, 3000);
	    					}
	    					else if(data == 1){
	    						$("#changeNote1").html(" Passwords did not match!!");
	    						$("#changeNote1").show();							
	    						setTimeout(function() {
	                                $("#changeNote1").hide();
	                            }, 3000);
	    					}
	    					else if(data == 3){
	    						$("#changeNote3").html(" Please choose a password different from previous password!");
	    						$("#changeNote3").show();							
	    						setTimeout(function() {
	                                $("#changeNote3").hide();
	                            }, 3000);
	    					}
					    }
				    });
	                return false;
				});

				$('#ChangeName').submit(function(){				

	                $.ajax({						
	                    type: "POST",
	                    url: "changePassword.php",
	                    data: {
	                        'cName': $('#newName').val(),
	                        'checkChangeAuth' : 1,
	                        'changeNameAuth' : 2
	                    },
	                    success: function (data){
	                        if(data == 1){
	                            window.location.href = "profile.php";	

	    					}
	    					else if(data == 0){
	    						$("#changeNameNote0").html(" Please choose a name different from previous name!");
	    						$("#changeNameNote0").show();							
	    						setTimeout(function() {
	                                $("#changeNameNote0").hide();
	                            }, 3000);
	    					}
					    }
				    });
	                return false;
				});

				$('#ChangeUpload').submit(function(){				
					var formData=new FormData($(this)[0]);
	                $.ajax({						
	                   type:"POST",
						url:"changePassword.php",
						async:false,
						cache:false,
						contentType:false,
						processData:false,
						data:formData,
	                    success: function (data){
	                        if(data == 1){
	                            window.location.href = "profile.php";
	    					}
	    					else if(data == 2){
	    						$("#changePicNote2").html("Image type should be jpeg/png/gif!");
	    						$("#changePicNote2").show();							
	    						setTimeout(function() {
	                                $("#changePicNote2").hide();
	                            }, 3000);
	    					}
	    					else if(data == 3){
	    						$("#changePicNote3").html(" Please Upload an Image to change!");
	    						$("#changePicNote3").show();							
	    						setTimeout(function() {
	                                $("#changePicNote3").hide();
	                            }, 3000);
	    					}
					    }
				    });
	                return false;
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
					</div>
				</div>
			</div>

			<?php 

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

				$profile_pages = "select pages from proj4_profile_pages where user = '$pres_user'";
				$profile_pages_result = $con->query($profile_pages) or die ($con->error);
				$profile_pages_val = $profile_pages_result->fetch_assoc();

				$num_posts_per_page=$profile_pages_val['pages'];
				
				if($_GET['page']){
					$page=$_GET['page'];
				}else{
					$page=1;
				}
				$pageno=($page-1)*$num_posts_per_page;

				$tot_posts = "select post_id, member_name,role,post_title,message,time_created,team_id,deleted,freeze,rank,team_name 
								from proj4_posts p4p,proj4_teams p4t, proj4_members p4m 
								where p4p.t_team_id = p4t.team_id 
								and p4m.name = p4p.member_name 
								and p4m.username = '$pres_user' 
								order by team_id,time_created desc 
								limit $pageno,$num_posts_per_page";
				$tot_posts_result = $con->query($tot_posts) or die ($con->error);

				$tot_posts_rows = mysqli_num_rows($tot_posts_result);

				$posts = "select post_id,time_created 
						from proj4_posts p4p, proj4_members p4m 
						where p4p.member_name = p4m.name 
						and p4m.username = '$pres_user' 
						order by time_created desc";
				$posts_result = $con->query($posts) or die ($con->error);

				$num_rows=$posts_result->num_rows;
				$totalpages=ceil($num_rows/$num_posts_per_page);

				$image_display_query="select image,image_type,image_id from proj4_avatar_images where image_username='$username'";
				$image_display_exec=$con->query($image_display_query)or die($con->error);

				$image_display_rows =  mysqli_num_rows($image_display_exec);

				$image_result=$image_display_exec->fetch_assoc();				

				$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);

				$profile_entered_query = "select entered from proj4_profile_page_display where username='$username'";
				$profile_entered_exec = $con->query($profile_entered_query)or die($con->error);

				$profile_entered=$profile_entered_exec->fetch_assoc();
			
			?>

			<div class="wrapper">
				<div class="main-content">
					<div class="hero">
						<div class="heroContent">
							<br><br>
							<ol class="breadcrumb">
								  <li><a href="index.php">Home</a></li>	
								  <li class="active">Profile<!-- &nbsp;(<?php echo $member_stats['name']; ?>) --></li>
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
										<a id="showPosts1"><strong>Total Posts: </strong><?php echo $member_posts_total_val['tot_posts']; ?></a><br><br>
									</div>
			
			                        <div style="height:0px;overflow:visible">
	                                    <input type="file" id="fileInput" name="fileInput" />
                                    </div>

                                    <button id="changeUpload1" class="btn btn-info btn-sm">Click here to upload a Profile image</button><br><br>

									<div id="changeUpload" hidden>							
									 	<form id="ChangeUpload" role="form" method="post" action="">
									 		<h5 id="changePicNote0" style="color: red;" hidden></h5>
											<div class="form-group">
												<label>User Avatar </label>
												<input name="profile_pic_change" type="file" id="profile_pic_change" class="form-control">
											</div>
											<input type="hidden" name="changeNameAuth" value="3">
											<input type="hidden" name="checkChangeAuth" value="1">	
											<button id="changePassBtn" type="submit" class="btn btn-info btn-sm">Submit</button>		
										</form>		<br>							
									</div>

									<?php if($_SESSION['changeUpload'] == 1){?>
										<div id="changePicSuccess" >							
											<div class="well well-default">
												<div class="panel-body" style="text-align: center">
												 	Profile Picture Updated Successfully!!<br><br>
													<a id="changePicSuccess1">
														<button type="submit" class="btn btn-info">
															Ok!!
														</button>
													</a>			 	
												</div>
											</div>
										</div>
										<?php $_SESSION['changeUpload'] = 0; ?>
									<?php } ?>



									<button id="changename1" class="btn btn-info btn-sm">Click here to Change your Name</button><br><br>

									<div id="changeName" hidden>							
									 	<form id="ChangeName" role="form" method="post" action="changePassword.php">
									 		<h5 id="changeNameNote2" style="color: red;" hidden></h5>
									 		<h5 id="changeNameNote3" style="color: red;" hidden></h5>
											<div class="form-group">
												<label>New Name</label>
												<input type="text" class="form-control" id="newName" name="newName" placeholder="New Name" required />
											</div>
											<button id="changePassBtn" type="submit" class="btn btn-info btn-sm">Submit</button>		
										</form>		<br>							
									</div>

									<?php if($_SESSION['changeName'] == 1){?>
										<div id="ChangeNameSuccess" >							
											<div class="well well-default">
												<div class="panel-body" style="text-align: center">
												 	Name Changed Successfully!!<br><br>
													<a id="changeSuccess1">
														<button type="submit" class="btn btn-info">
															Ok!!
														</button>
													</a>			 	
												</div>
											</div>
										</div>
										<?php $_SESSION['changeName'] = 0; ?>
									<?php } ?>

									<button id="forgotPass1" class="btn btn-info btn-sm">Click here to Change your Password</button><br><br>

									<div id="ChangePass" hidden>									
									 	<form id="ChangePassword" role="form" method="post" action="changePassword.php">
									 		<h5 id="changeNote3" style="color: red;" hidden></h5>
									 		<div class="form-group">
									 			<label>Old Password</label>
												<input type="password" class="form-control" id="changeOldPass" name="changeOldPass" placeholder="Old Password" required />
												<h5 id="changeNote0" style="color: red;" hidden></h5>
											</div>
											<div class="form-group">
												<label>New Password</label>
												<input type="password" class="form-control" id="changeNewPass" name="changeNewPass" placeholder="New Password" required />
												<h5 id="changeNote1" style="color: red;" hidden></h5>
											</div>
											<div class="form-group">
												<label>Confirm New Password</label>
												<input type="password" class="form-control" id="changeConNewPass" name="changeConNewPass" placeholder="Confirm New Password" required />
											</div>
											<button id="changePassBtn" type="submit" class="btn btn-info btn-sm">Submit</button>		
										</form>										
									</div>
									<?php if($_SESSION['changePassword'] == 1){?>
										<div id="ChangePassSuccess" >							
											<div class="well well-default">
												<div class="panel-body" style="text-align: center">
												 	Password Changed Successfully!!<br><br>
													<a id="changeSuccess">
														<button type="submit" class="btn btn-info">
															Ok!!
														</button>
													</a>			 	
												</div>
											</div>
										</div>
										<?php $_SESSION['changePassword'] = 0; ?>
									<?php } ?>									
								</div>
							</div>
							<br><br>

							<?php if($tot_posts_rows == 0){ ?>
								<div id="profilePosts" hidden>
									<div class="panel panel-primary" >
									  	<div class="panel-heading">
										 	<h3 class="panel-title">Your Posts</h3>
										</div>
									</div>
								</div>

							<?php }else if($tot_posts_rows > 0){ ?>

								<?php if($profile_entered['entered'] == 1){ ?>
									<div id="profilePosts">
										<div class="panel panel-primary" >
										  	<div class="panel-heading">
											 	<h3 class="panel-title">Your Posts
											 		<div style="float:right; ">
											 			<div class="btn-group" >
														   	<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" style="padding-top:0.15px;">
														   		<?php echo $profile_pages_val['pages']; ?> posts per page<span class="caret"></span>
														 	</button>
														 	<ul class="dropdown-menu" role="menu">
														 		<?php if($profile_pages_val['pages'] == 3){ ?>
																    <li><a href="profileUpdate.php?role=7&num_pages=6">6 posts per page</a></li>
																    <li><a href="profileUpdate.php?role=7&num_pages=8">8 posts per page</a></li>
															    <?php } ?>
															    <?php if($profile_pages_val['pages'] == 6){ ?>
																    <li><a href="profileUpdate.php?role=7&num_pages=3">3 posts per page</a></li>
																    <li><a href="profileUpdate.php?role=7&num_pages=8">8 posts per page</a></li>
															    <?php } ?>
															    <?php if($profile_pages_val['pages'] == 8){ ?>
																    <li><a href="profileUpdate.php?role=7&num_pages=3">3 posts per page</a></li>
																    <li><a href="profileUpdate.php?role=7&num_pages=6">6 posts per page</a></li>
															    <?php } ?>									
														  	</ul>
														</div>
											 		</div>

											 	</h3>
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
																<?php if($tot_posts_val['deleted'] == 0){ ?>
																	<td><a href="viewThread.php?post_id=<?php echo $tot_posts_val['post_id'];?>&team_id=<?php echo $tot_posts_val['team_id'];?>" ><?php echo $tot_posts_val['post_title']; ?></a> <!-- <br><br> In: <a> </a> --></td> 
																<?php }else if($tot_posts_val['deleted'] == 1) {?>
																	<td><?php echo $tot_posts_val['post_title']; ?></td> 
																<?php } ?>															
																
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
								<?php } ?>

								<div id="profilePosts" hidden>
									<div class="panel panel-primary" >
									  	<div class="panel-heading">
										 	<h3 class="panel-title">Your Posts
										 		<div style="float:right">
										 			<div class="btn-group">
													   	<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" style="padding-top:0.15px;">
													   		<?php echo $profile_pages_val['pages']; ?> posts per page<span class="caret"></span>
													 	</button>
													 	<ul class="dropdown-menu" role="menu">
													 		<?php if($profile_pages_val['pages'] == 3){ ?>
															    <li><a href="profileUpdate.php?role=7&num_pages=6">6 posts per page</a></li>
															    <li><a href="profileUpdate.php?role=7&num_pages=8">8 posts per page</a></li>
														    <?php } ?>
														    <?php if($profile_pages_val['pages'] == 6){ ?>
															    <li><a href="profileUpdate.php?role=7&num_pages=3">3 posts per page</a></li>
															    <li><a href="profileUpdate.php?role=7&num_pages=8">8 posts per page</a></li>
														    <?php } ?>
														    <?php if($profile_pages_val['pages'] == 8){ ?>
															    <li><a href="profileUpdate.php?role=7&num_pages=3">3 posts per page</a></li>
															    <li><a href="profileUpdate.php?role=7&num_pages=6">6 posts per page</a></li>
														    <?php } ?>									
													  	</ul>
													</div>
										 		</div>

										 	</h3>
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

															<?php if($tot_posts_val['deleted'] == 0){ ?>
																<td><a href="viewThread.php?post_id=<?php echo $tot_posts_val['post_id'];?>&team_id=<?php echo $tot_posts_val['team_id'];?>" ><?php echo $tot_posts_val['post_title']; ?></a> <!-- <br><br> In: <a> </a> --></td> 
															<?php }else if($tot_posts_val['deleted'] == 1) {?>
																<td><?php echo $tot_posts_val['post_title']; ?></td> 
															<?php } ?>	        
															
															
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

													<?php 	
														$update = "update proj4_profile_page_display set entered ='1' where username = '$username'";
														$update_result = $con->query($update) or die ($con->error);	
													?>
													
												</tbody>  
											</table>																			
										</div>
									</div>
									<div style="margin-left: 20px;">
										<ul id='bp-3-element-test'></ul>
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
			               		window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/profile.php?page='+page;
			            	}
						}
			            element.bootstrapPaginator(options);
			            var list = element.children();		           
			        })
			    });
			</script>

			<div class="modal fade" id="myModal_image"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog1">
				<div class="modal-content1">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Image</h4>
				  </div>
				  <div class="modal-body">
				  <center>
					<img src="<?php echo $uri;?>"/>
				  </center>
				  </div>
				</div>
			  </div>
			</div>
		
	<?php } ?>
	


