<?php
session_start();

	if ($_SESSION['signuser'] == 0 ){
			header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		}
		else if($_SESSION['signuser'] == 1 ){ 
			$team_id = $_GET['team_id'];
			$pres_user = $_SESSION['username'];
			include "dbconnect.php";	
			include "header1.php";

			$_SESSION['search_team'] = $team_id;

?>
		<script>		
			$( document ).ready(function() {		
				
				/*$("#discussionsubmit1").click(function(){			
					if ( (($("#discussionname").val()).length != 0) && (($("#discussioncomment").val()).length != 0)) {
						$("#discussionsubmission").submit();
					}
					else if((($("#discussionname").val()).length == 0) || (($("#discussioncomment").val()).length == 0)){
						$("#modal-container-new").show();
					}
				});	*/

				$('#discussionsubmission').submit(function(){
					var formData=new FormData($(this)[0]);
					/*var post = $("#comment1").val();
					alert(post);*/
		 			$.ajax({								
						type: "POST",
						url: "commentSubmit.php",
						/*data:{
							'newDiscTitle' : $("#discussionname").val(),
							'newDiscComment' : $("#discussioncomment").val(),
							'team_id' : $("#team_id").val(),
							'commentAuth' : 1,
							'threadCommentAuth' : 2
							},*/
						async:false,
						cache:false,
						contentType:false,
						processData:false,
						data:formData,
						success:function(data){
							if(data==2){									
								window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/viewTeam.php?team_id=<?php echo $team_id;?>' ;
							}
							else if(data==0){
								//$("#modal-container-deleted").show();
								alert('You have been deleted from the Forum. You cannot Post anymore!!');
								window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/session.php';

							}
							else if(data==1){
								//$("#modal-container-new").show();
								alert('Please enter both Title and Comment to post');
								//window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php';
								//document.getElementById("modal-container-new").show();
							}
							else if(data==3){
								alert('Too Many Images!!');
								window.location.href='https://weiglevm.cs.odu.edu/~cpallapo/proj4/newDiscussion.php?team_id=<?php echo $team_id; ?>';
								//window.reload();
							}
							else if(data==6){
								alert('Image format did not match. Please upload either jpg/jpeg/png/gif !!');
							}
						}
				    }); return false;
				});			
			});	
		</script>
																														
				<div class="primaryMenu">
					<div class="wrapper">      
						<div class="masthead-menu">
							<ul id="yw1">
								<li><a href="index.php">Home</a></li>
								<li class="selected"><a>New Discussion</a></li>
								<?php if ($_SESSION['admin_auth'] == 1){ ?>
									<li><a href="admin.php">Admin</a></li>
								<?php }	?>
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
							</ul>            
						</div>
					</div>                              
				</div><!-- END top-masthead -->
			</div><!-- END mastheadContent -->
		</div>

		<?php 

			$suspend_check = "select suspension from proj4_members where username = '$pres_user' ";
			$suspend_res = $con->query($suspend_check);
			$suspend_value = $suspend_res->fetch_assoc();

			//$image_limit = ";
			$image_limit_res = $con->query("select image_limit,username from proj4_images_limit p4il,proj4_members p4m where p4m.rank = p4il.user_rank and p4m.username = '$pres_user'");
			$image_limit_val = $image_limit_res->fetch_assoc();

			$image_max_limit = $image_limit_val['image_limit'];
			
		
		?>
		<div class="wrapper">
			<div class="main-content ">
				<div class="hero">
					<div class="heroContent">						
							<div class="D_boxbody">
								<div class="D_boxhead">
									<h3 style="margin-top:50px;margin-left:40px;">New Discussion</h3>
								</div>
								<br><br>
								<form style="margin-left:20px;" role="form" id="discussionsubmission" method="POST" action="">									
									<label for="title" class="col-lg-2 control-label">Title</label>
									<textarea  class = "form-control" rows="1" name="discussionname" id="discussionname" placeholder="Title" style="resize:none"></textarea><br>
									
									<label for="textArea" class="col-lg-2 control-label">Textarea</label>
									<textarea  class = "form-control" rows="5" name="discussioncomment" id="discussioncomment" placeholder="Comment...." style="resize:none"></textarea><br>
									<input type="hidden" name="newdisc" value="1">
									<input type="hidden" name="commentAuth" value="1">
									<input type="hidden" name="threadCommentAuth" value="2">
									<input type="hidden" name="team_id" id="team_id" value="<?php echo $team_id; ?>">
									<div style="margin-left:21px;">
										<input type="file" name="discussion_image[]" id="discussion_image" accept="image/jpeg,image/png,image/jpg,image/gif" multiple>
										<h5 style="color:red;">You can Upload Only <?php echo $image_max_limit; ?> Images for your Rank</h5><br>
									</div>								

									<!--<input type="hidden" name="team_id" value="<?php /*echo */$team_id;?>">-->
									<?php if($suspend_value['suspension'] == 0){ ?>
										<!-- <a id="modal-309291" href="#modal-container-new" role="button"  data-toggle="modal"> -->
											<button id="discussionsubmit1" class="btn btn-info" type="submit" value="submit" style="margin-left: 20px;">Submit</button>
										<!-- </a> -->
									<?php } else if($suspend_value['suspension'] == 1){ ?>
										<a id="modal-3" href="#modal-container-3" role="button"  data-toggle="modal">
											<button id="discussionsubmit" class="btn btn-info" type="submit" value="submit" style="margin-left: 20px;">Submit</button>
										</a>
									<?php } ?>	
								</form>
							</div>						
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modal-container-new" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
							<h4 class="modal-title" id="myModalLabel">
								Please Enter Both Title and Comment to Post
							</h4>
					</div>
					<div id="modal-309292"class="modal-body">						
						<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/newDiscussion.php?team_id=<?php echo $team_id;?>" data-toggle="modal" >
							<button class="btn btn-info"> Ok!!</button>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modal-container-deleted" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
							<h4 class="modal-title" id="myModalLabel">
								You have been deleted from the Forum.
							</h4>
					</div>
					<div id="modal-30"class="modal-body">
						<a id="modal-309293" href="session.php" data-toggle="modal" >
							<button id="suspendclose" class="btn btn-info"> Ok!!</button>
						</a>
					</div>
				</div>
			</div>
		</div>

			<div class="modal fade" id="modal-container-3" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button> -->
								<h4 class="modal-title" id="myModalLabel">
									You have been suspended from the Forum.
								</h4>
						</div>
						<div id="modal-30"class="modal-body">
							You cannot post untill your suspension is lifted.<br><br>	
							<a id="modal-309293" href="http://weiglevm.cs.odu.edu/~cpallapo/proj4/newDiscussion.php?team_id=<?php echo $team_id;?>" data-toggle="modal" >
								<button id="suspendclose" class="btn btn-info"> Ok!!</button>
							</a>
						</div>
					</div>
				</div>
			</div>
	</body>
</html>
<?php
}
?>