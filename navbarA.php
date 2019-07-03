<?php 
if (isset($_GET['client'])){
    $client = $_GET['client'];
    $clientString = "?client=" . $client;
}?>
<nav>
	<a href="meetings.php">Meetings</a> 
	"<a href="peopleList.php<?php echo $clientString ?>">People</a>
	"<a href="teams.php">Teams</a>
	"<a href="leadership.php">Leadership</a>
	"<a href="reportlist.php">Reporting</a>
	"<a href="adminMain.php">ADMIN</a>
	"<a href="logout.php">[ LOGOUT ]</a>
</nav>