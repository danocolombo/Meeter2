<?php
// Initialize the session
session_start();

//need to conclude the session entry in the database
include('../configs/db.php');
$dbname = "meeter";
include('../configs/db_connect.php');

//get current session from db
$query = $connection->prepare("SELECT `session_id`, `user_id` FROM `sessions` WHERE `session_key` = ? AND `session_address` = ? AND `session_useragent` = ? AND `session_expires` > NOW();");
$query->bind_param("sss", $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
$query->execute();
$query->bind_result($session_id, $user_id);
$query->fetch();
$query->close();

//update the session with expiration date as now.
$when = date("Y-m-d h:i:sa");
$sql = "UPDATE `sessions` SET `session_expires` = '" . $when . "' WHERE `session_key` = '" . $session_key . "'";
include('../configs/db_connect.php');
mysqli_query($connection,$sql);
mysqli_close($connection);



// Unset all of the session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page
header("location: login.php");
exit;
?>
