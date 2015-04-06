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
			

			<div class="wrapper">
				<div class="main-content ">
					<div class="hero">
						<div class="heroContent">
							<br><br>
							<ol class="breadcrumb">
								  <li><a href="index.php">Home</a></li>
								  <?php if ($_SESSION['admin_auth'] == 1){ ?>
										<li class="active">Admin</a></li>									
									<?php }else if($_SESSION['mod_auth'] == 1){ ?>
										<li class="active">Moderator</a></li>	
									<?php } ?>
							</ol><br>
							<div class="panel panel-primary">
							  	<div class="panel-heading">
								 	<h3 class="panel-title">Welcome! <?php echo $row['name'];?> </h3>
							  	</div>
								<div class="panel-body"> 
									<table class="table">
										<thead>
											<tr>
												<td><a href="members.php"><button class="btn btn-info">MEMBERS</button></a><br></td>
												<td><a href="posts.php"><button class="btn btn-info">POSTS</button></a><br></td>
												<td class="last"><a href="pagination.php"><button class="btn btn-info">PAGINATION</button></a><br></td>
												 <?php if ($_SESSION['admin_auth'] == 1){ ?>
													<td class="last"><a href="imageLimit.php"><button class="btn btn-info">IMAGE LIMIT</button></a><br></td>
												<?php } ?>
											</tr>
											
										</thead>
									</table>
																			
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</body>				
	</html>
	<?php }		
					

	} ?>