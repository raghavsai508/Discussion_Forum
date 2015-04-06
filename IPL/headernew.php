
<html>
<head>
		<link href="./assets/css/ipl2014.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/main.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/teams.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/meetup1.css" rel="stylesheet" type="text/css">
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
					<a id="modal-309289" href="#modal-container-309289" role="button"  data-toggle="modal">
						<button type="submit" class="btn btn-info">
							<?php if($_SESSION['authuser']==0) { ?>
									Sign In
							<?php } else { ?>
									Sign Out
							<?php }	?>
						</button>
					</a>
				</div>
			</div>
		</div>
		
		
		<div class="modal fade" id="modal-container-309289" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">								
								Log out! 								
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">						
						<form role="form" method="post" action="session.php">
							<button type="submit" class="btn btn-info">Log Out</button>
						</form>																
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
									if ($team_id == 1){
								?>
								<li class="RR selected">
								<?php
								}
								else{
								?>
								<li class="RR ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=1">
										<span>Rajasthan Royals</span>
									</a>
								</li>
								<?php
									if ($team_id == 2){
								?>
								<li class="DD selected">
								<?php
								}
								else{
								?>
								<li class="DD   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=2">
									<span>Delhi Daredevils</span></a>
								</li> 
								<?php
									if ($team_id == 3){
								?>
								<li class="KXIP selected">
								<?php
								}
								else{
								?>
								<li class="KXIP   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=3">
									<span>Kings XI Punjab</span></a>
								</li>  
								<?php
									if ($team_id == 4){
								?>
								<li class="KKR selected">
								<?php
								}
								else{
								?>
								<li class="KKR   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=4">
									<span>Kolkata Knight Riders</span></a>
								</li> 
								<?php
									if ($team_id == 5){
								?>
								<li class="MI selected">
								<?php
								}
								else{
								?>
								<li class="MI   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=5">
									<span>Mumbai Indians</span></a>
								</li>	
								<?php
									if ($team_id == 6){
								?>
								<li class="RCB selected">
								<?php
								}
								else{
								?>
								<li class="RCB   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=6">
									<span>Royal Challengers Bangalore</span></a>
								</li>     
								<?php
									if ($team_id == 7){
								?>
								<li class="SH selected">
								<?php
								}
								else{
								?>
								<li class="SH   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=7">
									<span>Sunrisers Hyderabad</span></a>
								</li> 
								<?php
									if ($team_id == 8){
								?>
								<li class="CSK selected">
								<?php
								}
								else{
								?>
								<li class="CSK   ">
								<?php
								}
								?>
									<a href="viewTeam.php?team_id=8">
									<span>Chennai Super Kings</span></a>
								</li> 
							</ul>
					</div>
				</div>        