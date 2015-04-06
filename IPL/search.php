<?php
	
	session_start();

	if($_SESSION['signuser'] == 0){
		header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
	}
	else if($_SESSION['signuser'] == 1){

		include 'dbconnect.php';
		include 'header.php';

		function test_input($data){
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		
		$searchString = $_POST['q'];
		$searchString = test_input($searchString);
		$searchString = $con->real_escape_string($searchString); ?>
	
				<div class="primaryMenu">
					<div class="wrapper">      
						<div class="masthead-menu">
							<ul id="yw1">
									<li ><a href="index.php">Home</a></li>
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

		<?php if(strlen($searchString) == 0){ ?>

			<div class="wrapper">
				<div class="main-content ">
					<div class="hero">
						<div class="heroContent">
							<br><br><br><br>
							<div class="well well-default">
								<div class="panel-body" >
								<?php $method = $_SERVER['REQUEST_METHOD']; ?>
								<?php if($method == 'POST') { ?>
									<h5 id="warning" style="color: red;">Please enter something to search!!</h5>							
								<?php }else if($method != 'POST'){ ?>
									
								<?php } ?>

									<form id="searchFrom1" role="form" method="post" action="search.php">
										<input type="text" class="form-control" id="inputPass1" name="q" placeholder = "Search" /><br>

										<!-- <input type="hidden" class="form-control" id="inputPass2" name="qcheck" placeholder = "Search" /><br> -->
										<input class="span2" id="team" name="team" type="hidden">


										Search In &nbsp;&nbsp;&nbsp;										
										
										<!-- <select name="id" id="id" onchange="this.form.submit()">
											<option > Select Forum</option>	
											<option value="9">Complete Forum</option>												
									        <option value="1">Rajasthan Royals</option>
									        <option value="2">Delhi Daredevils</option>
									        <option value="3">Kings XI Punjab</option>
									        <option value="4">Kolkata Knight Riders</option>
									        <option value="5">Mumbai Indians</option>	
									        <option value="6">Royal Challengers Bangalore</option>	
									        <option value="7">Sunrisers Hyderabad</option>	
									        <option value="8">Chennai Super Kings</option>	
									    </select> 		 -->							  

										<div class="btn-group">
										  	<button type="submit" class="btn btn-info dropdown-toggle btn-sm " data-toggle="dropdown" >
										   		</span>Select Forum <span class="caret"></span>
										  	</button>
										  	<ul class="dropdown-menu" role="menu" >
										  		<li onclick="$('#team').val('9'); $('#searchFrom1').submit()"><a>Complete Forum</a></li>
										  		<!-- <li ><a href="search.php?team=9">Complete Forum</a></li> -->
										  	 	<li class="divider"></li>
										  	 	<li onclick="$('#team').val('1'); $('#searchFrom1').submit()"><a>Rajasthan Royals</a></li>
										  	 	<li onclick="$('#team').val('2'); $('#searchFrom1').submit()"><a>Delhi Daredevils</a></li>
										  	 	<li onclick="$('#team').val('3'); $('#searchFrom1').submit()"><a>Kings XI Punjab</a></li>
										  	 	<li onclick="$('#team').val('4'); $('#searchFrom1').submit()"><a>Kolkata Knight Riders</a></li>
										  	 	<li onclick="$('#team').val('5'); $('#searchFrom1').submit()"><a>Mumbai Indians</a></li>
										  	 	<li onclick="$('#team').val('6'); $('#searchFrom1').submit()"><a>Royal Challengers Bangalore</a></li>
										  	 	<li onclick="$('#team').val('7'); $('#searchFrom1').submit()"><a>Sunrisers Hyderabad</a></li>
										  	 	<li onclick="$('#team').val('8'); $('#searchFrom1').submit()"><a>Chennai Super Kings</a></li>
										  	</ul>
										</div>
									</form>							
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php }else if(strlen($searchString) > 0){ ?>

			<?php
			//$id = $_POST['team']; 
				
				if(isset($_POST['team'])){
					$id = $_POST['team'];
					if($id > 9){
						$id = 9;
					}
				}
				else if(!isset($_POST['team'])){
					$id = $_SESSION['search_team'];
				}		
/*
		echo $id;
		echo '<br>';
		echo $searchString;
		echo '<br>';
		echo $id;*/

				if($id == 9){
					$delete_copy = "delete from proj4_posts_copy";
					$delete_copy_res = $con->query($delete_copy);

					$posts_copy = "INSERT INTO  proj4_posts_copy SELECT post_id, member_name,username,role,rank, post_title, message, time_created, t_team_id, team_name,freeze, deleted, time_edited, edited_by FROM proj4_posts p4p,proj4_members p4m,proj4_teams p4t where p4m.name = p4p.member_name and p4p.t_team_id = p4t.team_id";
					$posts_copy_res = $con->query($posts_copy);

					$search = "select *, MATCH(post_title,message) AGAINST('+$searchString' IN BOOLEAN MODE) as mostSearched from proj4_posts_copy where MATCH(post_title,message) AGAINST('+$searchString' IN BOOLEAN MODE) order by t_team_id,time_created,mostSearched desc";
					$search_res = $con->query($search);

					$search_rows = mysqli_num_rows($search_res);

					if($search_rows == 0){
						$search = "select * from proj4_posts_copy where CONCAT( post_title,' ', message ) LIKE  '%$searchString%' order by t_team_id,time_created desc";
						$search_res = $con->query($search);
						$search_rows = mysqli_num_rows($search_res);	
					}

					

					$delete_rep_copy = "delete from proj4_reply_copy";
					$delete_rep_res = $con->query($delete_rep_copy); 

					$reply_copy = "INSERT INTO  proj4_reply_copy SELECT reply_id,p4r.team_id,team_name,p_post_id,post_title,p4m.name,username,p4r.message,time,rank,role FROM proj4_reply p4r,proj4_members p4m,proj4_teams p4t, proj4_posts p4p where p4m.name = p4r.member_name and p4r.team_id = p4t.team_id and p4p.post_id =  p4r.p_post_id";
					$reply_copy_res = $con->query($reply_copy);

					$search_rep = "select *, MATCH(rep_message) AGAINST('+$searchString' IN BOOLEAN MODE) as mostSearched from proj4_reply_copy where MATCH(rep_message) AGAINST('+$searchString' IN BOOLEAN MODE) order by rep_team_id,rep_time,mostSearched desc";
					$search_rep_res = $con->query($search_rep);

					$search_rep_rows = mysqli_num_rows($search_rep_res);

					if($search_rep_rows == 0){
						$search_rep = "select * from proj4_reply_copy where rep_message like '%$searchString%' order by rep_team_id desc";
						$search_rep_res = $con->query($search_rep);	
						$search_rep_rows = mysqli_num_rows($search_rep_res);
					}

					$_SESSION['search_team'] = 9;
				}
				else if($id != 9){
					$delete_copy = "delete from proj4_posts_copy";
					$delete_copy_res = $con->query($delete_copy);

					$posts_copy = "INSERT INTO  proj4_posts_copy SELECT post_id, member_name,username,role,rank, post_title, message, time_created, t_team_id, team_name,freeze, deleted, time_edited, edited_by FROM proj4_posts p4p,proj4_members p4m,proj4_teams p4t where p4m.name = p4p.member_name and p4p.t_team_id = p4t.team_id";
					$posts_copy_res = $con->query($posts_copy);

					$search = "select *,MATCH(post_title,message) AGAINST('+$searchString' IN BOOLEAN MODE) as mostSearched from proj4_posts_copy where t_team_id = '$id' and MATCH(post_title,message) AGAINST('+$searchString' IN BOOLEAN MODE) order by t_team_id,time_created,mostSearched desc";
					$search_res = $con->query($search);

					$search_rows = mysqli_num_rows($search_res);

					if($search_rows == 0){
							$search = "select * from proj4_posts_copy where t_team_id = '$id' and CONCAT( post_title,' ', message ) LIKE  '%$searchString%' order by t_team_id,time_created desc";
						$search_res = $con->query($search);	
						$search_rows = mysqli_num_rows($search_res);	
					}

				

					$delete_rep_copy = "delete from proj4_reply_copy";
					$delete_rep_res = $con->query($delete_rep_copy); 
					$reply_copy = "INSERT INTO  proj4_reply_copy SELECT reply_id,p4r.team_id,team_name,p_post_id,post_title,p4m.name,username,p4r.message,time,rank,role FROM proj4_reply p4r,proj4_members p4m,proj4_teams p4t, proj4_posts p4p where p4m.name = p4r.member_name and p4r.team_id = p4t.team_id and p4p.post_id =  p4r.p_post_id";
					$reply_copy_res = $con->query($reply_copy);

					$search_rep = "select *, MATCH(rep_message) AGAINST('+$searchString' IN BOOLEAN MODE) as mostSearched from proj4_reply_copy where rep_team_id = '$id' and MATCH(rep_message) AGAINST('+$searchString' IN BOOLEAN MODE) order by rep_team_id,rep_time,mostSearched desc";
					$search_rep_res = $con->query($search_rep);

					$search_rep_rows = mysqli_num_rows($search_rep_res);

					if($search_rep_rows == 0){
						$search_rep = "select * from proj4_reply_copy where rep_team_id = '$id' and rep_message like '%$searchString%' order by rep_team_id desc";
						$search_rep_res = $con->query($search_rep);	
						$search_rep_rows = mysqli_num_rows($search_rep_res);
					}


					$search_team = "select team_name from proj4_teams where team_id = '$id'";
					$search_team_res = $con->query($search_team);

					$search_team_val = $search_team_res->fetch_assoc();

					$_SESSION['search_team'] = 9;

				}								//echo $search_rep_rows;



				if($search_rows == 0 && $search_rep_rows == 0){ ?>
					<div class="wrapper">
						<div class="main-content ">
							<div class="hero">
								<div class="heroContent">
									<br><br><br>
									<div class="well well-default">
										<div class="panel-body" >
										 	No Results have been found for "<strong> <?php echo $searchString; ?></strong>" in 
										 		<?php if($id == 9){ ?>
										 			All Forums
										 		<?php }else if($id != 9){?>
										 			<?php echo $search_team_val['team_name']; ?>
										 		<?php }?><br><br>
											<form id="searchFrom1" role="form" method="post" action="search.php">
												<input type="text" class="form-control" id="inputPass1" name="q" placeholder = "Search" /><br>

												<input class="span2" id="team" name="team" type="hidden">

												Search In &nbsp;&nbsp;&nbsp;										
												
												<div class="btn-group">
												  	<button type="submit" class="btn btn-info dropdown-toggle btn-sm " data-toggle="dropdown" >
												   		</span>Select Forum <span class="caret"></span>
												  	</button>
												  	<ul class="dropdown-menu" role="menu" >
												  		<li onclick="$('#team').val('9'); $('#searchFrom1').submit()"><a>Complete Forum</a></li>
												  		<!-- <li ><a href="search.php?team=9">Complete Forum</a></li> -->
												  	 	<li class="divider"></li>
												  	 	<li onclick="$('#team').val('1'); $('#searchFrom1').submit()"><a>Rajasthan Royals</a></li>
												  	 	<li onclick="$('#team').val('2'); $('#searchFrom1').submit()"><a>Delhi Daredevils</a></li>
												  	 	<li onclick="$('#team').val('3'); $('#searchFrom1').submit()"><a>Kings XI Punjab</a></li>
												  	 	<li onclick="$('#team').val('4'); $('#searchFrom1').submit()"><a>Kolkata Knight Riders</a></li>
												  	 	<li onclick="$('#team').val('5'); $('#searchFrom1').submit()"><a>Mumbai Indians</a></li>
												  	 	<li onclick="$('#team').val('6'); $('#searchFrom1').submit()"><a>Royal Challengers Bangalore</a></li>
												  	 	<li onclick="$('#team').val('7'); $('#searchFrom1').submit()"><a>Sunrisers Hyderabad</a></li>
												  	 	<li onclick="$('#team').val('8'); $('#searchFrom1').submit()"><a>Chennai Super Kings</a></li>
												  	</ul>
												</div>
											</form>								 	
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php }else if($search_rows != 0 || $search_rep_rows != 0){ ?>
					<div class="wrapper">
						<div class="main-content ">
							<div class="hero">
								<div class="heroContent">
									<br><br>
									<div class="panel panel-danger">
										<div class="panel-heading">
									   	    <h3 class="panel-title">Top Search's for "<?php echo $searchString; ?>"</h3>
									  	</div>
									</div><br>
									<?php if($search_rows == 0){ ?>
										<div class="panel panel-danger">
											<div class="panel-heading">
										   	    <h3 class="panel-title">No Results have been found for "<strong> <?php echo $searchString; ?></strong>" in 
											 		<?php if($id == 9){ ?>
											 			All Forums In Posts
											 		<?php }else if($id != 9){?>
											 			<?php echo $search_team_val['team_name']; ?> In Posts
											 		<?php }?><br>
											 	</h3>
										  	</div>
										</div><br>
									<?php }else if($search_rows > 0){ ?>
										<div class="panel panel-primary">
											<div class="panel-heading">
										   	    <h3 class="panel-title">In Posts</h3>
										  	</div>
										  	<div class="panel-body">
												<table class="table">    
													<thead>      
														<tr >        
															<td><strong>Team<br></strong></td>        
															<td><strong>Author</strong></td>  
															<td><strong>Post Title</strong></td>
															<td><strong>Message</strong></td> 													
															<td><strong>Created on</strong></td>  
														</tr>  
													</thead> 
													<tbody> 
														<?php while($search_val = $search_res->fetch_assoc()){	/*echo $search_val['mostSearched'];*/ ?>
															<tr class="member"> 												
																<td class="first team">     
																	<a href="viewTeam.php?team_id=<?php echo $search_val['t_team_id']; ?>"><?php echo $search_val['t_name']; ?>
																	</a>													
																</td>  
																<td>	
																	<?php if($_SESSION['username'] == $search_val['username']){ ?>
																		<a href="profile.php"><?php echo $search_val['member_name'];?></a> (<?php echo $search_val['member_role'];?>)<br><?php echo $search_val['member_rank']; ?>
																	<?php }else if($_SESSION['username'] != $search_val['username']){ ?>
																		<a href="userProfile.php?seeUser=<?php echo $search_val['username']; ?>"><?php echo $search_val['member_name'];?></a> (<?php echo $search_val['member_role'];?>)<br><?php echo $search_val['member_rank']; ?>
																	<?php } ?>
																</td>        
																<td><a href="viewThread.php?post_id=<?php echo $search_val['post_id'];?>&team_id=<?php echo $search_val['t_team_id'];?>" ><?php echo $search_val['post_title']; ?>
																</td> 
																<td><?php echo $search_val['message']; ?> </td>

																<td class="last" style="width:11%;">
																	<?php 
																		$postdate = date('M d, Y', strtotime($search_val['time_created']));
																		$posttime = date('g:i a', strtotime($search_val['time_created']));
																	?>
																	<?php echo $postdate;?> <?php echo $posttime ?>
																</td>  					
															</tr>
														<?php }	?>
													</tbody> 
												</table>
											</div>									
										</div>
									<?php }?>
									<?php if($search_rep_rows == 0){ ?>
										<div class="panel panel-danger">
											<div class="panel-heading">
										   	    <h3 class="panel-title">No Results have been found for "<strong> <?php echo $searchString; ?></strong>" in 
											 		<?php if($id == 9){ ?>
											 			All Forums In Replies
											 		<?php }else if($id != 9){?>
											 			<?php echo $search_team_val['team_name']; ?> In Replies
											 		<?php }?><br>
											 	</h3>
										  	</div>
										</div><br>
									<?php }else if($search_rep_rows > 0){ ?>
										<div class="panel panel-primary">
											<div class="panel-heading">
										   	    <h3 class="panel-title">In Replies</h3>
										  	</div>
										  	<div class="panel-body">
												<table class="table">    
													<thead>      
														<tr >        
															<td><strong>Team<br></strong></td>        
															<td><strong>Author</strong></td> 	
															<td><strong>Post_title</strong></td> 													
															<td><strong>Reply</strong></td> 													
															<td><strong>Created on</strong></td>  
														</tr>  
													</thead> 
													<tbody> 
														<?php while($search_rep_val = $search_rep_res->fetch_assoc()){	/*echo $search_rep_val['mostSearched'];*/ ?>
															<tr class="member"> 												
																<td class="first team">     
																	<a href="viewTeam.php?team_id=<?php echo $search_rep_val['rep_team_id']; ?>"><?php echo $search_rep_val['rep_team_name']; ?>
																	</a>													
																</td>  
																<td>	
																	<?php if($_SESSION['username'] == $search_rep_val['rep_username']){ ?>
																		<a href="profile.php"><?php echo $search_rep_val['rep_member_name'];?></a> (<?php echo $search_rep_val['rep_role'];?>)<br><?php echo $search_rep_val['rep_rank']; ?>
																	<?php }else if($_SESSION['username'] != $search_rep_val['rep_username']){ ?>
																		<a href="userProfile.php?seeUser=<?php echo $search_rep_val['rep_username']; ?>"><?php echo $search_rep_val['rep_member_name'];?></a> (<?php echo $search_rep_val['rep_role'];?>)<br><?php echo $search_rep_val['rep_rank']; ?>
																	<?php } ?>
																</td>
																<td><a href="viewThread.php?post_id=<?php echo $search_rep_val['rep_post_id'];?>&team_id=<?php echo $search_rep_val['rep_team_id'];?>" ><?php echo $search_rep_val['rep_post_title']; ?>
																</td> 
																<td><?php echo $search_rep_val['rep_message']; ?></td> 													

																<td class="last" style="width:11%;">
																	<?php 
																		$postdate = date('M d, Y', strtotime($search_rep_val['rep_time']));
																		$posttime = date('g:i a', strtotime($search_rep_val['rep_time']));
																	?>
																	<?php echo $postdate;?> <?php echo $posttime ?>
																</td>  					
															</tr>
														<?php }	?>
													</tbody> 
												</table>
											</div>									
										</div>
									<?php } ?>
									
									<div class="well well-default">
										<div class="panel-body" >
										 <!-- 	Didn't find what you are looking. Try again!<br><br> -->
											<form id="searchFrom1" role="form" method="post" action="search.php">
												<input type="text" class="form-control" id="inputPass1" name="q" placeholder = "Search" /><br>

												<input class="span2" id="team" name="team" type="hidden">

												Search In &nbsp;&nbsp;&nbsp;										
												
												<div class="btn-group">
												  	<button type="submit" class="btn btn-info dropdown-toggle btn-sm " data-toggle="dropdown" >
												   		</span>Select Forum <span class="caret"></span>
												  	</button>
												  	<ul class="dropdown-menu" role="menu" >
												  		<li onclick="$('#team').val('9'); $('#searchFrom1').submit()"><a>Complete Forum</a></li>
												  		<!-- <li ><a href="search.php?team=9">Complete Forum</a></li> -->
												  	 	<li class="divider"></li>
												  	 	<li onclick="$('#team').val('1'); $('#searchFrom1').submit()"><a>Rajasthan Royals</a></li>
												  	 	<li onclick="$('#team').val('2'); $('#searchFrom1').submit()"><a>Delhi Daredevils</a></li>
												  	 	<li onclick="$('#team').val('3'); $('#searchFrom1').submit()"><a>Kings XI Punjab</a></li>
												  	 	<li onclick="$('#team').val('4'); $('#searchFrom1').submit()"><a>Kolkata Knight Riders</a></li>
												  	 	<li onclick="$('#team').val('5'); $('#searchFrom1').submit()"><a>Mumbai Indians</a></li>
												  	 	<li onclick="$('#team').val('6'); $('#searchFrom1').submit()"><a>Royal Challengers Bangalore</a></li>
												  	 	<li onclick="$('#team').val('7'); $('#searchFrom1').submit()"><a>Sunrisers Hyderabad</a></li>
												  	 	<li onclick="$('#team').val('8'); $('#searchFrom1').submit()"><a>Chennai Super Kings</a></li>
												  	</ul>
												</div>
											</form>								 	
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				<?php } ?>
		<?php } ?>		
	<?php } ?>
