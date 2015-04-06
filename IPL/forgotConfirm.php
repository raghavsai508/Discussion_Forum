<?php
session_start();

include "dbconnect.php";
include "header.php";
$_SESSION['search_team'] = 9;
?>

	<script>
		$(document).ready(function(e){
			$('#forgotEntryForm').submit(function(){
				$.ajax({	
					type: "POST",
					url: "passwordUpdate.php",
					data: {
						'code' : $('#forgotcode').val(),
						'email' : $('#forgotemail').val(),
						'pass' : $('#forgotpassword').val(),
						'conpass' : $('#forgotconpass').val(),
						'checkForgotAuth' : 1
					},
					success: function(data){
						if(data == 1){
							window.location.href = "forgotSuccess.php";
						}
						else if(data == 0){
							//document.getElementById("forgotemail").reset();
							//document.getElementById("forgotcode").reset();
							$("#forgotsuccess0").html("Please enter the correct code and email");
                            $("#forgotsuccess0").show(); 
                            setTimeout(function() {
                                $("#forgotsuccess0").hide();
                            }, 5000);
						}
						else if(data == 2){
							//document.getElementById("forgotpassword").reset();
							//document.getElementById("forgotconpass").reset();
							$("#forogtsuccess2").html("Passwords did not match!");
                            $("#forogtsuccess2").show(); 
                            setTimeout(function() {
                                $("#forogtsuccess2").hide();
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
								<li class="right"> 
										<?php
										$username = $_SESSION['username'];
										$name="select name,role,rank from proj4_members where username = '$username'";
										$name_result = $con->query($name) or die ($con->error);
										$row = $name_result->fetch_assoc();
										echo $row['name'];?>&nbsp;
										(<?php echo $row['role']; ?>)&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $row['rank']; ?>
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
									<br><br><br>
									<div class="panel panel-primary">
										<div class="panel-heading">
									   		<h3 class="panel-title" style="text-align: center">
									   			Please Enter the Code from your Email!									   			
									   		</h3>
										</div>
									</div>
									<br><br>
								 	<div class="well well-default">
			                            <div class="panel-body" > 
			                            <h5 id="forgotsuccess0" style="color: red;" hidden></h5>                                
			                                <form id="forgotEntryForm" role="form" method="post" action="passwordUpdate.php" >
										 		<div class="form-group">
													<label>Email </label>
													<input type="text" class="form-control" id="forgotemail" name="forgotemail" placeholder="Email" required />
												</div>
										 		<div class="form-group">
													<label>Code </label>
													<input type="text" class="form-control" id="forgotcode" name="forgotcode" placeholder="Code" required />
												</div>												
												<div class="form-group">
													<label>Password </label>
													<input type="password" class="form-control" id="forgotpassword" name="forgotpassword" placeholder="Password" required />
													<h5 id="forogtsuccess2" style="color: red;" hidden></h5>			
												</div>
												<div class="form-group">
													<label>Confirm Password </label>
													<input type="password" class="form-control" id="forgotconpass" name="forgotconpass" placeholder="Confirm Password" required />
													 
												</div>
												<button id="forgotSubmit" type="submit" class="btn btn-info">Submit</button>		
											</form>
			                            </div>
			                        </div>
								</div>
							</div>
						</div>
					</div>	