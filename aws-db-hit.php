<?php
include('../configs/db.php');
$dbname = "meeter";

$mysqli = new mysqli($servername, $username, $password, $dbname);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$login = "admin";
$password = "admin";

/* create a prepared statement */
if ($stmt = $mysqli->prepare("SELECT user_id,  user_firstname FROM users WHERE user_login=? and user_password=PASSWORD(?)")) {
    
    /* bind parameters for markers */
    $stmt->bind_param("ss", $login, $password);
    
    /* execute query */
    $stmt->execute();
    
    /* bind result variables */
    $stmt->bind_result($userid, $username);
    
    /* fetch value */
    $stmt->fetch();
    
    printf("%s is the id for %s\n", $userid, $username);
    
    /* close statement */
    $stmt->close();
}

/* close connection */
$mysqli->close();





// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);
// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $sql = "SELECT * FROM users";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["user_id"]. " - Name: " . $row["user_firstname"]. " " . $row["user_surname"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }
// echo "login test<br/>";
// $sql = "SELECT * FROM users where user_login ='aws' and user_password = PASSWORD('aws')";
// $result = $conn->query($sql);

// if ($result->num_rows > 0) {
//     // output data of each row
//     while($row = $result->fetch_assoc()) {
//         echo "id: " . $row["user_id"]. " - Name: " . $row["user_firstname"]. " " . $row["user_surname"]. "<br>";
//     }
// } else {
//     echo "0 results";
// }

// $conn->close();
?>