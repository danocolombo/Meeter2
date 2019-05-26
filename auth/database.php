<?php
session_start();
global $connection;
/*-----------------
 * database.php
 * ========================================
 * This is authentication method learned from
 * http://www.developerdrive.com/2013/05/creating-a-simple-to-do-application-–-part-3/
 * 
 */
//aws lightsail rogueIntel1 info
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="TwoZeroR0mans1212!";
$dbname="muat";

if ( isset( $connection ) )
	return;
mysqli_report(MYSQLI_REPORT_STRICT);


//$mysqli = new mysqli($host, $user, $password, $dbname, $port);
$mysqli = new mysqli($host, $user, $password);

//$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


if (mysqli_connect_errno()) {		
	die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
}
?>