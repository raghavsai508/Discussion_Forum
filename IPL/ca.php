<?php ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
 
		<title>Simple PHP captcha demo</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
 
	<body>
		<div>
			<header>
				<h1>Simple PHP captcha demo</h1>
			</header>
			
			<div>
				<img src="captcha.php" id="captcha" /> 
				<form action="captcha-validate.php" method="post">
					<input type="text" name="answer" placeholder="Enter captcha here" />
					<input type="submit" value="CHECK" />
					<input type="button" id="reload" value="Reload" />					
				</form>
 
			</div>
 
			<footer>
				<p>
					&copy; Copyright  by <a href="http://www.ivebe.com">Danijel Petrovic</a>
				</p>
			</footer>
		</div>
		
		<script>
		$(function() { // Handler for .ready() called.
			
			$('#reload').click(function(){				
				$('img').attr('src', 'captcha.php?' + (new Date).getTime());
			});
		});
		</script>
		
	</body>
</html>