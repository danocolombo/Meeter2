<?php
// this file is include to do the task of checking the client db to see if user is admin
//=======================================================================================

// -------------------------------
// see if $_SESSION["userid"] is an admin for client

if(isset($_SESSION["userid"]) === true){
    $userid = $_SESSION["userid"];
    $apiURL = "http://rogueintel.org/mapi/public/api/client/getAdmins/" . $_SESSION["client"];
    echo "<br>".$apiURL . "<br>";
//     $url = 'http://rogueintel.org/mapi/public/api/client/getAdmins/cpv'; // path to your JSON file
    $data = file_get_contents($apiURL); // put the contents of the file into a variable
    $apiResponse = json_decode($data); // decode the JSON feed
    $clientAdmins = $apiResponse->{'Setting'};
    
    $admins = explode("#", $clientAdmins);
    print_r($admins);
    echo "<br>userid: " . $userid . "<br>";
    echo "<br>";
    echo "size:" . sizeof($admins) . "<br/>";
    $isAdmin = array_search($userid, $admins);
    if(isset($isAdmin)=== true){
        echo "<br>Admin: true<br>";
    }else{
        echo "<br>Admin: false<br>";
    }
    exit;

    for($i = 0; i < sizeof($admins); $i++){
        if($admins[$i] == $userid){
            $_SESSION["adminFlag"] = true;
        }
    }
    echo "$_SESSION[adminFlag] = " . $_SESSION["adminFlag"];
    exit;
    
    
    if(strlen(sizeof($clientAdmins))<1){
        // we did not get any admins... throw err. stop
        echo "_SESSION[userid] = " . $_SESSION["userid"] . "<br/>";
        echo "_SESSION[client] = " . $_SESSION["client"] . "<br/>";
        echo "sql>>" . $sql . "<<<br/>";
        echo "clientAdmins:" . $clientAdmins . "<br/><br/>";
        ECHO "NO ADMINS FOR CLIENT";
        exit;
    }

    $admins = explode("#", $clientAdmins);
    for($i = 0; i < sizeof($admins); $i++){
        if(admins[$i] === $userid){
            $_SESSION["adminFlag"] = true;
        }
    }
    
    
    
    $connection->close();
    header("location: index.php");
    exit;
}else{
    // no userID, send to login
    header("location: login.php");
}