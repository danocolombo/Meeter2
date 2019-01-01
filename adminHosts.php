<?php 
require_once('authenticate.php'); /* this is used for security purposes */
?>
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0, initial-scale=1" />
		<title>Meeter Web Application</title>
		<link rel="stylesheet" type="text/css" href="css/jqbase/jquery-ui.theme.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_styles.css" />
		<link rel="stylesheet" type="text/css" href="css/screen_layout_large.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:50px) and (max-width:500px)"   href="css/screen_layout_small.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width:501px) and (max-width:800px)"  href="css/screen_layout_medium.css" />
		
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>
	<body>
		<div class="page">
			<header>
				<div id="hero"></div>
				<a class="logo" title="Host Definitions" href="index.php"></a>
			</header>
			<div id="navBar"></div>
    		<script>
    			$( "#navBar" ).load( "navbar.php" );
    		</script>
			<article>
			<div>this will be the list of current hosts</div>
			
			<div>this will be the from with a drop down with available people to host.</div>
			
				<br/><br/>
			</article>
			<div id="mtrFooter"></div>
			<script>
			     $( "#mtrFooter" ).load( "footer.php" );
    		</script>
		</div>
    </body>
</html>