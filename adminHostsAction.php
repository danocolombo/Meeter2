<?php
require 'includes/database.inc.php';
/*============================================
 * adminHostsAction.php
 *
 * the purpose of this file is to process the adminHosts.php file, which
 * will either add a new host, or remove a specific host
 *
 */


$Action = $_GET['Action'];
$PID = $_GET['candidates'];
echo $Action . " " . $PID;  
// if (!isset($candidates) || !isset($Action)){
//     // Action and PID are required
//     header($loc["301"]);
//     header("Location: adminHosts.php");
//     return;
// } 
switch ($Action){
    case "removeHost":
        removeHost($PID);
        break;
    case "addHost":
        addHost($PID);
        break;
        
    default:
        //if now what we expect, return to menu
        header($loc["301"]);
        header("Location: adminHosts.php");
        break;
}
function removeHost($PID){
    
}
function addHost($PID){
    //first lets get the current host setting, then append the $PID to the end
    //========================================================================
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $Config = "HostSet";
    $HostSetting = "";
    $stmt = $connection->prepare("SELECT ID, Config, Version, Setting From Meeter WHERE Config = ?");
    $stmt->bind_param("s", $Config);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        $stmt->bind_result($dbID, $dbConfig, $dbVersion, $dbSetting);
        while($stmt->fetch()){
            $HostSetting = $dbSetting;
        }
        $stmt->free_result();
        $stmt->close();
        $connection->close();
    }
    //now add $PID to $HostSetting
    $Host_Arr = explode($HostSetting, "|");
    array_push($Host_Arr, $PID);
    $HostSetting = implode("|", $Host_Arr);
    echo $HostSetting;
    
}




header($loc["200"]);
header("Location: adminHosts.php");