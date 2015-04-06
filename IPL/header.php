<?php 

	require 'CaptchasDotNet.php';
	$captchas = new CaptchasDotNet ('cpallapo', 'hdwXW3ggKcrcY0Foyidg1EHtTJ2OOuzqmc3uGHir',
                                '/tmp/captchasnet-random-strings','3600',
                                'abcdefghkmnopqrstuvwxyz','6',
                                '268','80','000000');
?>


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
				<?php if($_SESSION['signuser'] == 0){	?>	
					<div class="search">
						<a id="modal-309290" href="#modal-container-309290" role="button"  data-toggle="modal">
							<button type="submit" class="btn btn-info">
								Register!
							</button>
						</a>
					</div>
				<?php } ?>	
				<?php if($_SESSION['signuser'] == 1){ ?>
					<div class="search">
						<form id="search-form" class="input-medium search-query" action="search.php" method="POST">
							<span class="glass"><i class="icon-search"></i></span>
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
										<h5 id="signinNote" style="color: red;" hidden></h5>
								<?php }else{ ?>
										Log out! 
								<?php } ?>
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">
						<?php if($_SESSION['signuser']==0){	?>
							<form id="loginform" role="form" method="post" action="checkLogin.php">
								<div class="form-group">
									<label>User Name </label>
									<input type="text" class="form-control" id="inputUser" name="user" required placeholder="User Name"  />
								</div>
								<div class="form-group">
									<label>Password </label>
									<input type="password" class="form-control" id="inputPass" name="pass" required placeholder="Password"  />
									
									<div style="margin-left: 155px"><a href="forgot.php">Forgot Password?</a></div>
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
								<button type="submit" class="btn btn-info">Sign Out</button>
							</form>
						<?php }	?>										
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
								Sign Up Form
								<h5 id="registerNote6" style="color: red;" hidden></h5>
							</h4>
					</div><!--end modal header-->
					<div class="modal-body">
						<form id="registrationform">
						 	<!-- <input type="hidden" name="random" id="random" value="<?= $captchas->random () ?>" /> -->
							<div class="form-group">
								<label>Name </label>
								<input id="regName" type="text" class="form-control" name="name" placeholder="Name" required />								
							</div>
							<div class="form-group">
								<label>User Name </label>
								<input id="regUsername" type="text" class="form-control" name="username" placeholder="User Name" required />
								<h5 id="registerNote1" style="color: red;" hidden></h5>
							</div>
							<div class="form-group">
								<label>Email </label>
								<input id="regEmail" type="text" class="form-control" name="email" placeholder="user@cs.odu.edu" resquired />
								<h5 id="registerNote2" style="color: red;" hidden></h5>
							</div>
							<div class="form-group">
								<label>Password </label>
								<input id="regPassword" type="password" class="form-control" name="password" placeholder="Password" required />
								
							</div>
							<div class="form-group">
								<label>Confirm Password </label>
								<input id="regConpass" type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required />
								<h5 id="registerNote3" style="color: red;" hidden></h5>
							</div>

							<div>
								<label>Please Enter the Captcha:</label>			
								<input  id="regCaptcha" type="text" class="form-control" name="captcha_code"   placeholder="Captcha" required/>
								<h5 id="registerNote5" style="color: red;" hidden></h5>
								<br>&nbsp;<img id="captcha" src="./securimage/securimage_show.php" alt="CAPTCHA Image" style="width:230px;" />
									<a href="#" onclick="document.getElementById('captcha').src = './securimage/securimage_show.php?' + Math.random(); return false">
										<br>Reload Image
									</a>
							</div><br>

							<!-- <label>Upload Profile Picture:</label> -->
							<div class="form-group">
								<label>User Avatar </label>
								<input name="image_filename" type="file" id="image_filename" class="form-control" accept="image/jpeg,image/jpg,image/png,image/gif">
								<h5 id="registerNote7" style="color: red;" hidden></h5>
							</div>
							<!-- <div class="input-group" style="margin-right: 340px;">

								<span class="input-group-btn">									
									<span class="btn btn-default btn-file">
										Browse<input type="file" multiple="">
									</span>
									<input type="text" class="form-control" required>
								</span>								
							</div> -->
							<br>

							<label>Email Option </label>
							<input  type="radio" name="option" value="html"> text/html Mail &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input   type="radio" name="option" value="plain"> text/plain Mail							
							
							<br><br>
							<input type="hidden" name="checkRegisterAuth" value="1">					
							<button id="signupcheck" type="submit" class="btn btn-info" name="signup" value="signup">Sign Up</button>	
							<button id="resetform" type="reset" class="btn btn-info" name="reset" value="reset">Reset</button>	
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
