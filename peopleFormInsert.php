<?php 
/*
 * -------------------------------------------------------------------
 * let's get the person
 * -------------------------------------------------------------------
 */
if(isset($_GET['id']) && isset($_GET['client'])){
    $PID = $_GET['id'];
    $client = $_GET['client'];
}else {
    echo "ERROR: cannot display person data. Notify admin.<br>";
}
$url = "http://rogueintel.org/mapi/public/index.php/api/client/getPerson/" . $client . "?id=" . $PID;
$data = file_get_contents($url); // put the contents of the file into a variable
$p = json_decode($data); // decode the JSON feed
$person = $p[0];

echo "<form id='peepForm' action='" . $dest . "' method='post'>";
echo "<center style=\"padding-top:25px; padding-bottom:0px;\"><h2>CR Personnel Form</h2></center>";
echo "<center><table border='0'>";
echo "<tr><td align='right'>First Name:</td><td><input type='text' id='peepFName' name='peepFName' size='15' value='" . htmlspecialchars($person->FName, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Last Name:</td><td><input type='text' id='peepLName' name='peepLName' size='15' value='" . htmlspecialchars($person->LName, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Address:</td><td><input type='text' id='peepAddress' name='peepAddress' size='25' value='" . htmlspecialchars($person->Address, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>City:</td><td><input type='text' id='peepCity' name='peepCity' size='15' value='" . htmlspecialchars($person->City, ENT_QUOTES) . "'/> ";
echo "<tr><td align='right'>State:</td><td><input type='text' id='peepState' name='peepState' size='2' value='" . htmlspecialchars($person->State, ENT_QUOTES) . "'/>";
echo "<tr><td align='right'>Zipcode:</td><td><input type='text' id='peepZipcode' name='peepZipcode' size='25' value='" . htmlspecialchars($person->Zipcode, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Phone 1:</td><td><input type='text' id='peepPhone1' name='peepPhone1' size='15' value='" . htmlspecialchars($person->Phone1, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Phone 2:</td><td><input type='text' id='peepPhone2' name='peepPhone2' size='15' value='" . htmlspecialchars($person->Phone2, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Email 1:</td><td><input type='text' id=peepEmail1' name='peepEmail1' size='40' value='" . htmlspecialchars($person->Email1, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Email 2:</td><td><input type='text' id='peepEmail2' name='peepEmail2' size='40' value='" . htmlspecialchars($person->Email2, ENT_QUOTES) . "'/></td></tr>";

echo "<tr><td align='right'>Spiritual Gifts:</td><td><textarea id='peepSpiritualGifts' name='peepSpiritualGifts' cols='40' rows='2'>" . htmlspecialchars($person->SpiritualGifts, ENT_QUOTES) . "</textarea></td></tr>";
echo "<tr><td align='right'>Recovery Area:</td><td><textarea id='peepRecoveryArea' name='peepRecoveryArea' cols='40' rows='2'>" . htmlspecialchars($person->RecoveryArea, ENT_QUOTES) . "</textarea></td></tr>";
echo "<tr><td align='right'>Recovery Since:</td><td><input type='text' id='peepRecoverySince' name='peepRecoverySince' size='15' value='" . htmlspecialchars($person->RecoverySince, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>CR Since:&nbsp;</td><td><input type='text' id='peepCRSince' name='peepCRSince' size='15' value='" . htmlspecialchars($person->CRSince, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Covenant Date:&nbsp;</td><td><input type='text' name='peepCovenant' size='15' value='" . htmlspecialchars($person->Covenant, ENT_QUOTES) . "'/></td></tr>";
echo "<tr><td align='right'>Areas Served:</td><td><textarea id='peepAreasServed' name='peepAreasServed' cols='40' rows='4'>" . htmlspecialchars($person->AreasServed, ENT_QUOTES) . "</textarea></td></tr>";
echo "<tr><td align='right'>Joy Areas:</td><td><textarea id='peepJoyAreas' name='peepJoyAreas' cols='40' rows='4'>" . htmlspecialchars($person->JoyAreas, ENT_QUOTES) . "</textarea></td></tr>";
echo "<tr><td align='right'>Reasons To Serve:</td><td><textarea peepReasonsToServe' name='peepReasonsToServe' cols='40' rows='5'>" . htmlspecialchars($person->ReasonsToServe, ENT_QUOTES) . "</textarea></td></tr>";
echo "</table>";
echo "<table border='0'><tr><td colspan='3'></td></tr>"; // opens the section
echo "<tr><td valign='top'><table border='3'><tr><td>"; // border around interests
echo "just stuff in a box";
echo "</td></tr></table>";
echo "</table>";
echo "</form>";
?>