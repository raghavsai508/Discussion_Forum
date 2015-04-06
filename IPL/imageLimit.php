<?php
	session_start();

	
	if ($_SESSION['signuser'] == 0 || $_SESSION['permission'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1){
		if($_SESSION['admin_auth'] == 1){
			$_SESSION['update']=1;
			include "dbconnect.php";
			include "header.php";
			$_SESSION['search_team'] = 9;
?>	
			
					<div class="primaryMenu">
						<div class="wrapper">      
							<div class="masthead-menu">
								<ul id="yw1">
									<li ><a href="index.php">Home</a></li>
									
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
				$rank_select = "select user_rank,image_limit from proj4_images_limit";
				$rank_select_res = $con->query($rank_select);

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
								  <li class="active">Image Limit</li>
							</ol><br>

							<div class="panel panel-primary">
							  	<div class="panel-heading">
								 	<h3 class="panel-title">Select the number of Images Limit For</h3>
							  	</div>
								<div class="panel-body">
									<table class="table">    
										<thead>      
											<tr>											  
												<td><strong>Newbie</strong></td>        
												<td><strong>Journey Man</strong></td>  
												<td><strong>Master</strong></td>																			
											</tr>  
										</thead> 
										<tbody>
											<tr>
												<?php while($rank_select_val = $rank_select_res->fetch_assoc()){ ?>
													<td>													
														<div class="btn-group">
															<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
																<?php echo $rank_select_val['image_limit']; ?> <span class="caret"></span>
															</button>
															<ul class="dropdown-menu" role="menu">
															    <li><a href="update.php?role=7&image_value=1&rank=<?php echo $rank_select_val['user_rank']?>">1</a></li>
															    <li><a href="update.php?role=7&image_value=2&rank=<?php echo $rank_select_val['user_rank']?>">2</a></li>
															    <li><a href="update.php?role=7&image_value=3&rank=<?php echo $rank_select_val['user_rank']?>">3</a></li>
															    <li><a href="update.php?role=7&image_value=4&rank=<?php echo $rank_select_val['user_rank']?>">4</a></li>
															    <li><a href="update.php?role=7&image_value=5&rank=<?php echo $rank_select_val['user_rank']?>">5</a></li>
															    <li><a href="update.php?role=7&image_value=6&rank=<?php echo $rank_select_val['user_rank']?>">6</a></li>									
															</ul>
														</div>													
													</td>
												<?php } ?>
											</tr>
										</tbody> 
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } ?>