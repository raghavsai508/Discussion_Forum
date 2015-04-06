<script>	
	
					
			$( document ).ready(function() {		
				
				$("#signupcheck").click(function(){	
						//alert("Comparision is" + n);
						var pass = $("#password").val();
						var conpass = $("#confirmpassword").val();
						var n = pass.localeCompare(conpass);	
						//alert("Comparision is" + n);	
					if (n == 0 ) {
						$("#registration").submit();
					}
					else if(n != 0){
						$("#modal-container-309290").show();
					}
				});			
			});	
	

		</script>



		$( document ).ready(function() {		
				
				$("#signupcheck").click(function(){	
						alert("Comparision is" + $("#password"));
						var pass = $("#password").val();
						var conpass = $("#confirmpassword").val();
						var n = pass.localeCompare(conpass);	
						//alert("Comparision is" + n);	
					if (n == 0 ) {
						$("#registration").submit();
					}
					else if(n != 0){
						$("#modal-container-309290").show();
					}
				});			
			});	



				function test_input($data){
			    $data = trim($data);
			    $data = stripslashes($data);
			    $data = htmlspecialchars($data);
			    return $data;
			}           

	        $("#logincheck").on('click'(function){
	        	 
	  
			   	var login_name =  $('#exampleInputEmail1').val();
		       	login_name = test_input(login_name);
		       	alert(login_name);
		       	var login_password =  $('#exampleInputPassword1').val();
		       	login_password = test_input(login_password);
			  
			    //use ajax to run the check  
			    $.post("checklogin.php", { user: login_name,password: login_password},  
			    function(result){  
			        if(result == 1){  
		                $('#login_fail').html('Login Pass');  
		            }else{  
		               //show that the username is NOT available  
		                document.getElementById("login").reset();
		                $('#login_fail').html('Login Fail');  
		             }  
		        	});   
	            });     
	

	function checkPassword(theForm) {
					if (theForm.password.value != theForm.confirmpassword.value){	        		
				   		document.getElementById("registration").reset();
				   		return false;	        		
				   	} 
				   	else{
						return true;
				   	}	
				}


				$("#username").keyup(function (e) {
				
					//removes spaces from username
					$(this).val($(this).val().replace(/\s/g, ''));
							
					var username = $(this).val();
					if(username.length < 4){$("#user-result").html('');return;}
							
					if(username.length >= 4){
						$("#user-result").html('<img src="./assets/img/ajax-loader.gif" />');
						$.post('check_username.php', {'username':username}, function(data) {
						  $("#user-result").html(data);
						});
					}
				});

				<form id="registration" role="form" method="post" action="signup.php" onsubmit="return checkPassword(this);">