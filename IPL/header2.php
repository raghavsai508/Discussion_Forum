<html>
	<head>
		<link href="./assets/css/ipl2014.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/main.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/teams.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/meetup.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/boards.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/bootstrap.min.css" rel="stylesheet">

		<link rel="icon" type="image/png" href="http://www.iplt20.com/favicon.ico">
		
		<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="./assets/js/scripts.js"></script>
		<script src="//code.jquery.com/jquery-1.10.2.js"></script>

		<script src="./assets/js/bootstrap-paginator.js"></script>
		<script src="./assets/js/qunit-1.11.0.js"></script>


		
		<title>Halla Bol</title>   		
	</head>
	
	
	<body data-twttr-rendered="true" style="overflow: visible;">
	
		<div class="bcciGlobal">
			<div class="bcciGlobalContent">
				<div class="search">
					<?php if($_SESSION['signuser'] == 0) { ?>
						<a id="modal-309289" href="#modal-container-309289" role="button" style="display:visible;" data-toggle="modal">		
							<button type="submit" class="btn btn-info">Sign In</button>
						</a>
					<?php } else if($_SESSION['signuser'] == 1){ ?>
							<?php $my_name = $_SESSION['username'];	?>

							<div class="btn-group" >
							  	<button type="button" class="btn btn-info dropdown-toggle" style="display:visible;" data-toggle="dropdown">
							   		My Account <span class="caret"></span>
							  	</button>
							  	<ul class="dropdown-menu" role="menu" >
								    <li><a href="profile.php">Profile</a></li>
								    <li><a href="session.php">Sign Out</a></li>

							  	</ul>
							</div>
							<!-- <a href="session.php"><button type="submit" class="btn btn-info">Sign Out</button></a> -->
						<?php }	?>
				</div>
				<?php if($_SESSION['signuser'] == 1){ ?>
					<div class="search">
						<form id="search-form" class="header-search-form" action="search.php" method="GET">
							<span class="glass"><i></i></span>
							<input id="search-query" placeholder="Search" name="q"  type="text" >
						</form>
					</div><!-- END search -->&nbsp;&nbsp;&nbsp;
				<?php } ?>
			</div>
		</div>
			
		<div class="modal fade" id="modal-container-309289" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								<?php if($_SESSION['signuser']==0){	?>
										Please Log in 
										<h5 id="errorNote" style="color: red;" hidden></h5>
								<?php }else{ ?>
										Log out! 
								<?php } ?>
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">
						<?php if($_SESSION['signuser']==0){	?>
							<form id="loginform" role="form" method="post" action="checklogin.php">
								<div class="form-group">
									<label>User Name</label>
									<input type="text" class="form-control" id="inputUser" name="user" placeholder="User Name" required />
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" id="inputPass" name="pass" placeholder="Password" required />
									
									<div style="margin-left: 155px"><a href="validation.php?role=1">Forgot Password?</a></div>
								</div>
								<div class="checkbox">
									<label>
										<input id="inputCheck" type="checkbox" name="remember" value="remember"> Stay Signed in
									</label>
								</div>
								<button id="logincheck" type="submit" class="btn btn-info" name="check" value="check">Submit</button>		
							</form>
						<?php }else{ ?>
							<form role="form" method="post" action="session.php">
								<button type="submit" class="btn btn-info">Log Out</button>
							</form>
						<?php }	?>										
					</div>
				</div>			
			</div>
		</div>
		
		<div class="masthead">
			<div class="mastheadContent"> 
				<div class="wrapper">                           
					<div class="teamSubMenu">
						<ul><!-- menu -->  
							<?php 
								if ($_SESSION['signuser'] == 0){
							?>
								<li class="RR ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Rajasthan Royals</span></a>
								</li> 						     
								<li class="DD   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Delhi Daredevils</span></a>
								</li>      
								<li class="KXIP   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Kings XI Punjab</span></a>
								</li>      
								<li class="KKR   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Kolkata Knight Riders</span></a>
								</li>      
								<li class="MI   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Mumbai Indians</span></a>
								</li>																				   
								<li class="RCB   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Royal Challengers Bangalore</span></a>
								</li>      
								<li class="SH   ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Sunrisers Hyderabad</span></a>
								</li>      
								<li class="CSK  ">
									<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
									<span>Chennai Super Kings</span></a>
								</li> 
							<?php
							} 
							else{
							?>							
								<li class="RR ">
									<a id="modal-123" href="viewTeam.php?team_id=1">
									<span>Rajasthan Royals</span></a>
								</li> 						     
								<li class="DD   ">
									<a id="modal-123" href="viewTeam.php?team_id=2">
									<span>Delhi Daredevils</span></a>
								</li>      
								<li class="KXIP   ">
									<a id="modal-123" href="viewTeam.php?team_id=3">
									<span>Kings XI Punjab</span></a>
								</li>      
								<li class="KKR   ">
									<a id="modal-123" href="viewTeam.php?team_id=4">
									<span>Kolkata Knight Riders</span></a>
								</li>      
								<li class="MI   ">
									<a id="modal-123" href="viewTeam.php?team_id=5">
									<span>Mumbai Indians</span></a>
								</li>																				   
								<li class="RCB   ">
									<a id="modal-123" href="viewTeam.php?team_id=6">
									<span>Royal Challengers Bangalore</span></a>
								</li>      
								<li class="SH   ">
									<a id="modal-123" href="viewTeam.php?team_id=7">
									<span>Sunrisers Hyderabad</span></a>
								</li>      
								<li class="CSK  ">
									<a id="modal-123" href="viewTeam.php?team_id=8">
									<span>Chennai Super Kings</span></a>
								</li> 
								
							<?php
							}
							?>
						</ul>
					</div>
				</div>   
