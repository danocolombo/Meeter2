<?php
/*===================================================
 * authenticate.php
 * this file is used to implement user authentication. The implementation
 * comes from a sample at:
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 * ======================================================
 */
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

$session_key = session_id();

//need to check the session in meeter database.session
include('db.php');
$dbname = "meeter";
include('db_connect.php');

$query = $connection->prepare("SELECT `session_id`, `user_id` FROM `sessions` WHERE `session_key` = ? AND `session_address` = ? AND `session_useragent` = ? AND `session_expires` > NOW();");
$query->bind_param("sss", $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
$query->execute();
$query->bind_result($session_id, $user_id);
$query->fetch();
$query->close();

$_SESSION["userid"] = $user_id;
//$_SESSION["adminFlag"] = "0";
//$_SESSOIN["session_username"] $username;

if(empty($session_id)) {
	header('Location: /login.php');
}else{
    //echo $_SESSION["session_userid"] = $session_id;
}
//this next section updates the session for another hour so the user will not need to login, as long
//as they don't change computers or their credentials.
$query = $connection->prepare("UPDATE `sessions` SET `session_expires` = DATE_ADD(NOW(),INTERVAL 1 HOUR) WHERE `session_id` = ?;");
$query->bind_param("i", $session_id );
$query->execute();
$query->close();

?>
