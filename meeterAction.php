<?php
// this is primary funcitons for the app
if (session_status() == PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $Action = $_GET['Action'];
    
    switch ($Action){
        case "clientSelected":
            setClientValue();
            exit;
        default:
            echo "not sure what to do with " . $Action;
            exit;
    }
}else{
    // the request is not associated with a valid session.
    header("location: login.php");
    exit;
}
function setClientValue(){
    //user submitted a form to identify client (meeterClient)
    // get the value and select the session value and continue to index.php
    $client = $_REQUEST['meeterClient'];
    $_SESSION["client"] = $client;
    // now check if they are admin
    include '../configs/checkAdmin.php';
    
    //header("location: index.php");
}
