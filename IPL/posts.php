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
?>	

        
					
				
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
									$row = $name_result->fetch_assoc(); ?>
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

			$posts_pages = "select page_name,num_pages from proj4_pages where page_name = 'posts'";
			$posts_pages_result = $con->query($posts_pages) or die ($con->error);
			$posts_pages_val = $posts_pages_result->fetch_assoc();

			$num_posts_per_page=$posts_pages_val['num_pages'];
			if($_GET['page']){
				$page=$_GET['page'];
			}else{
				$page=1;
			}
			$pageno=($page-1)*$num_posts_per_page;
			$tot_posts = "select post_id, member_name,username,role,post_title,message,time_created,team_id,deleted,freeze,rank,team_name from proj4_posts p4p,proj4_teams p4t, proj4_members p4m where p4p.t_team_id = p4t.team_id and p4m.name = p4p.member_name order by team_id,time_created desc limit $pageno,$num_posts_per_page";
			$tot_posts_result = $con->query($tot_posts) or die ($con->error);

			$posts = "select post_id, member_name,post_title,message,time_created,team_id,team_name from proj4_posts p4p,proj4_teams p4t where p4p.t_team_id = p4t.team_id order by team_id,time_created desc";
			$posts_result = $con->query($posts) or die ($con->error);

			$num_rows=$posts_result->num_rows;
			$totalpages=ceil($num_rows/$num_posts_per_page);

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
								  <li class="active">Posts</li>
							</ol><br>
								<div class="panel panel-primary">
								  <div class="panel-heading">
							   		 <h3 class="panel-title">Posts</h3>
							  	  </div>
							  	  <div class="panel-body">
										<table class="table">    
											<thead>      
												<tr >        
													<td><strong>Team</strong></td>        
													<td><strong>Author</strong></td>  
													<td><strong>Post Title</strong></td>
													<td><strong>Message</strong></td> 													
													<td><strong>Created on</strong></td>  
												</tr>  
											</thead> 
											<tbody> 
												<?php while($tot_posts_val = $tot_posts_result->fetch_assoc()){	?>
														<tr class="member"> 												
															<td class="first team">     
																<a href="viewTeam.php?team_id=<?php echo $tot_posts_val['team_id']; ?>"><?php echo $tot_posts_val['team_name']; ?>
																</a>													
															</td>        
															<td>	
																<?php if($_SESSION['username'] == $tot_posts_val['username']){ ?>
																	<a href="profile.php"><?php echo $tot_posts_val['member_name'];?></a> (<?php echo $tot_posts_val['role'];?>)<br><?php echo $tot_posts_val['rank']; ?>
																<?php }else if($_SESSION['username'] != $tot_posts_val['username']){ ?>
																	<a href="userProfile.php?seeUser=<?php echo $tot_posts_val['username']; ?>"><?php echo $tot_posts_val['member_name'];?></a> (<?php echo $tot_posts_val['role'];?>)<br><?php echo $tot_posts_val['rank']; ?>
																<?php } ?>
															</td>      
															<td><a href="viewThread.php?post_id=<?php echo $tot_posts_val['post_id'];?>&team_id=<?php echo $tot_posts_val['team_id'];?>" ><?php echo $tot_posts_val['post_title']; ?> </td> 
															<td><?php echo $tot_posts_val['message']; ?> </td>

															<td class="last" style="width:11%;">
																<?php 
																	$postdate = date('M d, Y', strtotime($tot_posts_val['time_created']));
																	$posttime = date('g:i a', strtotime($tot_posts_val['time_created']));
																?>
																<?php echo $postdate;?> <?php echo $posttime ?>
															</td>  
															
															<td class="last" style="width:9%;">
																<?php if($tot_posts_val['deleted'] == 0){ ?>
																	<a href="delete.php?post_id=<?php echo $tot_posts_val['post_id']; ?>&team_id=<?php echo $tot_posts_val['team_id']; ?>&from=3&page=<?php echo $page; ?>" >Delete</a>
																<?php }else if($tot_posts_val['deleted'] == 1){echo Deleted;}?>	<br>
																															
																<?php if($tot_posts_val['freeze'] == 1){ ?>
																	<a href="delete.php?post_id=<?php echo $tot_posts_val['post_id']; ?>&team_id=<?php echo $tot_posts_val['team_id']; ?>&from=5&page=<?php echo $page; ?>" >Un-Freeze</a>
																<?php }else if($tot_posts_val['freeze'] == 0){ ?>
																	<a href="delete.php?post_id=<?php echo $tot_posts_val['post_id']; ?>&team_id=<?php echo $tot_posts_val['team_id']; ?>&from=4&page=<?php echo $page; ?>" >Freeze</a>
																<?php } ?>
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
			               		 window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/posts.php?page='+page;
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