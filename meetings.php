<?php
session_start();
require_once('../configs/authenticate.php'); /* used for security purposes */

if(isset($_GET['PAST'])){
    if($_GET['PAST'] == "1"){
        $meeting_view = "PAST";
    }else{
        $meeting_view = "FUTURE";
    }
}else{
    $meeting_view = "FUTURE";
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
				if($_SESSION["adminFlag"] == "1"){
				    echo "$( \"#navBar\" ).load( \"navbarA.php\" );";
				}else{
				    echo "$( \"#navBar\" ).load( \"navbar.php\" );";
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
    /* add link to old or new meetings */
    if ($meeting_view == "PAST"){
        echo "<a href='meetings.php'>mtg plans</a>";
    }else{
        echo "<a href='meetings.php?PAST=1'>mtg history</a>";
    }
    echo "</div>";
    include '../configs/db.php';
    $dbname = $_SESSION['client'];
    include '../configs/db_connect.php';
    $tmpToday = date("Y-m-d");
    if ($meeting_view == "PAST"){
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate <= '" . $tmpToday . "' ORDER BY m.MtgDate DESC";
    }else{
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate >= '" . $tmpToday . "' ORDER BY m.MtgDate ASC";
    }
    
    $result = $connection->query($sql);
    
    if ($result->num_rows > 0) {
        // output data of each row
        echo "<table border=1 align=\"center\">";
        echo "<tr><td class=\"meetingTableHeader\">Date</td>";
        echo "<td class=\"meetingTableHeader\">#</td>";
        echo "<td class=\"meetingTableHeader\">Type</td>";
        echo "<td class=\"meetingTableHeader\">Title</td>";
        echo "<td class=\"meetingTableHeader\">Leader</td>";
        echo "<td class=\"meetingTableHeader\">Worship</td></tr>";
        
        while($row = $result->fetch_assoc()) {
//             echo "id: " . $row["user_id"]. " - Name: " . $row["user_firstname"]. " " . $row["user_surname"]. "<br>";
            echo "<tr><td class=\"meetingTable\"><a href=\"mtgForm.php?ID=" . $row[iD] . "\">" . $row["dAT"] . "</a></td>";
            echo "<td class=\"meetingTable\">" . $row["aTT"] . "</td>";
            echo "<td class=\"meetingTable\">" . $row["tYP"] . "</td>";
            echo "<td class=\"meetingTable\">" . $row["tIT"] . "</td>";
            echo "<td class=\"meetingTable\">" . $row["pNA"] . "</td>";
            echo "<td class=\"meetingTable\">" . $row["wNA"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }
    $connection->close();
    

    
    //output the data
    echo "<div style=\"float:right\">" . $_SESSION['client'] . ":" . $_SESSION['userid'] .":" . $_SESSION['adminFlag'] . "</div>";
    //echo "<div>AdminFlag:" . $_SESSION('adminFlag') . "</div>";
    echo "<div>";
    /**** print the records returned  */
    printf("There were %d meetings found", $result->num_rows);
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