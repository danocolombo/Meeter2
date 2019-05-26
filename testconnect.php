<?php
$servername = "localhost";
$username = "root";
$password = "TwoZero19R0mans1212!";
$dbname = "muat";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>