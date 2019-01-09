<?php
/*============================================
 * adminHostsAction.php
 *
 * the purpose of this file is to process the adminHosts.php file, which
 * will either add a new host, or remove a specific host
 *
 */


$Action = $_GET['Action'];
$PID = $_GET['PID'];
if (!isset($PID) || !isset($Action)){
    // Action and PID are required
    header($loc["301"]);
    header("Location: adminHosts.php");
    return;
} 
switch ($Action){
    case "removeHost":
        
        break;
    case "addHost":
        
        break;
        
    default:
        //if now what we expect, return to menu
        header($loc["301"]);
        header("Location: adminHosts.php");
        break;
}
        



if ($Action  "removeHost"){
    
    echo "INVALID ENTRY";
    exit;
}
//now we have config from database. update valuse from form and update database.
$aosConfig->loadConfigFromDB();
foreach($aosConfig->AOS as $key => $value){
    $cb = "cb_" . $key;
    $tb = "tb_" . $key;
    if(isset($_POST[$cb])){
        $aosConfig->setConfigToTrue($key);
        if($aosConfig->canVolunteer($key)){
            $dV = $_POST[$tb];
            $aosConfig->setDisplayString($key, $dV);
        }
    }else{
        $aosConfig->setConfigToFalse($key);
    }
}
$aosConfig->saveConfigToDB();


header($loc["200"]);
header("Location: adminHosts.php");