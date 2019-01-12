<?php
require 'includes/database.inc.php';
include 'mtgRedirects.php';
/*============================================
 * adminHostsAction.php
 *
 * the purpose of this file is to process the adminHosts.php file, which
 * will either add a new host, or remove a specific host
 *
 */


$Action = $_GET['Action'];
$PID = $_GET['candidates'];
$ID = $_GET['ID'];
// if (!isset($candidates) || !isset($Action)){
//     // Action and PID are required
//     header($loc["301"]);
//     header("Location: adminHosts.php");
//     return;
// } 
switch ($Action){
    case "removeHost":
        removeHost($ID);
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
function removeHost($ID){
   //this function removes the $PID from the hosts string in Meeter table
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    //--------------------------------------
    // first get existing value
    //--------------------------------------
    $Config = "HostSet";
    $hostSetting = "";
    $stmt = $connection->prepare("SELECT ID, Config, Version, Setting From Meeter WHERE Config = ?");
    $stmt->bind_param("s", $Config);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        $stmt->bind_result($dbID, $dbConfig, $dbVersion, $dbSetting);
        while($stmt->fetch()){
            $hostSetting = $dbSetting;
        }
        $stmt->free_result();
//         $stmt->close();
//         $connection->close();
    }
    //put delimited string into array
    $h_arr = explode("|", $hostSetting);
    //identify the element of the $PID
    $bullseye = array_search($ID,$h_arr);
    //remove element
    unset($h_arr[$bullseye]);
    //convert array to string
    $nValue = implode("|",$h_arr);
    
    $sql = "UPDATE Meeter SET Setting = ? WHERE Config = 'HostSet'";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",
        $nValue);
    $stmt->execute();
    $stmt->close();
    $connection->close();
    
    destination(307, "adminHosts.php");
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
    $hostSetting = "";
    $stmt = $connection->prepare("SELECT ID, Config, Version, Setting From Meeter WHERE Config = ?");
    $stmt->bind_param("s", $Config);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0){
        $stmt->bind_result($dbID, $dbConfig, $dbVersion, $dbSetting);
        while($stmt->fetch()){
            $hostSetting = $dbSetting;
        }
        $stmt->free_result();
        $stmt->close();
    }
    //put delimited string into array
    $h_arr = explode("|", $hostSetting);
    //add new host to array
    array_push($h_arr, $PID);
    $nValue = implode("|",$h_arr);
    
    $sql = "UPDATE Meeter SET Setting = ? WHERE Config = 'HostSet'";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s",
        $nValue);
    $stmt->execute();
    $stmt->close();
    $connection->close();
    $tmp = "adminHosts.php";
    executeSQL($sql,$tmp);
//     echo $sql;
//     testSQL($sql);
}
function testSQL($sql){
    /*
     * this function executes the sql passed in
     */
    echo "SQL: " . $sql;
}
function executeSQL($sql,$destination){
    /*
     * this function executes the sql passed in
     */
    
    $con=mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // Check connection
    if (mysqli_connect_errno($con))
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    mysqli_query($con,$sql);
    
    mysqli_close($con);
    
    destination(307, $destination);
    
}