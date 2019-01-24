<?php
require '../includes/database.inc.php';
include '../mtgRedirects.php';
$email = $_GET['em'];

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
$dbID = 0;
$stmt = $connection->prepare("Select user_firstname FROM users WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0){
    //echo "already entered";
    $stmt->bind_result($uName);
    while($stmt->fetch()){
        $userName = $uName;
    }
    $stmt->free_result();
    //$stmt->close();
    //user is in system, update with recoveryToken
    $recoveryToken = rand();
    
    $stmt = $connection->prepare("UPDATE users set recovery_token = ? where user_email = ?");
    $stmt->bind_param("ss", $recoveryToken, $email);
    $stmt->execute();
    $stmt->free_result();
    $stmt->close();
    email_notification($userName, $email, $recoveryToken);
}
$connection->close();

$dest = "recoverySent.php?em=" . $email;
destination(307, $dest);




function email_notification($name, $email, $rToken){
    $headers = 'From: meeter@recovery.help';
    
    //mail('user@example.com', 'TEST', 'TEST', null, '-fuser@example.com');
    
    $to = $email;
    $subject = "Meeter Account Recovery";
    $txt = "There has been a request to recover your login for the Meeter Web Application. Click or copy the following URL in your ";
    $txt = $txt .  "browser, and follow the instructions. \n\nIf you did not request this recovery attempt, please contact your Meeter administrator.";
    $txt  = $txt . "\n\rhttp://recovery.help/meeter/clients/uat/auth/newPassword.php?r=$rToken";
    
    mail($to,$subject,$txt,$headers);
    
    
    
}