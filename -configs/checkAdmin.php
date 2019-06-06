<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
// this file is include to do the task of checking the client db to see if user is admin
//=======================================================================================

// -------------------------------
// see if $_SESSION["userid"] is an admin for client

if(isset($_SESSION["userid"]) === true){
    $userid = $_SESSION["userid"];
    $apiURL = "http://rogueintel.org/mapi/public/api/client/getAdmins/" . $_SESSION["client"];     

    $data = file_get_contents($apiURL); // put the contents of the file into a variable
    $apiResponse = json_decode($data); // decode the JSON feed
    $clientAdmins = $apiResponse->{'Setting'};
    $admins = explode("#", $clientAdmins);
    for($i=0;$i<sizeof($admins);$i++){
        if($admins[$i] == $userid){
            $_SESSION["adminFlag"] = 1;
        }
    }

    $connection->close();
    header("location: index.php");
    exit;
}else{
    // no userID, send to login
    header("location: login.php");
}