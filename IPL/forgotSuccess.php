<?php
	session_start();

	$_SESSION['search_team'] = 9;
	include "dbconnect.php";	
	include "header1.php";

	if($_SESSION['signuser'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else{ ?>

		<script>
	 		$(document).ready(function(e){
				$('#loginform').submit(function(){				

	                $.ajax({						
	                    type: "POST",
	                    url: "checkLogin.php",
	                    data: {
	                        'user': $('#inputUser').val(),
	                        'pass': $('#inputPass').val(),
	                        'remember' : $('#inputCheck').val(),
	                        'checkLoginAuth' : 1
	                    },
	                    success: function (data){
	                        if(data == 1){
	                            window.location.href = "index.php";							
	    					}
	    					else if(data == 0){
	    						document.getElementById("loginform").reset();
	    						$("#errorNote").html(" Information provided did not match our records, please retry!");
	    						$("#errorNote").show();							
	    						setTimeout(function() {
	                                $("#errorNote").hide();
	                            }, 3000);
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
											<li ><a href="index.php">Home</a></li>
											
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
									<div class="well well-default">
										<div class="panel-body" style="text-align: center">
										 	Your Password has been updated. Please click below to Sign IN!!<br><br>
											<a id="modal-123444" href="#modal-container-309289" data-toggle="modal">
												<button type="submit" class="btn btn-info">
													Ok!!
												</button>
											</a>			 	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			<?php }?>
		</body>
		</html>

	 										 		
 