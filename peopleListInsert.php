<?php 
/*
 * -------------------------------------------------------------------
 * let's list all the people with llink to $dest
 * -------------------------------------------------------------------
 */
if(isset($_GET['client'])){
    $client = $_GET['client'];
}else {
    echo "ERROR: cannot display people list. Notify admin.<br>";
}
if(isset($_GET['action'])){
    $action = $_GET['action'];
}
/*-------------------------------------------------------------------
 *  let's get a list of people in the system that are active
 -------------------------------------------------------------------*/
$url = "http://rogueintel.org/mapi/public/index.php/api/client/getPeople/" . $client . "?filter=active";
$data = file_get_contents($url); // put the contents of the file into a variable
$aPeeps = json_decode($data); // decode the JSON feed

echo "<div style='padding-left:40px'><table>";
foreach($aPeeps as $peep){
    echo "<tr><td style='padding-right:20px'><a href=\"peopleForm.php?id=$peep->ID\"><img src='images/btnEdit.gif'></img></a></td><td>$peep->FName $peep->LName</td></tr>";
}
echo "</table></div>";
?>