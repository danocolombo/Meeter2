<?php
require '../includes/database.inc.php';
include '../mtgRedirects.php';
$email = $_GET['em'];

require_once ('../database.php');
$query = $connection->prepare("SELECT `user_firstname` FROM `users` WHERE `user_email` = ?");
$query->bind_param("s", $email);
$query->execute();
$query->bind_result($firstName);
$query->fetch();


if(empty($firstName)==false){
    //we did find an entry
    $recoveryToken = rand();
    $query = $connection->prepare("UPDATE users set recovery_token = ?");
    $query->bind_param("s", $recoveryToken);
    $query->execute();
    
    
    email_notification($userName, $email, $recoveryToken);
}
$query->close();

$dest = "recoverySent.php?em=" . $email;
destination(307, $dest);




function email_notification($name, $email, $rToken){
    //mail('meeter@recovery.help', 'TEST', 'TEST', null, '-fmeeter@recovery.help');
    $headers = 'From: meeter@recovery.help' . " " .
        'Reply-To: meeter@recovery.help' . " " .
        'X-Mailer: PHP/' . phpversion();
    
    //mail('user@example.com', 'TEST', 'TEST', null, '-fuser@example.com');
    
    $to = $email;
    $subject = "Meeter Account Recovery";
    $txt = "There has been a request to recover your login for the Meeter Web Application. Click or copy the following URL in your ";
    $txt += "browser, and following the instructions. \n\nIf you did not request this recovery attempt, please contact your Meeter administrator.";
    $txt += "\n\rhttp://recovery.help/meeter/clients/uat/auth/newPassword.php?r=$rToken";
    
    mail($to,$subject,$txt,$headers);
    
    
    
}