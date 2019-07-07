<?php
<<<<<<< HEAD
session_start();
$dest = "peopleAction.php";
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
/*=======================================================
 * peopleForm.php
 * 
 *  used to enter and edit people information
 * ======================================================
 */
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
        <script type="text/javascript">
			function validateForm(){
				var x = document.forms["peepForm"]["peepFName"].value;
				if (x == ""){
					alert("Name is required.");
					var elem = document.getElementByID("FName");
					elem.focus();
					elem.select();
					return false;
				}else{
					//now depending on the button value, we will take action.
					var b = document.getElementById("submitButton").value;
					if (b == "add"){
						document.getElementById("peepForm").submit();
						return true;
					}else if(b == "update"){
						document.getElementById("peepForm").submit();
						return true;
					}
				}
			}
			function selectAllCommits(){
				// this function enables the checkbox for all configured commit options for the current user
				<?php 
				//-----------------------------------------------------------------------
				// we will build the javascript necessary to select all AOS checkboxes
				//-----------------------------------------------------------------------
// 				$ckCommits = new mConfig();
// 				$ckCommits->loadConfigFromDB();
// 				foreach($ckCommits->AOS as $key => $value){
// 				    // if the value for the key is false or DisplayValue is NOSHOW, skip
// 				    $parts = explode("#", $value);
// 				    if ($parts[0] == "true"){
// 				        if ($parts[1] != "NOSHOW"){
// 				            $tmp = "cb_" . $key;
// 				            echo "\t\t\t\t" . $tmp . ".checked = true;\n";
// 				        }
// 				    }
// 				}
				?>
				return false;
			}
			function deselectAllCommits(){
				// this function enables the checkbox for all configured commit options for the current user
				<?php 
				//-----------------------------------------------------------------------
				// we will build the javascript necessary to select all AOS checkboxes
				//-----------------------------------------------------------------------
// 				$uckCommits = new mConfig();
// 				$uckCommits->loadConfigFromDB();
// 				foreach($uckCommits->AOS as $key => $value){
// 				    // if the value for the key is false or DisplayValue is NOSHOW, skip
// 				    $parts = explode("#", $value);
// 				    if ($parts[0] == "true"){
// 				        if ($parts[1] != "NOSHOW"){
// 				            $tmp = "cb_" . $key;
// 				            echo "\t\t\t\t" . $tmp . ".checked = false;\n";
// 				        }
// 				    }
// 				}
				?>
				return false;
			}
			
			function ExitPeopleForm(){
				// lets go back to the people list
				window.location.href='people.php';
						return true;
			}
			function validateDeleteUser(){
				// if user is trying to delete system user "Removed User", then echo message that
				// action is not possible. 
				//--------------------------------------------------------------------------------
				var FName = document.forms["peepForm"]["peepFName"].value;
				var LName = document.forms["peepForm"]["peepLName"].value;
				if(FName == "Removed" && LName == "User"){
					// user is trying to delete system entry. Post warning and abort
					alert("The entry you are trying to delete is used by the system, and can\'t be removed");
					return false;
				}
				//check if the current user is set to active
				var aFlag = document.getElementById("peepActive").checked;
				if(aFlag == true){
					alert("It is recommended you make the person \'inactive\' rather than deleting.");
					var x = confirm("Press OK if you want to really delete. All references in the system will be lost");
					if (x == true){
						var recordID = getUrlVars()["PID"];
						var newURL = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
						window.location.href=newURL;
						return true;	
					}else{
						return false;
					}
				}
				var x2 = confirm("Click \'OK\' if you are sure you want to delete this user.");
				if (x2 == true){
					var recordID = getUrlVars()["PID"];
					//alert(recordID);
					//alert("DELETE");
					var dest = "peepDelete.php?Action=DeletePeep&PID=" + recordID;
					window.location.href=dest;
				}else{
					alert("Delete User aborted.");
					return false;
				}
			}
			function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
        </script>
    </head> 
    <body>
		<div class="page">
			<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="/meeter/index.php"><span></span></a>
		</header>
		<div id="navBar">
    		<nav>
            	<a href="meetings.php">Meetings</a> 
            	<a href="people.php">People</a>
            	<a href="teams.php">Teams</a>
            	<a href="leadership.php">Leadership</a>
            	<a href="reportlist.php">Reporting</a>
            	<a href="adminMain.php">ADMIN</a>
            	<a href="logout.php">[ LOGOUT ]</a>
        	</nav>
		</div>
		
			<article>
<?php 
    if(isset($_GET["id"])){
        $PID = $_GET["id"];
    }
   
    if(isset($PID)){
        
    }else{
        //this section is when we don't have a person ID
        echo "<h2>BLANK FORM FOR NEW PERSON ENTRY</h2>";
        exit;
    }
    /*-------------------------------------------------------------------
     *  let's get the person
     -------------------------------------------------------------------*/
    
    $url = "http://rogueintel.org/mapi/public/index.php/api/client/getPerson/" . $_SESSION['client'] . "?id=" . $PID;
    $data = file_get_contents($url); // put the contents of the file into a variable
    $p = json_decode($data); // decode the JSON feed
    $person = $p[0];
    
    echo "<form id='peepForm' action='" . $dest . "' method='post'>";
    echo "<center><h2>CR Personnel Form</h2></center>";
    echo "<center>";
    echo "<table border='0'>";
    echo "<tr><td align='right'>First Name:</td><td><input type='text' id='peepFName' name='peepFName' size='15' value='" . htmlspecialchars($person->FName,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Last Name:</td><td><input type='text' id='peepLName' name='peepLName' size='15' value='" . htmlspecialchars($person->LName,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Address:</td><td><input type='text' id='peepAddress' name='peepAddress' size='25' value='" . htmlspecialchars($person->Address,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>City:</td><td><input type='text' id='peepCity' name='peepCity' size='15' value='" . htmlspecialchars($person->City,ENT_QUOTES) . "'/> ";
    echo "<tr><td align='right'>State:</td><td><input type='text' id='peepState' name='peepState' size='2' value='" . htmlspecialchars($person->State,ENT_QUOTES) . "'/>";
    echo "<tr><td align='right'>Zipcode:</td><td><input type='text' id='peepZipcode' name='peepZipcode' size='25' value='" . htmlspecialchars($person->Zipcode,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Phone 1:</td><td><input type='text' id='peepPhone1' name='peepPhone1' size='15' value='"  . htmlspecialchars($person->Phone1,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Phone 2:</td><td><input type='text' id='peepPhone2' name='peepPhone2' size='15' value='"  . htmlspecialchars($person->Phone2,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Email 1:</td><td><input type='text' id=peepEmail1' name='peepEmail1' size='40' value='"  . htmlspecialchars($person->Email1,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Email 2:</td><td><input type='text' id='peepEmail2' name='peepEmail2' size='40' value='"  . htmlspecialchars($person->Email2,ENT_QUOTES) . "'/></td></tr>";
    
    echo "<tr><td align='right'>Spiritual Gifts:</td><td><textarea id='peepSpiritualGifts' name='peepSpiritualGifts' cols='40' rows='2'>" . htmlspecialchars($person->SpiritualGifts,ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Recovery Area:</td><td><textarea id='peepRecoveryArea' name='peepRecoveryArea' cols='40' rows='2'>" . htmlspecialchars($person->RecoveryArea,ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Recovery Since:</td><td><input type='text' id='peepRecoverySince' name='peepRecoverySince' size='15' value='" . htmlspecialchars($person->RecoverySince,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>CR Since:&nbsp;</td><td><input type='text' id='peepCRSince' name='peepCRSince' size='15' value='" . htmlspecialchars($person->CRSince,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Covenant Date:&nbsp;</td><td><input type='text' name='peepCovenant' size='15' value='" . htmlspecialchars($person->Covenant,ENT_QUOTES) . "'/></td></tr>";
    echo "<tr><td align='right'>Areas Served:</td><td><textarea id='peepAreasServed' name='peepAreasServed' cols='40' rows='4'>" . htmlspecialchars($person->AreasServed,ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Joy Areas:</td><td><textarea id='peepJoyAreas' name='peepJoyAreas' cols='40' rows='4'>" . htmlspecialchars($person->JoyAreas,ENT_QUOTES) . "</textarea></td></tr>";
    echo "<tr><td align='right'>Reasons To Serve:</td><td><textarea peepReasonsToServe' name='peepReasonsToServe' cols='40' rows='5'>" . htmlspecialchars($person->ReasonsToServe,ENT_QUOTES) . "</textarea></td></tr>";
    echo "</table>";
    echo "<table border='0'><tr><td colspan='3'></td></tr>";   // opens the section
    echo "<tr><td valign='top'><table border='3'><tr><td>";             // border around interests
    echo "just stuff in a box";
    echo "</td></tr></table>";
    echo "</table>";
    echo "</form>";
?>
</article>
</div>  <!--   end of "page" div    -->
=======
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
$_SESSION['adminFlag'] = true;

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if(isset($_GET['id'])){
    $insertCall = "peopleFormInsert.php?client=" . $_SESSION['client'] . "&id=" . $_GET['id'];
}else{
    $insertCall = "peopleFormInsert.php";
}
?>

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport"
	content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
    <title>Meeter Web Application</title>


<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
<link rel="stylesheet" type="text/css"
	href="css/screen_layout_large.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:50px) and (max-width:500px)"
	href="css/screen_layout_small.css" />
<link rel="stylesheet" type="text/css"
	media="only screen and (min-width:501px) and (max-width:800px)"
	href="css/screen_layout_medium.css" />
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript"
	src="js/farinspace/jquery.imgpreload.min.js"></script>
<script type="text/javascript" src="js/design.js"></script>
<script>
	function getUrlVars() {
			    var vars = {};
			    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			        vars[key] = value;
			    });
			    return vars;
			}
</script>
<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
<body>
	<div class="page">
		<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="/meeter/index.php"><span></span></a>
		</header><div id="navBar"></div>
		<script>
		$( "#navBar" ).load( "navbarA.php" );		</script>
		<div id="peopleForm"></div>
		<script>
    		var userID = getUrlVars()["id"];
			var insertURL = "<?php echo $insertCall ?>";
			$("#peopleForm").load( insertURL );
		</script>
		<div id="mtrFooter"></div>
		<script>$("#mtrFooter").load("footer.php");</script>
	</div>
>>>>>>> branch '0.1' of https://github.com/danocolombo/Meeter2.git
</body>
</html>