<?php
session_start();
require ("meeter.php");
$_SESSION["client"] = "TBD";
// require_once("classPage.php");
/*
 * =========================================================
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
    
    
    if (! empty($_POST["username"]) && ! empty($_POST["password"])) {
        $username = $_POST["username"];
        $entity = $_POST["entity"];
        $password = $_POST["password"];
        $_SESSION["client"] = $entity;
        
        require_once ('auth/db.php');
        $query = $connection->prepare("SELECT user_id, Admin FROM `uat`.`users` WHERE `user_login` = ? and `user_password` = PASSWORD(?)");
        $query->bind_param("ss", $username, $password);
        $query->execute();
        $query->bind_result($userid, $adminFlag);
        $query->fetch();
        $query->close();
        echo "done with query";
        if (! empty($userid)) {
            $_SESSION["userID"] = $userid;
            $_SESSION["userName"] = $username;
            if($adminFlag == 1){
                $_SESSION["adminFlag"] = true;
            }else{
                $_SESSION["adminFlag"] = false;
            }
            $_SESSION["adminFlag"] = $adminFlag;
            $session_key = session_id();
            $_SESSION["sessionKey"] = $session_key;
            $query = $connection->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
            $query->bind_param("isss", $userid, $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
            $query->execute();
            $query->close();
            
            // $_SESSION["username"] = $username;
            // $_SESSION["password"] = $password;
            header('Location: index.php');
        } else {
            
            header('Location: login.php?Error=Incorrect');
        }
    } else {
        header('Location: login.php?Error=Missing');
    }
} else {
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
<script>
	function checkClearance(){
		var uError = decodeURIComponent(getUrlVars()["Error"]);
		if (uError === "Incorrect"){
			alert("Your login attempt was invalid. Either try again or click \"Help\" for assistance");
			return true;
		}else if(uError === "Missing"){
			alert("You need to enter a login and password to access the application.");
			return true;
		}else if(uError == "Invalid"){
			alert("You need to provide proper login definition (acronym\\username)");
			return true;
		}
		return true;
	}
    function getUrlVars() {
    	var vars = {};
    	var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
    	vars[key] = value;
    	});
    	return vars;
    }
    function getHelp(){
    	var dest = "auth/authHelp.php";
		window.location.href=dest;
		return true;
    }


</script>
</head>
<body onload="checkClearance()">
	<div id="page">
		<!-- [content] -->
		<section id="content">
			<form id="login" method="post">
				<div class="loginBox">
					<fieldset style="width: 200px;">
						<legend>&nbsp;Meeter Web Application&nbsp;</legend>
						<div class="loginText">
							<p>
								<label for="username">Username:</label><input id="username"
									name="username" type="text" required>
							</p>
							<p>
								<label for="entity">Entity:</label><input id="entity"
									name="entity" type="text" required>
							</p>
							<p>
								<label for="password">Password:</label><input id="password"
									name="password" type="password" required>
							</p>
							<p>
								<input class="greenButton" name="loginBtn" type="submit"
									value="Login">
							</p>
						</div>
						<div style="float: right"><button type='button' id='helpButton' onclick='getHelp()' style='background:red;color:white;'>&nbsp;Help !&nbsp;</button></div>
					</fieldset>
				</div>
			</form>
		</section>
		<!-- [/content] -->
	</div>
</body>
</html>
<?php } ?>

