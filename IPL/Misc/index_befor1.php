<?php
session_start();
$con=mysqli_connect("localhost","cpallapo","getlost1","cpallapo");
//Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
?>

<html>
	<head>
		<link href="./assets/css/pulse-ipl-2014.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/main.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/teams.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/meetup.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/boards.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
		<!--<link rel="shortcut icon" href="./assets/img/RR.png" />-->
		<link rel="icon" type="image/png" href="http://www.iplt20.com/favicon.ico">
		
		<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./assets/js/scripts.js"></script>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>
		
		<script>		
			$( document ).ready(function() {		
				
				$("#modal-309291").click(function() {
					$("#modal-container-309290").hide();
				});	

				$("#modal-309292").click(function() {
					$("#modal-container-309291").hide();
				});			
			});	
		</script>
		
		<title>Halla Bol</title>   		
	</head>
	
	
	<body data-twttr-rendered="true" style="overflow: visible;">
	
		<div class="bcciGlobal">
			<div class="bcciGlobalContent">
				<div class="search">
					<a id="modal-309289" href="#modal-container-309289" role="button"  data-toggle="modal">
						<button type="submit" class="btn btn-info">
							<?php 
								if($_SESSION['authuser']==0)
								{
							?>
									Sign In
									<?php 
								} 
								else
								{ 
									?>
									Welcome! 
									<?php
									$username = $_SESSION['username'];
									$name="select name from members where username = '$username'";
									$name_result = $con->query($name) or die ($con->error);
									$row = $name_result->fetch_assoc();
									echo $row['name'];
								}
									?>
						</button></a>
				</div>	
			</div><!-- END bcciGlobalContent -->
		</div><!-- END bcciGlobal -->
		
		
		<div class="modal fade" id="modal-container-309289" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								<?php 
									if($_SESSION['authuser']==0)
									{
										?>
										Please Log in 
										<?php 
									} 
									else
									{ 
										?>
										Log out! 
										<?php
									}
										?>
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">
						<?php 
							if($_SESSION['authuser']==0)
							{
						?>
								<form role="form" method="post" action="validation.php">
									<div class="form-group">
										<label>User Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1" name="user" placeholder="User Name" required />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="exampleInputPassword1" name="pass" placeholder="Password" required />
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" value="remember"> Stay Signed in
										</label>
									</div>
									<button type="submit" class="btn btn-primary">Submit</button>		
								</form>
								<?php 
							} 
							else
							{
								?>
								<form role="form" method="post" action="session1.php">
									<button type="submit" class="btn btn-primary">logout</button>
								</form>
								<?php 
							}
								?>										
					</div><!--end modal body-->
				</div><!--end modal content-->						
			</div><!--end modal dialog-->
		</div><!--end modal fade-->
		
		<div class="masthead">
			<div class="mastheadContent"> 
				<div class="wrapper">                           
					<div class="teamSubMenu">
						<ul><!-- menu -->    
							<li class="RR   ">
								<a href="">
								<span>Rajasthan Royals</span></a>
							</li> 						     
							<li class="DD   ">
								<a href="">
								<span>Delhi Daredevils</span></a>
							</li>      
							<li class="KXIP   ">
								<a href="">
								<span>Kings XI Punjab</span></a>
							</li>      
							<li class="KKR   ">
								<a href="">
								<span>Kolkata Knight Riders</span></a>
							</li>      
							<li class="MI   ">
								<a href="">
								<span>Mumbai Indians</span></a>
							</li>																				   
							<li class="RCB   ">
								<a href="">
								<span>Royal Challengers Bangalore</span></a>
							</li>      
							<li class="SH   ">
								<a href="">
								<span>Sunrisers Hyderabad</span></a>
							</li>      
							<li class="CSK  ">
								<a href="">
								<span>Chennai Super Kings</span></a>
							</li> 
						</ul>
					</div>
				</div>        
																														
				<div class="primaryMenu">
					<div class="wrapper">      
						<div class="masthead-menu">
							<ul id="yw1">
								<li><a href="index.php">Home</a></li>
								<li class="selected"><a href="index.php">New Discission</a></li>
								<?php	
									if ($_SESSION['admin_auth'] == 1){
								?>
									<li><a href="members.php">Members</a></li>
								<?php
								}
								?>
								
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
							<div class="D_boxbody">
								<div class="D_boxhead">
									<h3>New Discussion</h3>
								</div>
								<br><br>
								<form id = "submission" method="POST" action="submit.php">
									
									<label for="title" class="col-lg-2 control-label">Title</label>
									<textarea  class = "form-control" rows="1" name="name" id="name" placeholder="Title" ></textarea><br>
									
									<label for="textArea" class="col-lg-2 control-label">Textarea</label>
									<textarea  class = "form-control" rows="5" name="comment" id="comment" placeholder="Comment...."></textarea><br>
									<input type="hidden" name="newdisc" value="1">
										<?php 
										if($_SESSION['authuser']==0)
										{
										?>								
											<a id="modal-309290" href="#modal-container-309290" role="button"  data-toggle="modal">
												<button class="btn btn-primary">Submit</button>
											</a>								
											<?php
										}
										else
										{
											?>	
											<button class="btn btn-primary" type="submit" value="submit">Submit</button>

										<?php										
										}
										?>
								</form>
							</div>						
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modal-container-309290" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								Please Sign In to continue
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">						
								<form role="form" method="post" action="validation.php">
									<div class="form-group">
										<label>User Name</label>
										<input type="text" class="form-control" id="exampleInputEmail1" name="user" placeholder="User Name" required />
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" id="exampleInputPassword1" name="pass" placeholder="Password" required />
									</div>
									<div class="checkbox">
										<label>
											<input type="checkbox" value="remember"> Stay Signed in
										</label>
									</div>
									<input type="hidden" name="newdisc" value="1">
									<button type="submit" class="btn btn-primary">Submit</button>		
								</form>
					</div><!--end modal body-->
				</div><!--end modal content-->						
			</div><!--end modal dialog-->
		</div><!--end modal fade-->
	</body>
</html>