<?php
session_start();
//require_once('authenticate.php'); /* used for security purposes */
include '../configs/db.php';
$dbname = $_SESSION['client'];
include '../configs/db_connect.php';
$_SESSION["view"] = "PAST";
$meeting_view = $_SESSION["view"];
if (strlen($meeting_view) < 1){
    $_SESSION["view"] = "FUTURE"; 
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
    
    $tmpToday = date("Y-m-d");
    if ($meeting_view == "PAST"){
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate <= ? ORDER BY m.MtgDate DESC";
    }else{
        $sql = "select m.ID iD, m.MtgDate dAT, m.MtgType tYP, m.MtgTitle tIT, p.fName pNA, 
            w.fName wNA, m.MtgAttendance aTT from meetings m, people p, people w where 
            m.MtgFac = p.ID and m.MtgWorship = w.ID AND m.MtgDate >= ? ORDER BY m.MtgDate ASC";
    }
    echo "<br/>servername:" . $servername . "<br/>";
    echo "username:" . $username . "<br/>";
    echo "password:" . $password . "<br/>";
    echo "dbname:" . $dbname . "<br/>";
    echo "meeting_view:" . $meeting_view . "<br/>";
    //Output any connection error
    
    echo "<br/>" . $sql . "<br/>";
    
    $query=$connection->prepare($sql);
    $query->bind_param("s", $tmpToday);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_row();
    $num_of_rows=count($row);
    echo $num_of_rows."<br>";
    $query->close();
    $connection->close();
    
    
    
    
//     $result = $connection->query($sql, MYSQLI_STORE_RESULT);
        
    echo "<table border=1 id=\"tabledata\" align=\"center\">";
    echo "<tr><td>Date</td><td>#</td><td>Type</td><td>Title</td><td>Leader</td><td>Worship</td></tr>";
    while(list($mID, $mDate, $mType, $mTitle, $mName1, $mName2, $mAttendance) = $result->fetch_row()){
        echo "<tr><td>" . $mID . "</td>";
        echo "<td>" . $mDate . "</td>";
        echo "<td>" . $mType . "</td>";
        echo "<td>" . $mTitle . "</td>";
        echo "<td>" . $mName1 . "</td>";
        echo "<td>" . $mName2 . "</td>";
        echo "<td>" . $mName2 . "</td></tr>";
    }
    echo "</table>";

    /* add a link to enter a new meeting record - IF USER IS ADMIN*/
    if($_SESSION["adminFlag"] == "1"){
        echo "<div style='text-align:right; padding-right: 20px;'><a href='mtgForm.php'>NEW ENTRY</a><br/>";
    }else{
        echo "<div style='text-align:right; padding-right: 20px;'><br/>";
    }
    /* add link to old or new meetings */
    if ($past){
        echo "<a href='meetings.php'>mtg plans</a>";
    }else{
        echo "<a href='meetings.php?PAST=1'>mtg history</a>";
    }
    echo "</div>";
    //output the data
    echo "<div>";
    echo $table->toHTML();
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