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
<script>
	$(document).ready(function(){
		$("#btnRecover").click(function(){
		    alert("Email: " + $("#emailAddress").text());
		  });
//     	function recoverAccess(){
    // 		var em = document.getElementById("EmailAddress").value();
    //     	if( !validateEmail(em) {
    //     		alert("email okay.");
    //     	}else{
    //     		alert("invalid email.");
    //     	}
//     		alert($("#emailAddress").text());	
//         	return false;
//     	}
//         function validateEmail($email) {
//     	  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
//     	  return emailReg.test( $email );
//     	}
	}
    </script>
</head>
<body onload="checkClearance()">
	<div id="page">
		<!-- [content] -->
		<section id="content">
			<form id="frmRecoverPassword" method="post">
				<div class="recoverBox">
					<fieldset style="width: 300px;">
						<legend>&nbsp;Meeter Web Application&nbsp;</legend>
						<div class="loginText">
							<p>Enter the email you have on record.</p>
							<p><input type="text" id="emailAddress" size='30'><br>
							<p><br/>
							<button type='button' id='btnRecover' style='background:green;color:white;'>&nbsp;RECOVER ACCESS&nbsp;</button>
						</div>
					</fieldset>
				</div>
			</form>
		</section>
		<!-- [/content] -->
	</div>
</body>
</html>

