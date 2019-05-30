<?php

$servername = "ls-e4e3cbb511361cb2edb5d083f158e77a49afb24f.c2cwx5xdgogr.us-east-1.rds.amazonaws.com";
$username = "dbmaster";
$password = "Tw0Zer019R0mans1212!";

$dbname = "meeter";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT user_id, user_firstname, user_surname FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["user_id"]. " - Name: " . $row["user_firstname"]. " " . $row["user_surname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "<br><h2>going to client DB</h2>";
$dbname = "cpv";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, FName, LName FROM people ORDER BY ID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Name: " . $row["FName"]. " " . $row["LName"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "<br><h2>going to client DB</h2>";
$dbname = "ccc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, FName, LName FROM people ORDER BY ID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Name: " . $row["FName"]. " " . $row["LName"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
echo "<br><h2>going to client DB</h2>";
$dbname = "wbc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ID, FName, LName FROM people ORDER BY ID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["ID"]. " - Name: " . $row["FName"]. " " . $row["LName"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();