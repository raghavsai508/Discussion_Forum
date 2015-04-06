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

			$members_pages = "select page_name,num_pages from proj4_pages where page_name = 'members'";
			$members_pages_result = $con->query($members_pages) or die ($con->error);
			$members_pages_val = $members_pages_result->fetch_assoc();

			$num_posts_per_page=$members_pages_val['num_pages'];
			if($_GET['page']){
				$page=$_GET['page'];
			}else{
				$page=1;
			}
			$pageno=($page-1)*$num_posts_per_page;
			$tot_mem="select username,name,email,role,rank,time_joined,suspension from proj4_members limit $pageno,$num_posts_per_page";
			$tot_mem_result = $con->query($tot_mem) or die ($con->error);
			
			$members="select username,name,email,role from proj4_members";
			$members_result = $con->query($members) or die ($con->error);
			
			$num_rows=$members_result->num_rows;


			$totalpages=ceil($num_rows/$num_posts_per_page);

			$present_user = $_SESSION['username'];
			$auth_check = "select role from proj4_members where username = '$present_user' ";
			$auth_check_res = $con->query($auth_check);
			$auth_check_val = $auth_check_res->fetch_assoc();


		?>
		<?php if($auth_check_val['role'] == 'moderator'){ ?>
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
							  <li class="active">Members</li>
						</ol><br>
								<div class="panel panel-primary">
								  <div class="panel-heading">
							   		 <h3 class="panel-title">Members</h3>
							  	  </div>
									<div class="panel-body">
										<table class="table">    
											<thead>      
												<tr >        
													<td><strong>Member</strong></td>        
													<td><strong>Joined On</strong></td>  
													<td><strong>Email</strong></td>
													<td><strong>Role</strong></td> 
													<td><strong>Rank</strong></td> 													
												</tr>  
											</thead>  
											<tbody> 
												<?php while($row = $tot_mem_result->fetch_assoc()){
														$role= $row['role'];
														$user= $row['username'];
														$suspend = $row['suspension'];
												?>
														<tr class="member"> 							
																										
															<td class="first team">     
																<a href="memstats.php?name=<?php echo $user; ?>"><?php echo $row['name']; ?></a>
															</td>        
															<td>
																<?php 
																	$regdate = date('M d, Y', strtotime($row['time_joined']));
																	$regtime = date('g:i a', strtotime($row['time_joined']));
																?>
																<?php echo $regdate;?> <?php echo $regtime ?>
															</td>    
															<td><?php echo $row['email']; ?> </td> 
															<td class="last"><?php echo $row['role']; ?> </td>	
															<td><?php echo $row['rank']; ?> </td>
																														
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
			</div>

		<?php }else if($auth_check_val['role'] == 'admin'){ ?>
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
							  <li class="active">Members</li>
						</ol><br>
								<div class="panel panel-primary">
								  	<div class="panel-heading">
							   		 	<h3 class="panel-title">Members</h3>
							  	  	</div>
									<div class="panel-body">
										<table class="table">    
											<thead>      
												<tr >        
													<td><strong>Member</strong></td>        
													<td><strong>Joined On</strong></td>  
													<td><strong>Email</strong></td>
													<td><strong>Role</strong></td> 
													<td><strong>Rank</strong></td> 
													<td><strong>Options</strong></td>  
												</tr>  
											</thead>  
											<tbody> 
												<?php while($row = $tot_mem_result->fetch_assoc()){
														$role= $row['role'];
														$user= $row['username'];
														$suspend = $row['suspension'];
												?>
														<tr class="member"> 							
																										
															<td class="first team">     
																<a href="memstats.php?name=<?php echo $user; ?>"><?php echo $row['name']; ?></a>
															</td>        
															<td>
																<?php 
																	$regdate = date('M d, Y', strtotime($row['time_joined']));
																	$regtime = date('g:i a', strtotime($row['time_joined']));
																?>
																<?php echo $regdate;?> <?php echo $regtime ?>
															</td>   
															<td><?php echo $row['email']; ?> </td> 
															<td><?php echo $row['role']; ?> </td>	
															<td><?php echo $row['rank']; ?> </td>	
															<td class="last">
																<?php if(/*$user =='cpallapo' ||*/ $user =='ta'){ ?>
																		<button type="button" class="btn btn-warning btn-sm dropdown-toggle" data-toggle="dropdown" style="text-transform: uppercase;">
																			<?php echo admin; ?>
																		</button>
																<?php }else{ ?>

																<div class="btn-group">
																	<button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" style="text-transform: uppercase;">
																		<?php echo $role ?> <span class="caret"></span>
																	</button>
																	
																	<?php
																		if ($role=="user"){
																	?>
																	<ul class="dropdown-menu" style="overflow:visible; text-transform: uppercase;" role="menu">
																		<li>
																			<a href="update.php?role=1&name=<?php echo $user; ?>">Admin</a>
																		</li>
																		<li>
																			<a href="update.php?role=2&name=<?php echo $user; ?>">Moderator</a>
																		</li>
																		<li>
																			<a href="update.php?role=0&name=<?php echo $user; ?>">Delete</a>
																		</li>
																	</ul>
																	<?php
																	}
																	?>
																	<?php
																		if ($role=="admin"){
																	?>
																	<ul class="dropdown-menu" style="overflow:visible; text-transform: uppercase;" role="menu">
																		<li>
																			<a href="update.php?role=2&name=<?php echo $user; ?>">Moderator</a>
																		</li>
																		<li>
																			<a href="update.php?role=3&name=<?php echo $user; ?>">User</a>
																		</li>
																		<li>
																			<a href="update.php?role=0&name=<?php echo $user; ?>">Delete</a>
																		</li>
																	</ul>
																	<?php
																	}
																	?>
																	<?php
																		if ($role=="moderator"){
																	?>
																	<ul class="dropdown-menu" style="overflow:visible; text-transform: uppercase;" role="menu">
																		<li>
																			<a href="update.php?role=1&name=<?php echo $user; ?>">Admin</a>
																		</li>
																		<li>
																			<a href="update.php?role=3&name=<?php echo $user; ?>">User</a>
																		</li>
																		<li>
																			<a href="update.php?role=0&name=<?php echo $user; ?>">Delete</a>
																		</li>
																	</ul>
																	<?php
																	}
																	?>
																</div>
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
			</div>
		<?php } ?>

		

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
			               		 window.location.href = 'http://weiglevm.cs.odu.edu/~cpallapo/proj4/members.php?page='+page;
			            	}
						}
			            element.bootstrapPaginator(options);

			            var list = element.children();		           
			        })
			    });
		</script>		
	</body>	
</html>

<?php }
}
	
$members_result->free();
$con->close();
?>
