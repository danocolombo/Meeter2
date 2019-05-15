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
$pword = "MR0mans1212!";
if ( isset( $connection ) )
	return;
mysqli_report(MYSQLI_REPORT_STRICT);

//define('DB_HOST', 'localhost');
//define('DB_USER', 'dcolombo_muat');
//define('DB_PASSWORD', 'MR0mans1212!');
//define('DB_NAME', 'dcolombo_muat');

//define('DB_HOST', 'localhost');
define('DB_HOST', 'ls-7ef76385fad42b2871f54789598686fa1e8ddf54.c2cwx5xdgogr.us-east-1.rds.amazonaws.com');
//$tmp = "dcolombo_m" . $_SESSION['client'];
define('DB_USER', 'dbmasteruser');
define('DB_PASSWORD', 'S>gbnTsG+cvk:MlSz`W`H9>Nm_786Q.7');
//$tmp = "dcolombo_m" && $_SESSION['client'];
define('DB_NAME', 'rogueIntel1');
$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


if (mysqli_connect_errno()) {		
	die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
}
?>