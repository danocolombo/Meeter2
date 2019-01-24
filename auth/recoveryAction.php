<?php
require '../includes/database.inc.php';
$email = $_GET['em'];

echo $email;
//check if there is a use with such an email....
$sql = "SELECT * FROM users WHERE user_email = '";
$sql .= $email + "'";

$result = mysqli_query($dbcon, $query);
if (!result){
    die("Database query failed.");
}

$userInfo = mysqli_fetch_assoc($result);
$userId = $userInfo["user_id"];
$userName = $userInfo["user_firstname"];
mysqli_free_result($result); 

$uniqueId = random();

email_notification($userName, $email);


$result->close();