<?php

	$con=mysqli_connect("localhost","testIPL","ipl2014","ipl2014");

		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	/*
		error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 'on');*/
?>
