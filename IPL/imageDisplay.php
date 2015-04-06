<?php 
	session_start();

	if($_SESSION['signuser'] == 0){
		header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		//echo 1;
	}else if($_SESSION['signuser'] == 1){ 
		
		$id = $_REQUEST['id'];

		include 'dbconnect.php';
		$username = $_SESSION['username'];
		//echo $username;
		$image_display_query="select image,image_type,image_id from proj4_avatar_images where image_id = '$id' ";
		$image_display_exec=$con->query($image_display_query)or die($con->error);
		$image_result=$image_display_exec->fetch_assoc();
		$uri = 'data:'.$image_result['image_type'].';base64,'.base64_encode($image_result['image']);

		if(!$image_result){
			header('Location:https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
		}
		else{ ?>
			<img align="center" src="<?php echo $uri;?>" />
		<?php }		
 	} 
?>