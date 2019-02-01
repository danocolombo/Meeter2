<?php
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
$rToken = $_GET['r'];
$password1 = null;
$password2 = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    require_once ('../database.php');
    if (! empty($_POST["password1"]) && ! empty($_POST["password2"])) {
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];
        $recoveryToken = $_POST["recoveryToken"];
        if($password1 != $password2){
            $dest = "Location: newPassword.php?Error=noMatch&r=" . $rToken;
            header($dest);
        }
        //echo $password1 . "\n\r" . $rToken;
        $query = $connection->prepare("UPDATE users set user_password = PASSWORD(?) WHERE recovery_token = ?");
        $query->bind_param("ss", $password1, $rToken);
        $query->execute();
        //$query->bind_result($userid);
        $query->fetch();
        $query->close();
        header('Location: ../login.php');
    } else {
        header('Location: login.php?Error=Fail');
    }
} else {
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Meeter Web Application</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="../meeter.css" />
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="js/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script>
function checkClearance(){
	var uError = decodeURIComponent(getUrlVars()["Error"]);
	if (uError === "noMatch"){
		alert("The two passwords entered do not match, please try again.");
	}else if (uError === "Fail"){
		alert("Request Failed, please try again.");
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
	

</script>
</head>
<body onload="checkClearance()">
	<div id="page">
		<!-- [content] -->
		<section id="content">
			<form id="passwordReset" method="post">
				<div><input type="hidden" id="recoveryToken" name="recoveryToken" value='<?php $_GET["r"]?>'></input></div>
				<div class="passwordBox">
					<fieldset style="width: 250px;">
						<legend>&nbsp;Meeter Web Application&nbsp;</legend>
						<div class="passwordsText">
							<p>
								<label for="password1">Enter new password:</label><input id="password1"
									name="password1" type="password" required>
							</p>
							<p>
								<label for="password2">Re-enter the password:</label><input id="password2"
									name="password2" type="password" required>
							</p>
							<p>
								<input class="greenButton" name="btnReset" type="submit"
									value="RESET">
							</p>
						</div>
					</fieldset>
				</div>
			</form>
		</section>
		<!-- [/content] -->
	</div>
</body>
</html>
<?php } ?>

