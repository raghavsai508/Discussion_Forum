<?php
session_start();
include "dbconnect.php";	
include "header.php";

$_SESSION['search_team'] = 9;
?>


 	<script>
 		$(document).ready(function(e){

			
		   /* $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
		        console.log(numFiles);
		        console.log(label);
		    });
		    $(document)
			    .on('change', '.btn-file :file', function() {
			        var input = $(this),
			            numFiles = input.get(0).files ? input.get(0).files.length : 1,
			            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
			        input.trigger('fileselect', [numFiles, label]);
			});
*/



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
    						$("#signinNote").html(" Information provided did not match our records, please retry!");
    						$("#signinNote").show();							
    						setTimeout(function() {
                                $("#signinNote").hide();
                            }, 3000);
    					}
    					else if(data == 2){
    						document.getElementById("loginform").reset();
    						$("#signinNote").html(" Account is Not Activated. Please Activate it!!");
    						$("#signinNote").show();							
    						setTimeout(function() {
                                $("#signinNote").hide();
                            }, 3000);
    					}

				    }
			    });
                return false;
			});

            $('form#registrationform').submit(function(){

            	var formData=new FormData($(this)[0]);
                $.ajax({
                   
                    type: "POST",
                    url: "checkRegister.php",
					async:false,
					cache:false,
					contentType:false,
					processData:false,
					data:formData,
                    success: function (data){                       
                        if(data == 3){
                            //alert($('input:radio[name=option]:checked').val());
                            window.location.href = "success.php";
                            // alert(data)  ;
                        }
                        else if(data == 0){
                            //document.getElementById("regUsername").reset();
                            $("#registerNote1").html("User Name already taken. Select another one!");
                            $("#registerNote1").show(); 
                            setTimeout(function() {
                                $("#registerNote1").hide();
                            }, 3000);
                        }
                        else if(data == 1){
                          	//document.getElementById("regEmail").reset();
                            $("#registerNote2").html("Email ID should be @cs.odu.edu Domain!");
                            $("#registerNote2").show(); 
                            setTimeout(function() {
                                $("#registerNote2").hide();
                            }, 3000);
                        }  
                        else if(data == 4){
                         	//document.getElementById("regEmail").reset();
                            $("#registerNote2").html("Email ID already registered!");
                            $("#registerNote2").show(); 
                            setTimeout(function() {
                                $("#registerNote2").hide();
                            }, 3000);
                        }   
                        else if(data == 2){
                          	//document.getElementById("regPassword").reset();
                          	//document.getElementById("regConpass").reset();
                            $("#registerNote3").html("Passwords did not match!");
                            $("#registerNote3").show(); 
                            setTimeout(function() {
                                $("#registerNote3").hide();
                            }, 3000);
                        } 
                        else if(data == 5){                              	
                            $("#registerNote5").html("Please Enter the Correct Captcha!");
                            $("#registerNote5").show(); 
                            setTimeout(function() {
                                $("#registerNote5").hide();
                            }, 3000);
                        } 
                        else if(data == 6){
                            $("#registerNote6").html("Please Reload the form!");
                            $("#registerNote6").show(); 
                            setTimeout(function() {
                                $("#registerNote6").hide();
                            }, 3000);
                        }  
                        else if(data == 7){
                            $("#registerNote7").html("Please Upload file of type jpg/jpeg/png/gif!");
                            $("#registerNote7").show(); 
                            setTimeout(function() {
                                $("#registerNote7").hide();
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
								<?php if($_SESSION['signuser'] == 0){ ?>
									<li ><a href="index.php">Home</a></li>
								<?php }else if($_SESSION['signuser'] == 1){ ?>
									<li class="selected"><a href="index.php">Home</a></li>
								<?php } ?>								
								<?php if ($_SESSION['admin_auth'] == 1){ ?>
									<li><a href="admin.php">Admin</a></li>									
								<?php }else if($_SESSION['mod_auth'] == 1){ ?>
									<li><a href="admin.php">Moderator</a></li>	
								<?php } ?>
								<?php if ($_SESSION['signuser'] == 1){ ?>
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
								<?php } ?>
							</ul>            
						</div>
					</div>                              
				</div><!-- END top-masthead -->
			</div><!-- END mastheadContent -->
		</div>
		 
		<div class="wrapper">
			<div class="main-content ">
				<div class="hero">
					<div class="heroContent">		<br><br><br>
						<div class="panel panel-primary">
						  	<div class="panel-heading">
						    	<h3 class="panel-title">Top Discussions</h3>
							</div>
						  	<div class="panel-body">
								<table class="table">
									<thead>
										<tr>
											<th>Team</th>
											<th>Recent Discussion</th>
											<th>Posted By</th>
											<th>Comments</th>
										</tr>
									</thead>
									<tbody>
										 <?php if ($_SESSION['signuser'] == 0){												
												$rr = "select post_id,member_name,username,rank,post_title,time_created,role,t_team_id from proj4_posts,proj4_members where t_team_id = 1 and name = member_name and deleted = 0 order by time_created desc";
												$rr_result = $con->query($rr) or die ($con->error);
												$row = $rr_result->fetch_assoc();
												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0){
													$replies_num=$replies_count['replies'];
												}
												else{
													$replies_num=0;
												}											
											?>
											<tr>
												<td>
													<div class ="teamSub">
												    	
															<li class="RR">
																<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																	<span>Rajasthan Royals</span></a>
															</li>  
														
													</div>	
												</td>
												<td>
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php echo $row['post_title']; ?>
													</a>										
												</td>
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td>
													Comments: <?php echo $replies_num; ?>
												</td> 
											</tr>
											<?php
												$dd = "select post_id,member_name,post_title,rank,time_created,role,t_team_id from proj4_posts,proj4_members where t_team_id = 2 and name = member_name and deleted = 0 order by time_created desc";
												$dd = $con->query($dd) or die ($con->error);
												$row = $dd->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0){
													$replies_num=$replies_count['replies'];
												}
												else{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>
													<div class ="teamSub">
												    	
															<li class="DD">
																<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																	<span>Delhi Daredevils</span></a>
															</li>  
														
													</div>	
												</td>
												<td>
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php
															echo $row['post_title'];
														?>
													</a>										
												</td>
												<td ><?php echo $row['member_name']." (".$row['role'].")" ;?><br><?php echo $row['rank']; ?></td>   
												<td>
													Comments: <?php echo $replies_num;?>
												</td> 
											</tr>
											<?php
												$kxip = "select post_id,member_name,post_title,rank,time_created,role,t_team_id from proj4_posts,proj4_members where t_team_id = 3 and name = member_name and deleted = 0 order by time_created desc";
												$kxip = $con->query($kxip) or die ($con->error);
												$row = $kxip->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="KXIP   ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Kings XI Punjab</span></a>
															</li> 
														</div>															
													</td>        
													<td class="team">
														<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
															<?php 
															echo $row['post_title']; 
															?>
														</a>
													</td>      
													<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
													<td class="last ">
														Comments: <?php echo $replies_num;?>
													</td> 
											</tr>

											<?php
											$kkr = "select post_id,member_name,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 4 and name = member_name and deleted = 0 order by time_created desc";
											$kkr = $con->query($kkr) or die ($con->error);
											$row = $kkr->fetch_assoc();

											$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="KKR   ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Kolkata Knight Riders</span></a>
														</li> 			   
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>      
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td> 
											</tr>

											<?php
												$mi = "select post_id,member_name,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 5 and name = member_name and deleted = 0 order by time_created desc";
												$mi = $con->query($mi) or die ($con->error);
												$row = $mi->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="MI   ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Mumbai Indians</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$rcb = "select post_id,member_name,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 6 and name = member_name and deleted = 0 order by time_created desc";
												$rcb = $con->query($rcb) or die ($con->error);
												$row = $rcb->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
												?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="RCB   ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Royal Challengers Bangalore</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>      
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$sh = "select post_id,member_name,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 7 and name = member_name and deleted = 0 order by time_created desc";
												$sh = $con->query($sh) or die ($con->error);
												$row = $sh->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="SH   ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Sunrisers Hyderabad</span></a>
														</li> 
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  
											</tr>
											<?php
												$csk = "select post_id,member_name,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 8 and name = member_name and deleted = 0 order by time_created desc";
												$csk = $con->query($csk) or die ($con->error);
												$row = $csk->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr>
												<td>     
													<div class ="teamSub">
														<li class="CSK  ">
															<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
																<span>Chennai Super Kings</span></a>
														</li>   
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="#modal-container-309289" data-toggle="modal">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td ><?php echo $row['member_name'];?> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?></td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  			
											</tr>

										 <?php 
										}
										else{
											$rr = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 1 and name = member_name and deleted = 0 order by time_created desc";
											$rr_result = $con->query($rr) or die ($con->error);
											$row = $rr_result->fetch_assoc();

											$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
										?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="RR">
															<a href="viewTeam.php?team_id=1">
																<span>Rajasthan Royals</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">																
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=1">
														<?php
															echo $row['post_title'];
														?>
													</a>
												</td> 
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  															
											</tr> 
											<?php
												$dd = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 2 and name = member_name and deleted = 0 order by time_created desc";
												$dd = $con->query($dd) or die ($con->error);
												$row = $dd->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="DD">
															<a href="viewTeam.php?team_id=2">
																<span>Delhi Daredevils</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=2">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>    
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$kxip = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 3 and name = member_name and deleted = 0 order by time_created desc";
												$kxip = $con->query($kxip) or die ($con->error);
												$row = $kxip->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="KXIP   ">
															<a href="viewTeam.php?team_id=3">
																<span>Kings XI Punjab</span></a>
														</li> 
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=3">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>      
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>    
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$kkr = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 4 and name = member_name and deleted = 0 order by time_created desc";
												$kkr = $con->query($kkr) or die ($con->error);
												$row = $kkr->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="KKR   ">
															<a href="viewTeam.php?team_id=4">
																<span>Kolkata Knight Riders</span></a>
														</li> 			   
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=4">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>      
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>    
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	  														
											</tr>
											<?php
												$mi = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 5 and name = member_name and deleted = 0 order by time_created desc";
												$mi = $con->query($mi) or die ($con->error);
												$row = $mi->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="MI   ">
															<a href="viewTeam.php?team_id=5">
																<span>Mumbai Indians</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=5">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>    
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											<tr>
											<?php
												$rcb = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 6 and name = member_name and deleted = 0 order by time_created desc";
												$rcb = $con->query($rcb) or die ($con->error);
												$row = $rcb->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="RCB   ">
															<a href="viewTeam.php?team_id=6">
																<span>Royal Challengers Bangalore</span></a>
														</li>  
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=6">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>      
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>   
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$sh = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 7 and name = member_name and deleted = 0 order by time_created desc";
												$sh = $con->query($sh) or die ($con->error);
												$row = $sh->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="SH   ">
															<a href="viewTeam.php?team_id=7">
																<span>Sunrisers Hyderabad</span></a>
														</li> 
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=7">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>     
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  	
											</tr>
											<?php
												$csk = "select post_id,post_id,member_name,username,post_title,time_created,rank,role,t_team_id from proj4_posts,proj4_members where t_team_id = 8 and name = member_name and deleted = 0 order by time_created desc";
												$csk = $con->query($csk) or die ($con->error);
												$row = $csk->fetch_assoc();

												$post_id = $row['post_id'];
												$team_id = $row['t_team_id'];

												$replies="select count(post_id) as replies from proj4_posts,proj4_reply where t_team_id=team_id and post_id=p_post_id and team_id='$team_id' and post_id='$post_id' group by team_id,post_id order by time_created desc";
												$replies_result=$con->query($replies);
												$replies_count=$replies_result->fetch_assoc();
												if(($replies_result->num_rows)>0)
												{
													$replies_num=$replies_count['replies'];
												}
												else
												{
													$replies_num=0;
												}		
											?>
											<tr> 												
												<td>     
													<div class ="teamSub">
														<li class="CSK  ">
															<a href="viewTeam.php?team_id=8">
																<span>Chennai Super Kings</span></a>
														</li>   
													</div>															
												</td>        
												<td class="team">
													<a id="modal-123" href="viewThread.php?post_id=<?php echo $row['post_id'];?>&team_id=8">
														<?php 
															echo $row['post_title']; 
														?>
													</a>
												</td>    
												<td>	
													<?php if($_SESSION['username'] == $row['username']){ ?>
														<a href="profile.php"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php }else if($_SESSION['username'] != $row['username']){ ?>
														<a href="userProfile.php?seeUser=<?php echo $row['username']; ?>"><?php echo $row['member_name'];?></a> (<?php echo $row['role'];?>)<br><?php echo $row['rank']; ?>
													<?php } ?>
												</td>     
												<td class="last ">
													Comments: <?php echo $replies_num;?>
												</td>  														
											</tr>	
											<?php
											}
											?>
									</tbody>
								</table>
							</div>
						</div>
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