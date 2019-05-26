<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Username or Password is invalid";
    }
    else
    {
        // Define $username and $password
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $host="ls-7ef76385fad42b2871f54789598686fa1e8ddf54.c2cwx5xdgogr.us-east-1.rds.amazonaws.com";
        $port=3306;
        $socket="";
        $user="dbmasteruser";
        $password="S>gbnTsG+cvk:MlSz`W`H9>Nm_786Q.7";
        $dbname="rogueIntel1";
        
        if ( isset( $connection ) )
            return;
            mysqli_report(MYSQLI_REPORT_STRICT);
            
            
            $mysqli = new mysqli($host, $user, $password, $dbname, $port);
            //$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
            $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
            
            
            if (mysqli_connect_errno()) {
                die(sprintf("[database.php] Connect failed: %s\n", mysqli_connect_error()));
        }
        
        // Establishing Connection with Server by passing server_name, user_id and password as a parameter
        //$connection = mysql_connect("localhost", "root", "");
        // To protect MySQL injection for Security purpose
        $username = stripslashes($username);
        $password = stripslashes($password);
        $username = mysql_real_escape_string($username);
        $password = mysql_real_escape_string($password);
        // Selecting Database
        $db = mysql_select_db("mwbc", $connection);
        // SQL query to fetch information of registerd users and finds user match.
        $query = mysql_query("select * from users where user_password='$password' AND user_login='$username'", $connection);
        $rows = mysql_num_rows($query);
        if ($rows == 1) {
            $_SESSION['login_user']=$username; // Initializing Session
            header("location: profile.php"); // Redirecting To Other Page
        } else {
            $error = "Username or Password is invalid";
        }
        mysql_close($connection); // Closing Connection
    }
}
?>