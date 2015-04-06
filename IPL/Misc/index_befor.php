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
		<link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/main.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/teams.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/meetup.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/boards.css" rel="stylesheet" type="text/css">
		<link href="./assets/css/bootstrap.min.css" rel="stylesheet">
		<link rel="shortcut icon" href="./assets/img/RR.png" />
		
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
			
				$("#submit1").click(function(){			
					if ( ($("#reply").val()).length != 0) {
						$("#submission").submit();
					}
					else if(($("#reply").val()).length == 0){
						$("#modal-container-309291").show();
					}
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
								Let me In
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
			<!--<div class="search">
				<form id="search-form" class="header-search-form" action="" method="GET">
					<span class="glass"><i></i></span>
						<input value="" placeholder="Search" name="q" id="search-query" type="text" class="">
				</form>
			</div><!-- END search -->		
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
											<input type="checkbox"> Stay Signed in
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
								<li><a href="newDiscussion.php">New Discussion</a></li>
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
						<div class="D_box">
							<div class="D_boxbody">
								<div class="D_boxhead">
									<h1>Discussions</h1>
								</div>
								<div class="D_boxsection isSorted">
									<table class="D_boardThread">
										<tbody>
											<?php
												$query="select post_user,message,time_created,postid from posts order by postid desc";
												$result = $con->query($query) or die ($con->error);
												while ($row = $result->fetch_assoc()) 
												{
													?>
													<tr class="bdMsgHead D_header">
														<td class="D_member first">
															<?php
																echo $row['post_user'];
															?><!--user name should be displayed here-->
														</td>

														<td class="last">
															<ul class="inlineList boardActions">
																<li class="margin-right">
																	<span class="nobr">
																		<strong>
																			<?php
																				echo "Posted On: ".$row['time_created']; 
																			?>
																		</strong>
																	</span>

																</li>	<!--for replying  -->
																
																<li class="margin-right">
																	<a href="#reply">reply</a>
																</li>
															</ul>
														</td>
													</tr>
													<tr class="bdMsgBody D_body">
														<td class="D_member">
															<div>
																<?php echo $row['postid']; ?><!--post number shold be displayed -->
															</div>
														</td>
														<td class="last main" colspan="2">
															<div class="D_bbcode">
																<?php
																	echo $row['message'];
												}
																?>
															</div>
														</td>
													</tr>
													
										</tbody>
									</table>
								</div>
								<form id = "submission" method="POST" action="submit.php">
								<textarea cols="40" rows="10" name="reply" id="reply"></textarea><br>
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
									<a id="modal-309290" href="#modal-container-309291" role="button"  data-toggle="modal">
										<button id= "submit1" class="btn btn-primary" type="button" value="submit">Submit</button>
									</a>
								<?php										
								}
								?>
									</form>

							</div>
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
								Please Log in to post message
							</h4>
					</div>
					<div id="modal-309291" class="modal-body">
						<a id="modal-309290" href="#modal-container-309289" data-toggle="modal" >Click Here</a> to Log in!
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modal-container-309291" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 class="modal-title" id="myModalLabel">
								Please Enter Something to Post
							</h4>
					</div>
					<div id="modal-309292"class="modal-body">						
						<a id="modal-309293" href="https://weiglevm.cs.odu.edu/~cpallapo/proj2/index.php" data-toggle="modal" >
							<button class="btn btn-primary"> Ok!!</button>
						</a>
					</div>
				</div>
			</div>
		</div>
				
		<?php
			$result->free();
			$con->close();
		?>
	</body>
</html>