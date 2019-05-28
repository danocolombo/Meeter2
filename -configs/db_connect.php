<?php

// Create connection
// echo "servername: $servername <br/>";
// echo "username: $username<br/>";
// echo "password: $password<br/>";
// echo "dbname: $dbname<br/>";
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
if (mysqli_connect_errno()) {
    die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
}
?>