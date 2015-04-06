<?php
	session_start();

	include "dbconnect.php";	
	


	if ($_SESSION['signuser'] == 0 ){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1 ){		

		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$team_id=$_GET['team_id'];
		$team_id = test_input($team_id);
		$team_id = $con->real_escape_string($team_id);

		include "header1.php";

		$_SESSION['search_team'] = $team_id;

		//echo $_SESSION['search_team'];

		$pres_user = $_SESSION['username'];

		if(!is_numeric($team_id)){ ?>

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
										 	The Team you are looking for is not a part Discussion Forum<br><br>
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

		<?php }else if(is_numeric($team_id)){ ?>
			<?php if($team_id > 8){ ?>
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


			<?php }else if($team_id < 9){ ?>
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
				$view_team_pages = "select page_name,num_pages from proj4_pages where page_name = 'view page'";
				$view_team_pages_result = $con->query($view_team_pages) or die ($con->error);
				$view_team_pages_val = $view_team_pages_result->fetch_assoc();

				$num_posts_per_page=$view_team_pages_val['num_pages'];
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

				<?php }

				/*if($_SESSION['admin_auth'] == 0 && $_SESSION['signuser'] == 1){*/
					$pageno=($page-1)*$num_posts_per_page;


					$query="select post_id,member_name,username,role,message,rank,post_title,time_created,t_team_id,deleted,images from proj4_posts p4p,proj4_members p4m where t_team_id='$team_id' and p4p.member_name = p4m.name  and p4p.deleted = '0' order by time_created desc limit $pageno,$num_posts_per_page";
					$result = $con->query($query) or die ($con->error);

					/*$delete_check = "select deleted from proj4_posts where post_id = '$post_id' and t_team_id = '$team_id'";
					$delete_check_res = $con->query($delete_check);
					$delete_check_value = $delete_check_res->fetch_assoc();*/

					$pres_user1 = "select name from proj4_members where username = '$pres_user'";
					$pres_user1_result = $con->query($pres_user1) or die ($con->error);
					$pres_user1_val = $pres_user1_result->fetch_assoc();
		
					$query2="select post_id,member_name,message,post_title,time_created,t_team_id from proj4_posts where t_team_id='$team_id' and deleted = '0'";
					$rows_count=$con->query($query2) or die ($con->error);

					$num_rows=$rows_count->num_rows;

					$totalpages=ceil($num_rows/$num_posts_per_page);
				/*}
				else if($_SESSION['admin_auth'] == 1){
					$pageno=($page-1)*$num_posts_per_page;


					$query="select post_id,member_name,username,role,message,rank,post_title,time_created,t_team_id,deleted from proj4_posts p4p,proj4_members p4m where t_team_id='$team_id' and p4p.member_name = p4m.name order by time_created desc limit $pageno,$num_posts_per_page";
					$result = $con->query($query) or die ($con->error);

					//$delete_check = "select deleted from proj4_posts where post_id = '$post_id' and t_team_id = '$team_id'";
					//$delete_check_res = $con->query($delete_check);
					//$delete_check_value = $delete_check_res->fetch_assoc();

					$pres_user1 = "select name from proj4_members where username = '$pres_user'";
					$pres_user1_result = $con->query($pres_user1) or die ($con->error);
					$pres_user1_val = $pres_user1_result->fetch_assoc();
		
					$query2="select post_id,member_name,message,post_title,time_created,t_team_id from proj4_posts where t_team_id='$team_id'";
					$rows_count=$con->query($query2) or die ($con->error);

					$num_rows=$rows_count->num_rows;

					$totalpages=ceil($num_rows/$num_posts_per_page);
				}*/
				

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

				<?php }else if($page <= $totalpages){ ?>

			
					<div class="wrapper">
						<div class="main-content ">
							<div class="hero">
								<div class="heroContent">
									<br><br><br>
									<div class="panel panel-primary">
									  <div class="panel-heading">
									    <h3 class="panel-title">Top Discussions</h3>
									  </div>
									  <table class="table">
									  	<thead>
									  		<tr class="header"> 
												<td style="min-width: 100px;"><strong>Title</strong></td>
												<td class="view"><strong>Comment</strong></td>
												<td><strong>Author</strong></td>
												<td><strong>Posted On</strong></td>									
											</tr>  							  	
										</thead>
										<tbody> 
											<?php while($row = $result->fetch_assoc()){	?>	
												
												<tr> 
													<td>
												
														<a href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=<?php  echo $row['t_team_id']; ?>">
															<?php echo $row['post_title']; ?>
														</a>
													</td>
													<td>
														<?php echo $row['message'];	?><br>
														<?php if($row['images']){
															$image_display=explode("|",$row['images']);
															$count_images=count($image_display);
															for($i=0;$i<$count_images-1;$i++){ ?>
																<a id="image_modal" href="./images/<?php echo $image_display[$i];?>" target="_blank">
																	<img src="./images/<?php echo $image_display[$i];?>" height=100 width=100></img>
																</a>
															<?php } ?>
														<?php } ?>
													</td>
													<td>	
														<?php if($_SESSION['username'] == $row['username']){ ?>
															<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
														<?php }else if($_SESSION['username'] != $row['username']){ ?>
															<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
														<?php } ?>
													</td>   
													<!-- <td>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank'];?>	
													</td>  -->
													<td>
														<?php 
															$postdate = date('M d, Y', strtotime($row['time_created']));
															$posttime = date('g:i a', strtotime($row['time_created']));
														?>
														<?php echo $postdate;?> <?php echo $posttime ?>
													</td>  
													
													<td class="last">
														<?php if($row['deleted'] == 0){?>
															<?php if ($_SESSION['admin_auth'] == 1){ ?>
															
																<a href="delete.php?post_id=<?php echo $row['post_id']; ?>&team_id=<?php echo $row['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1">Delete</a><br>														
															
															<?php }else if ($row['member_name'] == $pres_user1_val['name']){ ?>
															
																<a href="delete.php?post_id=<?php echo $row['post_id']; ?>&team_id=<?php echo $row['t_team_id']; ?>&curpage=<?php echo $page; ?>&from=1" >Delete</a><br>														
															
															<?php }	?>
														<?php }else if($row['deleted'] == 1){echo Deleted; } ?>
													</td>
												</tr>
											<?php } ?>
										</tbody> 
									</table> 
									

								</div>
								<div style="margin-left: 20px;">
									<ul id='bp-3-element-test'></ul>
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
					               		 window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/viewTeam.php?team_id=<?php echo $team_id;?>&page='+page;
					            	}
								}
					            element.bootstrapPaginator(options);
					            var list = element.children();		           
					        })
					    });
					</script>


				<?php } ?>

				




			<?php
				$result->free();
				$con->close();
			?>
			</body>
			</html>
	<?php
			}
		} 
	} ?>

		


    
					


					

			
		
			
				
			

		

	

	

