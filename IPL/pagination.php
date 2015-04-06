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
			<?php
				$view_team_pages = "select page_name,num_pages from proj4_pages where page_name = 'view page'";
				$view_team_pages_result = $con->query($view_team_pages) or die ($con->error);

				$view_thread_pages = "select page_name,num_pages from proj4_pages where page_name = 'view thread'";
				$view_thread_pages_result = $con->query($view_thread_pages) or die ($con->error);

				$members_pages = "select page_name,num_pages from proj4_pages where page_name = 'members'";
				$members_pages_result = $con->query($members_pages) or die ($con->error);

				$posts_pages = "select page_name,num_pages from proj4_pages where page_name = 'posts'";
				$posts_pages_result = $con->query($posts_pages) or die ($con->error);

				$view_team_pages_val = $view_team_pages_result->fetch_assoc();
				$view_thread_pages_val = $view_thread_pages_result->fetch_assoc();
				$members_pages_val = $members_pages_result->fetch_assoc();
				$posts_pages_val = $posts_pages_result->fetch_assoc();

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
								  <li class="active">Pagination</li>
							</ol><br>
							<div class="panel panel-primary">
							  	<div class="panel-heading">
								 	<h3 class="panel-title">Pagination-Select the number of pages to display</h3>
							  	</div>
								<div class="panel-body">
									<table class="table">    
											<thead>      
												<tr >        
													<td><strong>View Team Page</strong></td>        
													<td><strong>View Thread Page</strong></td>  
													<td><strong>MembersPage</strong></td>
													<td><strong>Posts Page</strong></td>

												</tr>  
											</thead>  
											<tbody>
												<tr>
													<td>
														<div class="btn-group">
														  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														   <?php echo $view_team_pages_val['num_pages']; ?> <span class="caret"></span>
														  </button>
														  <ul class="dropdown-menu" role="menu">
														    <li><a href="update.php?role=5&num_pages=1&page_name=view page">1</a></li>
														    <li><a href="update.php?role=5&num_pages=2&page_name=view page">2</a></li>
														    <li><a href="update.php?role=5&num_pages=3&page_name=view page">3</a></li>
														    <li><a href="update.php?role=5&num_pages=4&page_name=view page">4</a></li>
														    <li><a href="update.php?role=5&num_pages=5&page_name=view page">5</a></li>
														    <li><a href="update.php?role=5&num_pages=6&page_name=view page">6</a></li>
														    <li><a href="update.php?role=5&num_pages=7&page_name=view page">7</a></li>
															<li><a href="update.php?role=5&num_pages=8&page_name=view page">8</a></li>
															<li><a href="update.php?role=5&num_pages=9&page_name=view page">9</a></li>
															<li><a href="update.php?role=5&num_pages=10&page_name=view page">10</a></li>										
														  </ul>
														</div>
													</td>
													<td>
														<div class="btn-group">
														  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														    <?php echo $view_thread_pages_val['num_pages']; ?>  <span class="caret"></span>
														  </button>
														  <ul class="dropdown-menu" style="overflow:visible" role="menu">
														    <li><a href="update.php?role=5&num_pages=1&page_name=view thread">1</a></li>
														    <li><a href="update.php?role=5&num_pages=2&page_name=view thread">2</a></li>
														    <li><a href="update.php?role=5&num_pages=3&page_name=view thread">3</a></li>
														    <li><a href="update.php?role=5&num_pages=4&page_name=view thread">4</a></li>
														    <li><a href="update.php?role=5&num_pages=5&page_name=view thread">5</a></li>
														    <li><a href="update.php?role=5&num_pages=6&page_name=view thread">6</a></li>
														    <li><a href="update.php?role=5&num_pages=7&page_name=view thread">7</a></li>
															<li><a href="update.php?role=5&num_pages=8&page_name=view thread">8</a></li>
															<li><a href="update.php?role=5&num_pages=9&page_name=view thread">9</a></li>
															<li><a href="update.php?role=5&num_pages=10&page_name=view thread">10</a></li>		
														 
														  </ul>
														</div>
													</td>
													<td>
														<div class="btn-group">
														  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														    <?php echo $members_pages_val['num_pages']; ?>  <span class="caret"></span>
														  </button>
														  <ul class="dropdown-menu" role="menu">
														    <li><a href="update.php?role=5&num_pages=1&page_name=members">1</a></li>
														    <li><a href="update.php?role=5&num_pages=2&page_name=members">2</a></li>
														    <li><a href="update.php?role=5&num_pages=3&page_name=members">3</a></li>
														    <li><a href="update.php?role=5&num_pages=4&page_name=members">4</a></li>
														    <li><a href="update.php?role=5&num_pages=5&page_name=members">5</a></li>
														    <li><a href="update.php?role=5&num_pages=6&page_name=members">6</a></li>
														    <li><a href="update.php?role=5&num_pages=7&page_name=members">7</a></li>
															<li><a href="update.php?role=5&num_pages=8&page_name=members">8</a></li>
															<li><a href="update.php?role=5&num_pages=9&page_name=members">9</a></li>
															<li><a href="update.php?role=5&num_pages=10&page_name=members">10</a></li>			
														  
														  </ul>
														</div>
													</td>
													<td>
														<div class="btn-group">
														  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														    <?php echo $posts_pages_val['num_pages']; ?>  <span class="caret"></span>
														  </button>
														  <ul class="dropdown-menu" role="menu">
														    <li><a href="update.php?role=5&num_pages=1&page_name=posts">1</a></li>
														    <li><a href="update.php?role=5&num_pages=2&page_name=posts">2</a></li>
														    <li><a href="update.php?role=5&num_pages=3&page_name=posts">3</a></li>
														    <li><a href="update.php?role=5&num_pages=4&page_name=posts">4</a></li>
														    <li><a href="update.php?role=5&num_pages=5&page_name=posts">5</a></li>
														    <li><a href="update.php?role=5&num_pages=6&page_name=posts">6</a></li>
														    <li><a href="update.php?role=5&num_pages=7&page_name=posts">7</a></li>
															<li><a href="update.php?role=5&num_pages=8&page_name=posts">8</a></li>
															<li><a href="update.php?role=5&num_pages=9&page_name=posts">9</a></li>
															<li><a href="update.php?role=5&num_pages=10&page_name=posts">10</a></li>			
														
														  </ul>
														</div>
													</td>
												</tr>

											</tbody>
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
}
?>