<?php
    // selectClient.php
    // --------------------------------------
    // this gets called when a user logs in
    // and they have access to more than one
    // client. We prompt them to select, we
    // set the value and go to login.
    //----------------------------------------
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Client Select</h2>
        <p>You have access to more than one client, please select your desire</p>
        <form action="meeterAction.php?Action=clientSelected" method="post">
        	<div class="form-group">
        		<label>Client</label>
        		<select name="meeterClient">
                  <option value="ccc">CCC</option>
                  <option value="cpv">CPV</option>
                  <option value="wbc">WBC</option>
				</select>
        	</div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Select">
            </div>
        </form>
    </div>    
</body>
</html>