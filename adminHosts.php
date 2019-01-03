<?php 
session_start();
require_once('authenticate.php'); /* this is used for security purposes */
require 'meeter.php';
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
			<div>This administration setting is to identify who can be a host of a meeting.<br/>
			</div>
			<div id="confirmedHosts"></div>
			<script>
    			$(document).ready(function(){
    				var theUrl = 'http://recovery.help/meeter/api/json/hosts/getHosts.php?client=UAT';
        				var output = '';
            			$.ajax({
            				url: theUrl,
            				dataType: 'json',
            				type: 'get',
            				cache: false,
            				success: function(hosts) {
                				
            					$(hosts.hosts).each(function(index, value){
									//output += '<tr><td style=\'padding: 5px\'>';
									output += value.FName + " " + value.LName;
									output += "&nbsp;&nbsp;";
									output += "<a href=\'adminAction.php?Action=RemoveHost&ID=" + value.ID + "\'><font style='font-family:tahoma; font-size:10pt; font-color:red'>[ REMOVE ]</font></a><br/>";
									//var editLink = 'grpForm.php?GID='+value.ID+'&MID='+<?php echo $MID; ?>+'&Action=Edit';
    								//output += '<a href=\''+editLink+'\'><img src=\'images/btnEdit.gif\' alt=\"(edit)\"></img></a></td>';
    								//output += '<td style=\'padding: 5px\'>'+value.Title+'</td>';
    								//output += '<td style=\'padding: 10px; text-align: center;\'>'+value.FacFirstName+'</td>';
    								//output += '<td style=\'padding: 10px; text-align: center;\'>'+value.CoFirstName+'</td>';
    								//output += '<td>'+value.Location+'</td>';
    								//output += '<td align=\'center\' style=\'left-padding: 5px; right-padding: 5px;\'>'+value.Attendance+'</td>';
    								//editLink = 'mtgAction.php?Action=DeleteGroup&MID='+<?php echo $MID;?>+'&GID='+value.ID;
    								//output += '<td width=15px; alight=\'right\'><a href=\''+editLink+'\'><img src=\'images/minusbutton.gif\' alt=\"(remove)\"></img></a></td>';

    
        					});
        					output += '</table>';
        					$('#confirmedHosts').append(output);
    					}    					
        			});
    			});
			</script>	
			<div><br/>this will be the from with a drop down with available people to host.</div>
			<div id="potentialHosts"></div>
			<script>
    			$(document).ready(function(){
    				var theUrl = 'http://recovery.help/meeter/api/json/hosts/getHostCandidates.php?client=UAT';
        				var output = '';
            			$.ajax({
            				url: theUrl,
            				dataType: 'json',
            				type: 'get',
            				cache: false,
            				success: function(hosts) {
                				output += '<table border=1><tr><th>ID</th><th>Name</th></tr>';
            					$(hosts.hosts).each(function(index, value){
									output += '<tr><td style=\'padding: 5px\'>';
									output += value.ID;
									output += "</td><td>";
									output += value.FName + " " + value.LName;
									//var editLink = 'grpForm.php?GID='+value.ID+'&MID='+<?php echo $MID; ?>+'&Action=Edit';
    								//output += '<a href=\''+editLink+'\'><img src=\'images/btnEdit.gif\' alt=\"(edit)\"></img></a></td>';
    								//output += '<td style=\'padding: 5px\'>'+value.Title+'</td>';
    								//output += '<td style=\'padding: 10px; text-align: center;\'>'+value.FacFirstName+'</td>';
    								//output += '<td style=\'padding: 10px; text-align: center;\'>'+value.CoFirstName+'</td>';
    								//output += '<td>'+value.Location+'</td>';
    								//output += '<td align=\'center\' style=\'left-padding: 5px; right-padding: 5px;\'>'+value.Attendance+'</td>';
    								//editLink = 'mtgAction.php?Action=DeleteGroup&MID='+<?php echo $MID;?>+'&GID='+value.ID;
    								//output += '<td width=15px; alight=\'right\'><a href=\''+editLink+'\'><img src=\'images/minusbutton.gif\' alt=\"(remove)\"></img></a></td>';
    								output += '</td></tr>';
    
        					});
        					output += '</table>';
        					$('#potentialHosts').append(output);
    					}    					
        			});
    			});
			</script>	
				<br/><br/>
			</article>
			<div id="mtrFooter"></div>
			<script>
			     $( "#mtrFooter" ).load( "footer.php" );
    		</script>
		</div>
    </body>
</html>