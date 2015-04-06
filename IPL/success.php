<?php
	session_start();
	include "dbconnect.php";	
	include "header.php"; 

	$_SESSION['search_team'] = 9;

   if($_SESSION['signuser'] != 0){
       header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
    }
    else if($_SESSION['success'] == 1){ ?>
 
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
										 	Please check your Email for further instructions<br><br>
											<a href="index.php">
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

				<?php $_SESSION['success'] = 0; ?>
    <?php }else if($_SESSION['changePassword'] == 1){ ?>
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
										 	Password Changed Successfully!!<br><br>
											<a href="profile.php">
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

				<?php $_SESSION['changePassword'] = 0; ?>

    <?php }else{

           header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
        }?>
