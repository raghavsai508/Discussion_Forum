<!-- <html>
<head>
<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
<script>
jQuery(function(){
        $("#submit").click(function(){
        $(".error").hide();
        var hasError = false;
        var passwordVal = $("#password").val();
        var checkVal = $("#password-check").val();
        if (passwordVal == '') {
            $("#password").after('<span class="error">Please enter a password.</span>');
            hasError = true;
        } else if (checkVal == '') {
            $("#password-check").after('<span class="error">Please re-enter your password.</span>');
            hasError = true;
        } else if (passwordVal != checkVal ) {
            $("#password-check").after('<span class="error">Passwords do not match.</span>');
            hasError = true;
        }
        if(hasError == true) {return false;}
    });
});
</script>
</head>
<body>
<form method="post" name="form1" id="form-password" action="registration_validation.php">
	<label>Enter Name:</label>
	<input type="text" name="name" id="name" value="" size="32" /><br>
	<label>Enter CSUserName:</label>
	<input type="text" name="cs_user_name" id="cs_user_name" value="" size="32" /><br>
	<label>Enter Email:<label>
	<input type="text" name="email" id="email" value="" size="32" /><br>
    <label>Password:</label>
    <input type="password" name="password" id="password" value="" size="32" /><br>
    <label>Re-Enter Password:</label>
    <input type="password" name="password-check" id="password-check" value="" size="32" /><br>
	<input type="radio" name="option" value="html"/>text/html
	<input type="radio" name="option" value="plain"/>text/plain
    <input type="submit" value="Submit" id="submit">
  
</form>
</body>
</html>
 -->


<?php
 function generateRandomString($length) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

echo generateRandomString(5);
?>