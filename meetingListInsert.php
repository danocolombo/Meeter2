<?php
/**********************************
 * finish generic header above
 **********************************/
$client = $_GET['client'];
if(isset($_GET['PAST'])){
    echo "<div style=\"padding-top:25px; padding-bottom:0px;\"><center><h1>Past Meetings</h1></center><div>";
    echo "<div style=\"float:right; padding-right:25px;\"><a href='meetings.php'>mtg plans</a></div>";
    $url = "http://rogueintel.org/mapi/public/index.php/api/meetings/getHistory/" . $client;
}else{
    echo "<div style=\"padding-top:25px; padding-bottom:0px;\"><center><h1>Future Meetings</h1></center></div>";
    echo "<div style=\"float:right; padding-right:25px;\"><a href='meetings.php?PAST=1'>mtg history</a></div>";
    $url = "http://rogueintel.org/mapi/public/index.php/api/meetings/getFuture/" . $client;
}

// ---------------------------------------------
// get meeting data from MAP call
//=======================
$data = file_get_contents($url); // put the contents of the file into a variable
$meetings = json_decode($data); // decode the JSON feed


// if we got some meetings back, display, if not provide notificaiton
if (sizeof($meetings) < 1)
{
    echo "There are no meetings to display in this view\n";
}else{
    //display the table of meetings
    echo "<table border=1 align=\"center\">";
    echo "<tr><td class=\"meetingTableHeader\">Date</td>";
    echo "<td class=\"meetingTableHeader\">#</td>";
    echo "<td class=\"meetingTableHeader\">Type</td>";
    echo "<td class=\"meetingTableHeader\">Title</td>";
    echo "<td class=\"meetingTableHeader\">Leader</td>";
    echo "<td class=\"meetingTableHeader\">Worship</td></tr>";
    foreach ($meetings as $meeting) {
        echo "<tr><td class=\"meetingTable\"><a href=\"mtgForm.php?ID=" . $meeting->meetingID . "\">" . $meeting->meetingDate . "</a></td>";
        echo "<td class=\"meetingTable\" align=\"center\">" . $meeting->meetingAttendance . "</td>";
        echo "<td class=\"meetingTable\">" . $meeting->meetingType . "</td>";
        echo "<td class=\"meetingTable\">" . $meeting->meetingTitle . "</td>";
        echo "<td class=\"meetingTable\">" . $meeting->meetingFacilitator . "</td>";
        echo "<td class=\"meetingTable\">" . $meeting->worship . "</td></tr>";
    }
    echo "</table>";
    echo "<div style=\"padding-top:20px; padding-bottom:20px;\"><center>There were " . sizeof($meetings) . " meetings found.</center></div>";
}