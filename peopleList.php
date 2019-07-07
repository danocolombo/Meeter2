<?php
if (session_status() == PHP_SESSION_NONE){
    session_start();
}
/*############################################################
 *      peopleList.php
 *      
 *      used to display a list of people to select by user
 *      
 ############################################################*/
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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

<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
</head>
<body>
	<div class="page">
		<header>
			<div id="hero"></div>
			<a class="logo" title="home" href="/meeter/index.php"><span></span></a>
		</header>
		<div id="navBar"></div>
		<script>
			<?php 
// 			$_SESSION["adminFlag"] = FALSE;
// 			if(!isset($_SESSION["adminFlag"])){
    			if($_SESSION["adminFlag"] == "true"){
    			    echo "$( \"#navBar\" ).load( \"navbarA.php\" );";
    			}else{
    			    echo "$( \"#navBar\" ).load( \"navbar.php\" );";
    			}
// 			}
			?>
			
		</script>
		<article>
		<?php 
		  /*-------------------------------------------------------------------
		   *  let's get a list of people in the system that are active
		   -------------------------------------------------------------------*/
    		$url = "http://rogueintel.org/mapi/public/index.php/api/client/getPeople/" . $_SESSION['client'] . "?filter=active";
    		$data = file_get_contents($url); // put the contents of the file into a variable
    		$aPeeps = json_decode($data); // decode the JSON feed
		    
    		echo "<div style='padding-left:40px'><table>";
    		foreach($aPeeps as $peep){
    		    echo "<tr><td style='padding-right:20px'><a href=\"peopleForm.php?id=$peep->ID\"><img src='images/btnEdit.gif'></img></a></td><td>$peep->FName $peep->LName</td></tr>";
    		}
    		echo "</table></div>";
		?>
		</article>
		<div id="mtrFooter"></div>
		<script>$("#mtrFooter").load("footer.php");</script>
	</div>
</body>
</html>