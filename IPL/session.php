<?php

session_start();
setcookie(session_name(),session_id(),time()-100);

//setcookie('username',"",time() - 3600);
session_destroy();

header('Location: https://weiglevm.cs.odu.edu/~cpallapo/proj4/index.php');
?>  