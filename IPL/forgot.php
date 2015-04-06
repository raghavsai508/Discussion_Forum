<?php
	session_start();

	include "dbconnect.php";
	include "header.php"; 
	$_SESSION['search_team'] = 9; ?>

	<script>
		$(document).ready(function(e){

			$('#forogtmailform').submit(function(){
				$.ajax({	
					type: "POST",
					url: "forgotSendMail.php",
					data: {
						'user' : $('#exampleUser1').val(),
						'email' : $('#exampleEmail1').val(),
						'checkForgotMail' : 1
					},
					success: function(data){
						if(data == 2){
							window.location.href = "forgotConfirm.php";
						}
						else if(data == 0){
							document.getElementById("exampleUser1").reset();
							$("#forgotNote0").html("Invalid User Name!!");
                            $("#forgotNote0").show(); 
                            setTimeout(function() {
                                $("#forgotNote0").hide();
                            }, 5000);
						}
						else if(data == 1){
							document.getElementById("exampleEmail1").reset();
							$("#forgotNote1").html("Invalid Email ID!!");
                            $("#forgotNote1").show(); 
                            setTimeout(function() {
                                $("#forgotNote1").hide();
                            }, 5000);
						}
					}
				});
				return false;
			});			
		});
	</script>

				<div class="primaryMenu">
					<div class="wrapper">      
						<div class="masthead-menu">
							<ul id="yw1">
								<li class="selected"><a href="index.php">Home</a></li>
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
						<br><br><br>
						<div class="panel panel-primary">
							<div class="panel-heading">
						   		<h3 class="panel-title" style="text-align: center">
						   			Forgot your Password! Dont Panic. Just provide your Email to get a new password
						   		</h3>
							</div>
						</div>
						<br><br>
						<div class="well well-default">
							<div class="panel-body" >
							 	<form id="forogtmailform" role="form" method="post" action="forgotSendMail.php" >
							 		<div class="form-group">
										<label>User Name</label>
										<input type="text" class="form-control" id="exampleUser1" name="user" placeholder="User Name" required />
										<h5 id="forgotNote0" style="color: red;" hidden></h5>
									</div>
									<div class="form-group">
										<label>Email</label>
										<input type="text" class="form-control" id="exampleEmail1" name="email" placeholder="username@cs.odu.edu" required />
										<h5 id="forgotNote1" style="color: red;" hidden></h5>
									</div>
									<button id="forgotsubmit1" type="submit" class="btn btn-info">Submit</button>		
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
