<?php
/*
 * =========================================================
 * authHelp.php
 * 
 * provide information for people struggling with logging in
 */
?>
<!DOCTYPE html>
<html>
<head>
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$("#btnRecover").click(function(){
			var em = $("#emailAddress").val();
			if (em.length < 8){
				alert("You need to provide a well-formed email address.");
				return false;
			}
			if(validateEmail(em)){
				var dest = "recoveryAction.php?em=" + em;
				window.location.href=dest;
				return true;
			}else{
				alert("You need to provide a well-formed email address.");
				return false;
			}
			return false;
		});
		function validateEmail($email) {
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			return emailReg.test( $email );
		}
	});
</script>
</head>
<body>
	<form id="frmRecoverPassword" method="post">
		<div class="recoverBox">
			<fieldset style="width: 300px;">
				<legend>&nbsp;Meeter Web Application&nbsp;</legend>
				<div class="loginText">
					<p>
					<p>Enter the email you have on record.</p>
					<p>
						<input type="text" id="emailAddress" size='40'><br>
					</p>
					<button type='button' id='btnRecover' style='background:green;color:white;'>&nbsp;RECOVER ACCESS&nbsp;</button>
				</div>
			</fieldset>
		</div>
	</form>
</body>
</html>


