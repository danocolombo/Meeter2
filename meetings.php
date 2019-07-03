<?php
session_start();
// require_once('../configs/authenticate.php'); /* used for security purposes */

if(isset($_GET['PAST'])){
    if($_GET['PAST'] == "1"){
        $meeting_view = "PAST";
    }else{
        $meeting_view = "FUTURE";
    }
}else{
    $meeting_view = "FUTURE";
}
if(isset($_SESSION["client"])){
    $insertCall = "navbarA.php?client=" .$_SESSION["client"];
}
/*
 * meetings.php
 * ======================================================
 * this uses pageHead.txt, pageTop.txt & pageBottom.txt
 *****************************************************************/
/***
 * require_once("classPage.php");
 * $page = new Page();
 * print $page->getTop();
 * 
 */
/******************************************************************
 * new meeter header
***************************************************************** */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
        <link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
        <link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css">
        <link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css">
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    </head>
    <body>
		<div class="page">
			<header>
				<a class="logo" title="home" href="index.php"><span></span></a>
			</header>
			<div id="navBar"></div>
		<script>
		<?php 
        		echo "var targetURL = \"" . $insertCall . "\";";
        		
				if($_SESSION["adminFlag"] == "1"){
				    echo "$( \"#navBar\" ).load( targetURL );";
				}else{
				    echo "$( \"#navBar\" ).load( targetURL );";
				}
				?>
		</script>
			<article>
<?php 
    /**********************************
     * finish generic header above
     **********************************/
    if ($meeting_view == "PAST"){
        echo "<center><h1>Past Meetings</h1>";
    }else{
        echo "<center><h1>Future Meetings</h1>";
    }
    /* add a link to enter a new meeting record - IF USER IS ADMIN*/
    if($_SESSION["adminFlag"] == "1"){
        echo "<div style='text-align:right; padding-right: 20px;'><a href='mtgForm.php'>NEW ENTRY</a><br/>";
    }else{
        echo "<div style='text-align:right; padding-right: 20px;'><br/>";
    }
    /* add link to old or new meetings  AND the proper API call*/
    /* add link to old or new meetings */
    if ($meeting_view == "PAST"){
        echo "<a href='meetings.php'>mtg plans</a>";
        $url = "http://100.25.128.0/mapi/public/index.php/api/meetings/getHistory/" . $_SESSION['client'];
    }else{
        echo "<a href='meetings.php?PAST=1'>mtg history</a>";
        $url = "http://100.25.128.0/mapi/public/index.php/api/meetings/getFuture/" . $_SESSION['client'];
    }
    
    echo "</div>";
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
        echo "\nThere were " . sizeof($meetings) . " meetings found\n";
    }
    
    //output the data
    echo "<div style=\"float:right\">" . $_SESSION['client'] . ":" . $_SESSION['userid'] .":" . $_SESSION['adminFlag'] . "</div>";
    //echo "<div>AdminFlag:" . $_SESSION('adminFlag') . "</div>";
    echo "<div>";
    echo "</div>";
    
    /************************************************
     * end the page definition, now close window
     ***********************************************/
    ?>
	</article>
	<footer>
		&copy; 2013-2019 Rogue Intelligence
	</footer>
</div>
</body>
</html>