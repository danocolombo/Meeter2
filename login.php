<?php
// Initialize the session
// if (session_status() == PHP_SESSION_NONE){
//     session_start();
// }
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    require_once ('../../configs/authenticate.php'); /* if not accounted for, will send to login*/
    header("location: welcome.php");
    exit;
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Include config file
    //require_once "config.php";
    include('../../configs/db.php');
    $dbname = "meeter";
    include('../../configs/db_connect.php');
    
    
    // Define variables and initialize with empty values
    $username = $password = "";
    $password_err = "";
    $username_err = $password_err = "";
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT user_id, user_login, user_firstname, default_client FROM meeter.users WHERE user_login = ? and user_password = ?";
        if($stmt = mysqli_prepare($connection, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_userpassword);
            
            // Set parameters
            $param_username = $username;
            $param_userpassword =$password;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $userid, $userlogin, $username, $client);
                    if(mysqli_stmt_fetch($stmt)){
                        // Password is correct, so start a new session
                        session_start();
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["userid"] = $userid;
                        $_SESSION["username"] = $username;
                        $_SESSION["userlogin"] = $userlogin;
                        $_SESSION["client"] = $client;
                        
                        //--------------------------------------
                        // check if user is admin for default client
                        $url = "http://100.25.128.0/mapi/public/index.php/api/user/isAdmin/". $client . "?uid=" . $userid;
                        $data = file_get_contents($url); // put the contents of the file into a variable
                        $adminResponse = json_decode($data); // decode the JSON feed
                        
                        echo "<br>data:$data<br>";
                        echo "value: " . $data[1] . "<br";
                        if($adminResponse['admin'] == 'true'){
                            echo "ADMIN=true";
                            exit;
                        }else{
                            echo "ADMIN=false";
                            exit();
                        }
//                         if($adminFlag == 1){
//                             $_SESSION["adminFlag"] = true;
//                         }else{
//                             $_SESSION["adminFlag"] = false;
//                         }
                        //insert session instance in sessions table
                        $session_key = session_id();
                        $query = $connection->prepare("INSERT INTO `sessions` ( `user_id`, `session_key`, `session_address`, `session_useragent`, `session_expires`) VALUES ( ?, ?, ?, ?, DATE_ADD(NOW(),INTERVAL 1 HOUR) );");
                        $query->bind_param("isss", $userid, $session_key, $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
                        $query->execute();
                        //$query->close();
                        //=============================================
                        // check if clients associated with user
                        // it is possible that some access to more than one
                        // client, if so, we need to go select client
                        //=============================================
                        // all client acronyms are 3 in length. If the
                        // length of clientAccess value is 3, just set 
                        // the client SESSION variable.
                        //=============================================
//                         if (strlen(trim($clientAccess)) == 3){
//                             $_SESSION["client"] = $clientAccess;
//                             include '../../configs/checkAdmin.php';
//                         }else{
//                             mysqli_stmt_close($stmt);
//                             $selectClientString = "location: selectClient.php?clientAccess=$clientAccess";
//                             header($selectClientString);
//                             exit;
//                         }
                        // Redirect user to welcome page
                        header("location: index.php");
                    }
                    else{
                        $username = "your attempt was unsuccessful. Try again.";
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($connection);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo (!empty($username)); ?>">
                <span class="help-block"><?php echo (!empty($username_err)); ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo (!empty($password_err)); ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>
