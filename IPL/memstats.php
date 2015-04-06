<?php
session_start();
		if ($_SESSION['signuser'] == 0 || $_SESSION['permission'] == 0){
			header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		}
		else if($_SESSION['signuser'] == 1){
			if($_SESSION['admin_auth'] == 1 || $_SESSION['mod_auth'] == 1){
				$_SESSION['update']=1;
				include "dbconnect.php";
				include "header.php";

				$_SESSION['search_team'] = 9;

				$user = $_SESSION['username'];
?>


						<script>
							$( document ).ready(function() {	
								$(".flap").click(function(){
									$("#pane"+this.id).slideToggle("slow");
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
												window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name=<?php echo $user; ?>';
												}
												else if(data==1){
													//$("#modal-container-edit1").show();
												}
												else if(data==2){
													alert('post has been edited');
													//window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/memstats.php?name=<?php echo $user; ?>';
												}
											}
									    });							
									});
								});
							</script>
				<div class="primaryMenu">
					<div class="wrapper">      
						<div class="masthead-menu">
							<ul id="yw1">
								<li><a href="index.php">Home</a></li>
								
								<li class="right"> 
									<?php
									$username = $_SESSION['username'];
									$name="select name,role,rank from proj4_members where username = '$username'";
									$name_result = $con->query($name) or die ($con->error);
									$row = $name_result->fetch_assoc();?>
									<a href="profile.php"><?php echo $row['name'];?>&nbsp;
										(<?php echo $row['role']; ?>)&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $row['rank']; ?>
									</a>
								</li>				
							</ul>            
						</div>
					</div>                              
				</div><!-- END top-masthead -->
			</div><!-- END mastheadContent -->
		</div>

		<?php

			$username = $_GET['name'];

			//echo '<br>';
			//echo $username;

			$member="select username,name,email,role,rank,time_joined,suspension,activation
						from proj4_members p4m
						where p4m.username = '$username'";
			$member_result = $con->query($member) or die ($con->error);
			$member_stats = $member_result->fetch_assoc();
			$user = $member_stats['username'];

			$pres_user = $_SESSION['username'];

			$pres_user1 = "select name from proj4_members where username = '$pres_user'";
			$pres_user1_result = $con->query($pres_user1) or die ($con->error);
			$pres_user1_val = $pres_user1_result->fetch_assoc();

			//echo $member_stats['name'];

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

			$image_display_query="select image,image_type,image_id from proj4_avatar_images where image_username='$username'";
			$image_display_exec=$con->query($image_display_query)or die($con->error);
			$image_display_rows =  mysqli_num_rows($image_display_exec);
			
			$image_result=$image_display_exec->fetch_assoc();			

			$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);			
		?>

		<div class="wrapper">
			<div class="main-content ">
				<div class="hero">
					<div class="heroContent">
						<br><br>
						<ol class="breadcrumb">
							  <li><a href="index.php">Home</a></li>
							  <?php if ($_SESSION['admin_auth'] == 1){ ?>
									<li><a href="admin.php">Admin</a></li>									
								<?php }else if($_SESSION['mod_auth'] == 1){ ?>
									<li><a href="admin.php">Moderator</a></li>	
								<?php } ?>
								 <li ><a href="members.php">Members</a></li>	
							  	<li class="active">Members Stats</li>
						</ol><br>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Member Name: <?php echo $member_stats['name']; ?></h3>
							</div>
							<div class="panel-body" style="text-transform:uppercase; line-height:30px;">
								<div style="float:right; margin-right: 20px;">	

								<?php if($image_display_rows == 0){ ?>
									<img border="10" src="./images/default.png" width="100" height="75"/>
								<?php }else if($image_display_rows > 0){ ?>
									<a id="image_modal" href="imageDisplay.php?id=<?php echo $image_result['image_id'];?>" target="_blank"><img border="10" src="<?php echo $uri;?>" width="100" height="75"/></a><br/>								
									<!-- <img border="0" src="./assets/img/CSK.png" width="100" height="75"/> -->
								<?php } ?>
									
								</div>
								<strong>Activation Status: </strong>
									<?php if($member_stats['activation'] == 0){
										echo "Not active";
									}else echo "Active"; ?><br>
								<strong>Suspension level: </strong>
									<?php if($member_stats['username'] == 'ta'){ 
										echo "I am Super Admin. You cannot suspend Me!!"; ?>&nbsp;&nbsp;&nbsp;
									<?php }else{
										if($member_stats['suspension'] == 0){
										echo "Not Suspended"; ?>&nbsp;&nbsp;&nbsp;
										<a id="suspend" href="#modal-container-3000" data-toggle="modal">
											<button id="submit1" class="btn btn-info btn-sm" type="submit" value="submit">Suspend Him</button>
										</a>
										<?php }	else{ 
											echo "Suspended"?>&nbsp;&nbsp;&nbsp;
											<a href="update.php?role=6&name=<?php echo $user; ?>">
												<button id="submit1" class="btn btn-info btn-sm" type="submit" value="submit">Un-Suspend Him</button>
											</a>
										<?php } ?>
									<?php } ?>

									<br><br>									
								<strong>User Role: </strong><?php echo $member_stats['role']; ?><br>
								<strong>User Rank: </strong><?php echo $member_stats['rank']; ?><br>
								<?php 
									$regdate = date('M d, Y', strtotime($member_stats['time_joined']));
									$regtime = date('g:i a', strtotime($member_stats['time_joined']));
								?>
								<strong>Registered On: </strong><?php echo $regdate;?>, <?php echo $regtime ?><br>
								<strong>Total Posts: </strong><?php echo $member_posts_total_val['tot_posts']; ?><br>
								<strong>Total Replies: </strong><?php echo $member_reply_total_value['tot_reply']; ?><br>
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
							</div>
						</div>
					
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Posts</h3>
							</div>
							<div class="panel-body">
								<table class="table">    
									<thead>      
										<tr >        
											<td><strong>ID</strong></td>        
											<td><strong>TITLE</strong></td>  
											<td><strong>MESSAGE</strong></td>
											<td><strong>TEAM</strong></td> 													
										</tr>  
									</thead>  
									<tbody> 
										<?php while($member_posts_stats = $member_posts_result->fetch_assoc()) { ?>

										<tr class="member"> 							

											<td class="first team"><?php echo $member_posts_stats['post_id']; ?></td>        
											<td><a href="viewThread.php?post_id=<?php echo $member_posts_stats['post_id'];?>&team_id=<?php echo $member_posts_stats['t_team_id'];?>" ><?php echo $member_posts_stats['post_title']; ?> </td> 
											<td><?php echo $member_posts_stats['message']; ?>
												<div id="pane<?php $post_id1=$member_posts_stats['post_id']; 
													echo $member_posts_stats['post_id']; ?>" hidden>
														<textarea name="textarea" rows="5" cols="50" style="resize:none" id="textarea<?php echo $member_posts_stats['post_id']?>" ><?php echo $member_posts_stats['message'];?></textarea>
														<input type="hidden" name="hidden_post_id" id="hidden_post_id" value="<?php echo $member_posts_stats['post_id'];?>"/>
														<input type="hidden" name="hidden_team_id" id ="hidden_team_id" value="<?php echo $member_posts_stats['t_team_id'];?>"/>
														<input type="hidden" name="edited_user" id="edited_user" value="<?php echo $pres_user1_val['name'];?>"/>
														<a id="modal-31111" href="#modal-container-edit1" role="button"  data-toggle="modal">
															<button id="edit_submit" type="submit" class="btn1 btn btn-info" value="<?php echo $member_posts_stats['post_id']?>">Submit</button>
														</a>	
												</div>
											</td> 
											<td><?php echo $member_posts_stats['t_team_id']; ?> </td>	
											<td >
												<?php if($member_posts_stats['deleted'] == 0){ ?>
													<a href="delete.php?post_id=<?php echo $member_posts_stats['post_id']; ?>&team_id=<?php echo $member_posts_stats['t_team_id'];?>&from=8&name=<?php echo $member_stats['username']; ?>" >Delete</a><br>
												<?php }else if($member_posts_stats['deleted'] == 1){echo Deleted;}?>		
													
											</td>
											<td class="last" style="width:9%;">
												<?php if($member_posts_stats['freeze'] == 1){ ?>
													<a href="delete.php?post_id=<?php echo $member_posts_stats['post_id']; ?>&team_id=<?php echo $member_posts_stats['t_team_id']; ?>&from=9&name=<?php echo $member_stats['username']; ?>" >Un-Freeze</a>
												<?php }else if($member_posts_stats['freeze'] == 0){ ?>
													<a href="delete.php?post_id=<?php echo $member_posts_stats['post_id']; ?>&team_id=<?php echo $member_posts_stats['t_team_id']; ?>&from=10&name=<?php echo $member_stats['username']; ?>" >Freeze</a>
												<?php } ?>
											</td>													
										</tr>
										<?php }	?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="panel panel-primary">
							<div class="panel-heading">
								<h3 class="panel-title">Replies</h3>
							</div>
							<div class="panel-body">
								<table class="table">    
									<thead>      
										<tr >  
											<td><strong>ID</strong></td>             
											<td><strong>POST ID</strong></td>        
											<td><strong>MESSAGE</strong></td>
											<td><strong>TEAM</strong></td> 													
										</tr>  
									</thead>  
									<tbody> 
										<?php while($member_reply_stats = $member_reply_result->fetch_assoc()) { ?>
										
										<tr class="member"> 							
											
											<td class="first team"><?php echo $member_reply_stats['reply_id']; ?></td> 
											<td><?php echo $member_reply_stats['p_post_id']; ?></td>       
											<td><?php echo $member_reply_stats['message']; ?> </td>    
											<td><?php echo $member_reply_stats['team_id']; ?> </td>	
											<td class="last">
											   <a href="delete.php?reply_id=<?php echo $member_reply_stats['reply_id'];?>&post_id=<?php echo $member_reply_stats['p_post_id'];?>&from=11&name=<?php echo $member_stats['username']; ?>" >Delete</a><br>
											</td>															
										</tr>
										<?php }	?>
									</tbody>
								</table>
							</div>
						</div>


					</div>                              
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-container-3000" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
							<h4 class="modal-title" id="myModalLabel">
								Please Enter Reason for Suspending User:<?php echo $member_stats['name']; ?>
							</h4>
					</div>
					<form role="form" id="reasonform" method="POST" action="update.php?role=4&name=<?php echo $user; ?>">
						<div id="modal-309"class="modal-body">						
							<textarea  class = "form-control" rows="5" cols="75" name="suspendreason" id="suspendreason" placeholder="Reason...." style="resize:none"></textarea><br>
							<a href="update.php?role=4&name=<?php echo $user; ?>">
								<button id="submit1" class="btn btn-info" type="submit" value="submit">Submit</button>
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>

<?php }
	}
$members_result->free();
$con->close();

?>

