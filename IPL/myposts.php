<?php
	
	session_start();
	include "dbconnect.php";
	include "header1.php";

	if($_SESSION['signuser'] == 0){
		header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}else if($_SESSION['signuser'] == 1){
		$pres_user = $_SESSION['username']; ?>


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
											$my_posts_value = $name_result->fetch_assoc();
											echo $my_posts_value['name'];?>&nbsp;
											(<?php echo $my_posts_value['role']; ?>)&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $my_posts_value['rank']; ?>
										</li>
									<?php } ?>			
								</ul>            
							</div>
						</div>                              
					</div><!-- END top-masthead -->
				</div><!-- END mastheadContent -->
			</div>
			
			<?php 
				$my_posts = "select post_id,member_name,post_title,message,time_created,t_team_id,freeze,deleted,time_edited,edited_by,team_name,
							 from proj4_posts p4p, proj4_team p4t,
							 where p4p.t_team_id = p4t.team_id
							 order by time_created";
				$my_posts_res = $con->query($my_posts);
			?>


			<div class="wrapper">
				<div class="main-content ">
					<div class="hero">
						<div class="heroContent">
							<br><br>
							<ol class="breadcrumb">
								  <li><a href="index.php">Home</a></li>	
								  <li class="active">Profile<!-- &nbsp;(<?php echo $member_stats['name']; ?>) --></li>
							</ol><br>

							<div class="panel panel-primary">
								<div class="panel-heading">
								    <h3 class="panel-title">Posts</h3>
								</div>
								<table class="table">
								  	<thead>
								  		<tr class="header"> 
								  			<td style="min-width: 100px;"><strong>Team</strong></td>
											<td class="view"><strong>Title</strong></td>
											<td ><strong>Message</strong></td>
											<td ><strong>Author</strong></td>
											<td ><strong>Posted On</strong></td>									
										</tr>  							  	
									</thead>
									<tbody> 
										<?php while($my_posts_value = $my_posts_res->fetch_assoc()){	?>
											<tr> 
												<td>
													<a href="viewThread.php?post_id=<?php echo $my_posts_value['post_id'];?>&team_id=<?php  echo $my_posts_value['t_team_id']; ?>">
														<?php echo $my_posts_value['post_title']; ?>
													</a>
												</td>
												<td>
													<?php echo $my_posts_value['message'];	?>
												</td>
												<td>
													<?php echo $my_posts_value['member_name'];?> <!-- (<?php echo $my_posts_value['role'];?>)<br><?php echo $my_posts_value['rank'];?> -->	
												</td> 
												<td>
													<?php 
														$postdate = date('M d, Y', strtotime($my_posts_value['time_created']));
														$posttime = date('g:i a', strtotime($my_posts_value['time_created']));
													?>
													<?php echo $postdate;?> <?php echo $posttime ?>
												</td>  
													
												<td class="last">
													<?php if($my_posts_value['deleted'] == 0){?>
														<?php if ($_SESSION['admin_auth'] == 1){ ?>
														
															<a href="delete.php?post_id=<?php echo $my_posts_value['post_id']; ?>&team_id=<?php echo $my_posts_value['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1">Delete</a><br>														
														
														<?php }else if ($my_posts_value['member_name'] == $pres_user1_val['name']){ ?>
															
															<a href="delete.php?post_id=<?php echo $my_posts_value['post_id']; ?>&team_id=<?php echo $my_posts_value['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1" >Delete</a><br>														
															
														<?php }	?>
													<?php }else if($my_posts_value['deleted'] == 1){echo Deleted; } ?>
												</td>
												
											</tr>
										<?php } ?>
									</tbody> 
								</table> 
							</div>
						</div>
					</div>
				</div>
			</div>

	<?php } ?>