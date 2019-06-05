<?php
// this file is include to do the task of checking the client db to see if user is admin
//=======================================================================================

// -------------------------------
// see if $_SESSION["userid"] is an admin for client

if(isset($_SESSION["userid"]) === true){
    $userid = $_SESSION["userid"];
    $dbname = $_SESSION["client"];
    include 'db.php';
    include 'db_connect.php';
    // get client Admin value
    //$sql = "SELECT Setting FROM Meeter WHERE Config = 'Admin'";
    $_SESSION["tmp"] = "nothing";
    include('db.php');
    //$dbname = "meeter";
    include('db_connect.php');
    $sql = "SELECT Setting FROM ?.Meeter WHERE Config = 'Admin'";
    if($stmt = mysqli_prepare($connection, $sql)){
        $_SESSION["tmp"] = $sql;
        mysqli_stmt_bind_param($stmt, "s", $param_table);
        $param_table = $dbname;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_bind_result($stmt, $adminSetting);
            if(mysqli_stmt_fetch($stmt)){
                $_SESSION["tmp"] = $adminString;
            }
        }
    }
    
    $clientAdmins = explode("#", $adminSetting);
    
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