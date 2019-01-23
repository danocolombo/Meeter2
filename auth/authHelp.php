<?php
/*
 * =========================================================
 * authHelp.php
 * 
 * provide information for people struggling with logging in
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Meeter Web Application</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="meeter.css" />
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
	
</head>
<body onload="checkClearance()">
	<div id="page">
		<!-- [content] -->
		<section id="content">
			<form id="login" method="post">
				<div class="loginBox">
					<fieldset style="width: 300px;">
						<legend>&nbsp;Meeter Web Application&nbsp;</legend>
						<div class="loginText">
							<p>If you have forgotten your password or would like to reset your password.</p>
							<p><a href="recoverPassword.php">RECOVER PASSWORD</a></p>
							<p><br/>
							<p>If you need to register for the application, please follow the link below.</p>
							<p><a href="register.php">REGISTER FOR ACCESS</a></p>
						</div>
					</fieldset>
				</div>
			</form>
		</section>
		<!-- [/content] -->
	</div>
</body>
</html>

