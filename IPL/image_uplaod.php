<?php
// setup revision of check_image to call
$rev = "01";
if (isset($_GET["rev"])) {
   $rev = $_GET["rev"];
}
?>

<html>
<head>
<title>Upload your pic to our site!</title>
</head>
<body>

<form name="form1" method="post" action="check_image-rev<?php echo $rev;?>.php" 
    enctype="multipart/form-data">

<table border="0" cellpadding="5">
  <tr>
    <td>Image Title or Caption<br>
      <em>Example: You talkin' to me?</em></td>
    <td><input name="image_caption" type="text" id="item_caption" size="55" 
          maxlength="255"></td>
  </tr>
  <tr>
    <td>Your Username</td>
    <td><input name="image_username" type="text" id="image_username" size="15" 
          maxlength="255"></td>
  </tr>
    <td>Upload Image:</td>
    <td><input name="image_filename" type="file" id="image_filename"></td>
  </tr>
</table>
<br>
<em>Acceptable image formats include: GIF, JPG/JPEG, and PNG.</em>
<p align="center"><input type="submit" name="Submit" value="Submit">
  &nbsp;
  <input type="reset" name="Submit2" value="Clear Form">
</p>
</form>
</body>
</html>

