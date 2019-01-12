<?php
session_start();
require("meeter.php");
$_SESSION["client"] = $client;
//require_once("classPage.php");
/*=========================================================
 * login.php
 * This file is leveraged from the following example:
 * 
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 * had to change the destination to be index.php
 * 
 */
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	require_once('database.php');
	if(!empty($_POST["username"]) && !empty($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];
	
		$query = $connection->prepare("SELECT `user_id` FROM `users` WHERE `user_login` = ? and `user_password` = PASSWORD(?)");
		$query->bind_param("ss", $username, $password);
		$query->execute();
		$query->bind_result($userid);
		$query->fetch();
		$query->close();
		
		if(!empty($userid)) {
		    $_SESSION["userID"] = $userid;
		    $_SESSION["userName"] = $username;
			$session_key = session_id();
			
			$query = $connection->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
			$query->bind_param("isss", $userid, $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'] );
			$query->execute();
			$query->close();
			
//                         $_SESSION["username"] = $username;
//                         $_SESSION["password"] = $password;
			header('Location: index.php');
		}
		else {
                        
			header('Location: login.php');
		}
		
	} else {
		header('Location: login.php');
	}
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Meeter Web Application</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="google-signin-client_id" content="1016615882873-4ri4h7650un1mn4kms8fc3k3g3k8ntkp.apps.googleusercontent.com">
	<link rel="stylesheet" type="text/css" href="meeter.css" />
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
	
</head>
<body>
<div id="page">
	<!-- [content] -->
	<section id="content">
		<form id="login" method="post">
                    <div class="loginBox">
                    <fieldset style="width: 250px;">
                        <legend>&nbsp;Meeter Web Application&nbsp;</legend>
                        <div class="loginText">
                    <p><label for="username">Username:</label><input id="username" name="username" type="text" required></p>
                    <p><label for="password">Password:</label><input id="password" name="password" type="password" required></p>					
                       <p><input class="greenButton" name="loginBtn" type="submit" value="Login"></p>
                       <p><button style="font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);" type="button" onclick="validateMtgForm()">LOGIN</button></p>
					</div>
                    </fieldset>
                    </div>
                    
			<div><input type='hidden' id='googleID' name='googleID'></input><br/></div>
            <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark">
            
            </div>
            <script>
              function onSignIn(googleUser) {
                // Useful data for your client-side scripts:
                var profile = googleUser.getBasicProfile();
                console.log("ID: " + profile.getId()); // Don't send this directly to your server!
                console.log('Full Name: ' + profile.getName());
                console.log('Given Name: ' + profile.getGivenName());
                console.log('Family Name: ' + profile.getFamilyName());
                console.log("Image URL: " + profile.getImageUrl());
                console.log("Email: " + profile.getEmail());
        
                // The ID token you need to pass to your backend:
                var id_token = googleUser.getAuthResponse().id_token;
                console.log("ID Token: " + id_token);
                
                $("#googleID").val(profile.getId());
                $("#username").val(profile.getEmail());
                $("#loginBtn").val("PROCEED");
                
//                 var dest = "index.php";
//         		window.location.href=dest;
              }
            </script>
		</form>
	</section>
	<!-- [/content] -->
</div>
    
<!-- </body>
</html>-->
<?php } ?>

