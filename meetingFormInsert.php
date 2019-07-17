<?php
if (isset($_GET['client'])) {
    $client = $_GET['client'];
} else {
    echo "ERROR: no client provided, contact admin";
}
if (isset($_GET["id"])) {
    // going to display a meeting
    $MID = $_GET["id"];
}

/*
 * ------------------------------------------------------------------------------------------------------------
 * load the system configuration and possible assignees
 * use the mapi api call with client definition
 *
 * http://rogueintel.org/mapi/public/index.php/api/client/getConfig/<client>
 * ------------------------------------------------------------------------------------------------------------
 */
$url = "http://rogueintel.org/mapi/public/index.php/api/client/getConfig/" . $client;
$data = file_get_contents($url); // put the contents of the file into a variable
$configInfo = json_decode($data); // decode the JSON feed
                                  
// echo "config size:" . sizeof($configInfo) . "<br>";
foreach ($configInfo as $x => $x_value) {
    // echo "Key=" . $x . ", Value=" . $x_value;
    // echo "<br>";
    $tmp = explode(":", $x_value);
    // store the boolean of the value
    $configs[$tmp[0]] = $tmp[1];
}
// echo "<br><br>configs:<br>";
foreach ($configs as $x => $x_value) {
    // echo "Key=" . $x . ", Value=" . $x_value;
    // echo "<br>";
    $v = explode("#", $x_value);
    $configItems[] = $x;
    $configValue[$x] = $v[1];
    $configSwitch[$x] = $v[0];
}
/*
 * ------------------------------------------------------
 * at this point we have two arrays with values for
 * configuration settings and values
 *
 * configItems[] gives the column values configured
 *
 * the following arrays are referenced by the configItems value
 * ----------------------------------------------
 * configSwitch[] gives true or false to display
 * configSValue[] gives value to display or use
 *
 * --------------------------------------------------------
 */
// echo "<br>the config items:<br>";
// foreach ($configItems as $x => $x_value){
// echo $x_value . "<br>";
// }
// echo "<br>configSwitch[donations]:". $configSwitch["donations"] . "<br>";
// echo "configValue[donations]:" . $configValue["donations"] . "<br>";
// exit;
/*
 * ----------------------------
 * print out sample...
 * echo "config switches and value: " . sizeof($configValue) . "<br>";
 * echo "<br>youthFac display:";
 * echo $configSwitch['youthFac'];
 * echo " value:";
 * echo $configValue['youthFac'];
 *
 *
 * //echo $configs['youthFac'];
 *
 * //print_r($configs);
 * //echo "##################<br>";
 * //echo "configInfo...<br>";
 * //print_r($configInfo);
 * //echo "<br><br>mtgDetails...<br>";
 * //print_r($mtgDetails);
 * exit;
 *
 *
 * --------------------------------------
 */

/*
 * ===================================================================================
 * get Ghost and NPWID and meeting hosts
 *
 * http://rogueintel.org/mapi/public/index.php/api/client/getMetterInfo/<client>
 * ====================================================================================
 */
// set the values, in case they are not configured.
$_gid = - 1;
$_glabel = "undefined";
$_npwid = - 1;
$_npwlabel = "undefined";
$meetingHostString = "";

$url = "http://rogueintel.org/mapi/public/index.php/api/client/getMeeterInfo/" . $client;
$data = file_get_contents($url); // put the contents of the file into a variable
$meeterTable = json_decode($data); // decode the JSON feed
foreach ($meeterTable as $entry) {
    if (strcmp($entry->Config, "GhostID") == 0) {
        $_gid = $entry->Setting;
    }
    if (strcmp($entry->Config, "GhostLabel") == 0) {
        $_glabel = $entry->Setting;
    }
    if (strcmp($entry->Config, "NonPersonWorshipID") == 0) {
        $_npwid = $entry->Setting;
    }
    if (strcmp($entry->Config, "NonPersonWorshipLabel") == 0) {
        $_npwlabel = $entry->Setting;
    }
    if (strcmp($entry->Config, "HostSet") == 0) {
        $meetingHostString = $entry->Setting;
    }
}
// echo "<br>meetingHostString: $meetingHostString <br>";
// now we need to take the $meetingHostString and build the hosts people list
$hostIDs = explode("|", $meetingHostString);
foreach ($hostIDs as $id) {
    http: // rogueintel.org/mapi/public/index.php/api/client/getPerson/ccc?id=1
    $url = "http://rogueintel.org/mapi/public/index.php/api/client/getPerson/" . $client . "?id=" . $id;
    $data = file_get_contents($url); // put the contents of the file into a variable
    $userInfo = json_decode($data); // decode the JSON feed
    $n = array(
        $userInfo[0]->ID,
        $userInfo[0]->FName,
        $userInfo[0]->LName
    );
    $hoster[$id] = $n;
}
// echo "<br>";
// now we should have hostDef[] with all hosts...
// echo "<br> we have " . sizeof($hoster) . " available hosts<br>";
// foreach ($hoster as $host){
// echo $host[0] . " " . $host[1] . " " . $host[2] ."<br>";
// }
// exit();

// //let's check our values at this point
// //-------------------------------------
// echo "<br>gid: $_gid <br>";
// echo "glabel: $_glabel <br>";
// echo "npwid: $_npwid <br>";
// echo "npwlabel: $_npwlabel <br>";
// exit;

/*
 * -----------------------------------------------------------------------------------------------------------------
 * get the meeting information
 *
 * useing the mapi api
 * http://rogueintel.org/mapi/public/index.php/api/client/getMeeting/<client>?mid=357
 * -----------------------------------------------------------------------------------------------------------------
 */

if (isset($MID)) {
    /*
     * -----------------------------------------------------------------------------------------------------------------
     * get the meeting information if ID is provided in URL
     *
     * useing the mapi api
     * http://rogueintel.org/mapi/public/index.php/api/client/getMeeting/<client>?mid=357
     * -----------------------------------------------------------------------------------------------------------------
     */
    $edit = true;
    $url = "http://rogueintel.org/mapi/public/index.php/api/client/getMeeting/" . $client . "?mid=" . $MID;
    $data = file_get_contents($url); // put the contents of the file into a variable
    $mtgDetails = json_decode($data); // decode the JSON feed
    $mtgID = $MID;
    $origDate = new DateTime($mtgDetails[0]->MtgDate);
    $mtgDate = $origDate->format('m/d/y');
    $mtgType = $mtgDetails[0]->MtgType;
    $mtgTitle = $mtgDetails[0]->MtgTitle;
    $mtgFac = $mtgDetails[0]->MtgFac;
    $mtgAttendance = $mtgDetails[0]->MtgAttendance;
    $mtgWorship = $mtgDetails[0]->MtgWorship;
    $mtgMenu = $mtgDetails[0]->Meal;
    $mtgMealCnt = $mtgDetails[0]->MealCnt;
    $mtgNurseryCnt = $mtgDetails[0]->NurseryCnt;
    $mtgChildrenCnt = $mtgDetails[0]->ChildrenCnt;
    $mtgYouthCnt = $mtgDetails[0]->YouthCnt;
    $mtgNotes = $mtgDetails[0]->MtgNotes;
    $mtgDonations = $mtgDetails[0]->Donations;
    $mtgNewcomers1Fac = $mtgDetails[0]->Newcomers1Fac;
    $mtgNewcomers2Fac = $mtgDetails[0]->Newcomers2Fac;
    $mtgReader1Fac = $mtgDetails[0]->Reader1Fac;
    $mtgReader2Fac = $mtgDetails[0]->Reader2Fac;
    $mtgNurseryFac = $mtgDetails[0]->NurseryFac;
    $mtgChildrenFac = $mtgDetails[0]->ChildrenFac;
    $mtgYouthFac = $mtgDetails[0]->YouthFac;
    $mtgMealFac = $mtgDetails[0]->MealFac;
    $mtgCafeFac = $mtgDetails[0]->CafeFac;
    $mtgTransportationFac = $mtgDetails[0]->TransportationFac;
    $mtgSetupFac = $mtgDetails[0]->SetupFac;
    $mtgTearDownFac = $mtgDetails[0]->TearDownFac;
    $mtgGreeter1Fac = $mtgDetails[0]->Greeter1Fac;
    $mtgGreeter2Fac = $mtgDetails[0]->Greeter2Fac;
    $mtgChips1Fac = $mtgDetails[0]->Chips1Fac;
    $mtgChips2Fac = $mtgDetails[0]->Chips2Fac;
    $mtgResourcesFac = $mtgDetails[0]->ResourcesFac;
    $mtgTeachingFac = $mtgDetails[0]->TeachingFac;
    $mtgSerenityFac = $mtgDetails[0]->SerenityFac;
    $mtgAudioVisualFac = $mtgDetails[0]->AudioVisualFac;
    $mtgAnnouncementsFac = $mtgDetails[0]->AnnouncementsFac;
    $mtgSecurityFac = $mtgDetails[0]->SecurityFac;
}
/*
 * -----------------------------------------------------------------------------------------------
 * get the people list
 * ------------------------------------------------------------------------------------------------
 */
// loadCommitTableWithAllPeople();
// $_gid = getGhostID();
// $_glabel = getGhostLabel();
// $_npwid = getNonPersonWorshipID();
// $_npwlabel = getNonPersonWorshipLabel();

// echo "configInfo...<br>";
// print_r($configInfo);
// echo "<br><br>mtgDetails...<br>";
// print_r($mtgDetails);
// exit;

// echo "<br>ALRIGHT, MOVING FORWARD<br>";
// --------------------------------------------------------
// need to put system AOS into aos object
// --------------------------------------------------------

// --------------------------------------------------------
// get the list of people that are committed to serving
//
// http://rogueintel.org/mapi/public/index.php/api/client/getCommits/ccc
//
// ------------------------------------------------------------------------------
$url = "http://rogueintel.org/mapi/public/index.php/api/client/getCommits/" . $client;
$data = file_get_contents($url); // put the contents of the file into a variable
$serviceCommits = json_decode($data); // decode the JSON feed
                                      
// serviceCommist holds all the volunteers
// foreach ($serviceCommits as $commit) {
//     echo "<br>$commit->ID ";
//     echo "$commit->Category ";
//     echo "$commit->FName ";
//     echo "$commit->LName";
// }
// exit;
                                      // load the system configuration settings into object to use.
                                      
// $aosConfig->loadConfigFromDB();
                                      
// #############################################
// END OF PRE-CONDITIONING
// #############################################
?>
<!-- Javascript -->
<script>
//             $( "#mtgDonations" ).keypress(function() {
//             	var regex = new RegExp("^[a-zA-Z0-9]+$");
//                 var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
//                 if (!regex.test(key)) {
//                    event.preventDefault();
//                    return false;
//                 }
//         	});
			
			function validateMtgForm(){
				// start with validating the date value
				$( "#mtgDate" ).datepicker();
				var tmpString = "";
				var m_Date = $( "#mtgDate" ).datepicker('getDate');
				
				var m_NewDate = $("#mtgDate").datepicker({ dateFormat: 'yyyy,mm,dd'}).val();

				if(isValidDate(m_NewDate) == false){
					alert("please select an accurate date");
					$("#mtgDate").datepicker("setDate", new Date());
					$("#mtgDate").datepicker( "show" );
					return false;
				}
				var m_type = $('input[name=rdoMtgType]:checked').attr('id');
				if(m_type == "undefined"){
					alert("Please select the type of meeting you are entering");
					return false;
				}
				switch(m_type){
				case "rdoLesson":
					m_type = "Lesson";
					break;
				case "rdoTestimony":
					m_type = "Testimony";
					break;
				case "rdoSpecial":
					m_type = "Special";
					break;
				default:
					alert("You have to select a Meeting Type.");
					return false;
					break;
				}
				

				if($("#mtgTitle").val().length<3){
					alert("You need to provide a title longer than 2 characters");
					$("#mtgTitle").focus();
					return false;
				}
				// need to ensure that the donations text box is a monetary amount
				var m_donations = $("#mtgDonations").val();
				if ($("#mtgDonations").val().length<1){
					$("#mtgDonations").val("0");
				}else{
					fDonations = +$("#mtgDonations").val();
					if(isNaN(fDonations)){
						tmpString = "You need to enter a numeric value for Donations";
						$("#mtgDonations").val("");
					}
				}
				//get the Meeting ID if set
				var mtgID = <?php echo json_encode($MID);?>;
				if(mtgID == null){
					document.getElementById("mtgForm").action = "mtgAction.php?Action=New";
					
				}else{
					var updateAction = "mtgAction.php?Action=Update&ID=" + mtgID;
					document.getElementById("mtgForm").action = updateAction;
				}
				document.getElementById("mtgForm").submit();
			}
			function cancelMtgForm(){
				var dest = "meetings.php";
				window.location.href=dest;
			}

			function isValidDate(dateString){
				// First check for the pattern
			    if(!/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(dateString))
			        return false;

			    // Parse the date parts to integers
			    var parts = dateString.split("/");
			    var day = parseInt(parts[1], 10);
			    var month = parseInt(parts[0], 10);
			    var year = parseInt(parts[2], 10);

			    // Check the ranges of month and year
			    if(year < 1000 || year > 3000 || month == 0 || month > 12)
			        return false;

			    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

			    // Adjust for leap years
			    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
			        monthLength[1] = 29;

			    // Check the range of the day
			    return day > 0 && day <= monthLength[month - 1];
			}
			
			function importedValidation(){
				// if user is trying to delete system user "Removed User", then echo message that
				// action is not possible. 
				//--------------------------------------------------------------------------------
				var mDate = $("mtgDate").value;
				alert(mDate);
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
// 						window.location.href=newURL;
						$("#mtgForm").submit();
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
// 					window.location.href=dest;
// 					$("#mtgForm").submit();
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
<script src="js/farinspace/jquery.imgpreload.min.js"></script>
<script>
        	$(function() {
                $( "#mtgDate" ).datepicker();
                var meetingID = <?php echo json_encode($MID)?>;
                var meetingDate = <?php echo json_encode(date("m-d-Y", strtotime($mtgDate)));?>;
                var daDate = new Date();
                daDate = stringToDate(meetingDate,"mm-dd-yyyy","-");
                if(meetingID != null){
					$("#mtgDate").datepicker("setDate", daDate);
                }
             });
		</script>
<?php
/*
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 * start the form output
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 */
if ($edit) {
    echo "<form id=\"mtgForm\" action=\"mtgAction.php?Action=Update&MID=$mtgID\" method=\"post\">";
    echo "<h2 id=\"formTitle\" style=\"padding-top:25px; padding-bottom:0px;\">Meeting Entry</h2>";
} else {
    echo "<form id=\"mtgForm\" action=\"mtgAction.php?Action=New\" method=\"post\">";
    echo "<h2 id=\"formTitle\">New Meeting Entry</h2>";
}
?>
<table id="formTable">
	<tr>
		<td colspan="2">
			<table>
				<tr>
					<td>Meeting Date:&nbsp;<input style="font-size: 12pt;" "text" id="mtgDate"
						name="mtgDate" value="<?php echo $mtgDate ?>"></td>
				</tr>
				<tr>
					<td>
						<fieldset>
							<legend>Meeting Type</legend>
							<label for="rdoLesson">Lesson</label>
                                          <?php
                                        if ($mtgDetails[0]->MtgType == "Lesson") {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" checked=\"checked\">";
                                        } else {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoLesson\" value=\"Lesson\" >";
                                        }
                                        ?>                             
                                          <label for="rdoTestimony">Testimony</label>
                                          <?php
                                        if ($mtgDetails[0]->MtgType == "Testimony") {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" checked=\"checked\">";
                                        } else {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoTestimony\" value=\"Testimony\" >";
                                        }
                                        ?>
                                          <label for="rdoSpecial">Special</label>
                                          <?php
                                        if ($mtgDetails[0]->MtgType == "Special") {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" checked=\"checked\">";
                                        } else {
                                            echo "<input type=\"radio\" name=\"rdoMtgType\" id=\"rdoSpecial\" value=\"Special\" >";
                                        }
                                        ?>
                                        </fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
            	<table>
            		<tr>
            			<td><div class="mtgLabels" style="float:right">Title:&nbsp;</div></td>
            			<td><input id="mtgTitle" name="mtgTitle" size="40" style="font-size:14pt;" type="text" value='<?php echo $mtgDetails[0]->MtgTitle ?> '/></td>
        			</tr>
        			<tr>
        				<td><div class="mtgLabels" style="float:right">Host:</div></td>
        				<td><select id="mtgCoordinator" name="mtgCoordinator">
        				<?php 
            				foreach ($hoster as $availableHost) {
            				    if ($mtgFac == $availableHost[0]) {
            				        echo "<option value=\"$availableHost[0]\" SELECTED>$availableHost[1] $availableHost[2]</option>";
            				    } else {
            				        echo "<option value=\"$availableHost[0]\">$availableHost[1] $availableHost[2]</option>";
            				    }
            				}
            				// add the ghost to the bottom
            				if ($edit) {
            				    if ($mtgFac == $_gid) {
            				        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            				    } else {
            				        echo "<option value=\"$_gid\">$_glabel</option>";
            				    }
            				} else {
            				    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
            				}
        				?>
            			</select>
            			<a href="#" title="Individuals defined as Hosts in Admin features."><img style="width:15px;height:15px;" src="images/toolTipQM.png" alt="( &#x26A0; )"/></a>
            			</td>
        			</tr>
        			<tr>
        				<td><div class="mtgLabels" style="float:right">Attendance:</div></td>
        				<td><select id="mtgAttendance" name="mtgAttendance">
        					<?php 
                                for ($a = 0; $a < 201; $a ++) {
                                    if ($a == $mtgAttendance) {
                                        echo "<option value=\"" . $a . "\" selected>" . $a . "</option>";
                                    } else {
                                        echo "<option value=\"" . $a . "\">" . $a . "</option>";
                                    }
                                }
                            ?>
                    	</select>
                    	</td>
                   </tr>
    			
            	</table>
				<table>
				<?php
                    //==============================================
                    // now start optional meeting data
                    //==============================================
                    // ?????????????????????????????????????????????????????
                    //
                    //      DONATIONS
                    //
                    // ?????????????????????????????????????????????????????
                    if ($configSwitch["donations"] == "true") {?>
                    	<tr>
                    		<td><div class="mtgLabels" style="float:right">Donations:</div></td>
                    	<?php 
                    	if (sizeof($mtgDonations) > 0) {?>
                        	<td><input id="mtgDonations" name="mtgDonations" size="6" type="text" value="<?php 
                        	   //format the string to currency
                        	   setlocale(LC_MONETARY, "en_US");
                        	   echo money_format("%i",$mtgDonations) ?> "/>
                        <?php } else {?>
                            <td><input id="mtgDonations"  name="mtgDonations" size="6" type="text" placeholder="0"/>
                        <?php }?>
                  			</td>
                    	</tr>
                	<?php }?>
                
                
                <?php 
                    // ?????????????????????????????????????????????????????
                    //
                    //      WORSHIP
                    //
                    // ?????????????????????????????????????????????????????
                    if ($configSwitch["worship"] == "true") {?>
                        <tr><td><div class="mtgLabels" style="float:right"><?php echo $configValue["worship"] ?></div></td>
                        <td><select id="mtgWorship" name="mtgWorship">
                                <?php // ===========================================
                                // loop commits identifying worship volunteers
                                // ===========================================
//                             foreach ($serviceCommits as $commit) {
//                                 echo "<tr><td>$commit->ID - $commit->Category </td>";
//                                 echo "<td>$commit->FName $commit->LName</td></tr>";
//                             }
                            $cnt = 0;
                            foreach ($serviceCommits as $commit) {
                                if ($commit->Category == "worship") {
                                    $tmp = $commit->FName . " " . $commit->LName;
                                    $a = array($commit->ID, $tmp);
                                    
                                    $wPeeps[$cnt] = $a;
                                    $cnt++;
                                }
                            }
                            foreach($wPeeps as $wp){?>
                            	<option value="<?php echo $wp[0]?>"><?php echo $wp[1]?></option>
                            <?php }?>
                            </select>
                 
                    </td>
                    </tr>
                    </table>
                    
                    
    <?php exit;
                    // add the ghost AND non-person to the bottom
                    if ($edit) {
                        if ($mtgWorship == $_npwid) {
                            echo "<option value=\"$_npwid\" SELECTED>$_npwlabel</option>";
                        } else {
                            echo "<option value=\"$_npwid\">$_npwlabel</option>";
                        }
                        if ($mtgWorship == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        // echo "<option value=\"$_npwid\" SELECTED>$_npwlabel</option>";
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Worship team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a></td></tr>";
                }
                if ($configSwitch["av"] == "true") {
                    // ================================
                    // AV IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $configValue["av"] . ":</div></td>";
                    echo "<td><select id=\"mtgAV\" name=\"mtgAV\">";
                    // ===========================================
                    // loop commits identifying AV volunteers
                    // ===========================================
                    $dpeeps = null;
                    foreach ($serviceCommits as $commit) {
                        if ($commit->Category == "av") {
                            $tmp = $commit->FName . " " . $commit->LName;
                            $dpeeps = array(
                                $commit->ID,
                                $tmp
                            );
                        }
                    }
                    
                    foreach ($dPeeps as $peep) {
                        if ($mtgAudioVisualFac == $peep[0]) {
                            echo "<option value=\"$peep[0]\" SELECTED>$peep[1]</option>";
                        } else {
                            echo "<option value=\"$peep[0]\">$peep[1]</option>";
                        }
                    }
                    
                    $option = getPeepsForService("av");
                    foreach ($option as $id => $name) {
                        if ($mtgAudioVisualFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgAudioVisualFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\"  title=\"People on A/V team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["setup"] == "true") {
                    // ================================
                    // setup IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("setup") . ":</div></td>";
                    echo "<td><select id=\"mtgSetup\" name=\"mtgSetup\">";
                    $option = getPeepsForService("setup");
                    foreach ($option as $id => $name) {
                        if ($mtgSetupFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgSetupFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on setup team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["transportation"] == "true") {
                    // ================================
                    // transportation IS TRUE = DISPLAY OPTION
                    // ================================
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("transportation") . ":</div></td>";
                    echo "<td><select id=\"mtgTransportation\" name=\"mtgTransportation\">";
                    $option = getPeepsForService("transportation");
                    foreach ($option as $id => $name) {
                        if ($mtgTransportationFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgTransportationFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on transportation team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["greeter"] == "true") {
                    // ================================
                    // GREETER IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("greeter") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgGreeter1\" name=\"mtgGreeter1\">";
                    $option = getPeepsForService("greeter");
                    foreach ($option as $id => $name) {
                        if ($mtgGreeter1Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgGreeter1Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<select id=\"mtgGreeter2\" name=\"mtgGreeter2\">";
                    foreach ($option as $id => $name) {
                        if ($mtgGreeter2Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgGreeter2Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Greeting team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["resources"] == "true") {
                    // ================================
                    // resources IS TRUE = DISPLAY OPTION
                    // ================================
                    // echo "<tr><td width=\"150px\" align=\"right\"><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("resources") . ":</div></td>";
                    echo "<td><select id=\"mtgResources\" name=\"mtgResources\">";
                    $option = getPeepsForService("resources");
                    foreach ($option as $id => $name) {
                        if ($mtgResourcesFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgResourcesFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on resource team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                } // this ends the if statement for RESOURCES
                  
                // echo "</td></tr>";
                echo "</table>";
                // END OF TABLE 1
                
                // BEGINNING of TABLE 2 (DINNER)
                if ($configSwitch["meal"] == "true") {
                    // the configuration is to manage/track the meal
                    // echo "<table><tr><td width=\"100px;\">&nbsp;</td><td>";
                    echo "<table><tr><td>";
                    echo "<fieldset><legend>Meal</legend>";
                    echo "<table>";
                    if ($configSwitch["menu"] == "true") {
                        echo "<tr><td colspan=4><div class=\"mtgLabels\" style=\"float:left\">Menu:&nbsp;";
                        echo "<input id=\"mtgMenu\" name=\"mtgMenu\" size=\"32\" maxlength=\"30\" style=\"font-size:14pt;\" type=\"text\" value=\"" . $mtgMenu . "\"/></div></td></tr>";
                    }
                    echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Served:&nbsp;</div></td>";
                    echo "<td><select id=\"mtgMealCnt\" name=\"mtgMealCnt\">";
                    for ($a = 0; $a < 201; $a ++) {
                        if ($a == $mtgMealCnt) {
                            echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
                        } else {
                            echo "<option value=\"" . $a . "\">" . $a . "</option>";
                        }
                    }
                    echo "</select>";
                    echo "</td>";
                    if ($configSwitch["mealFac"] == "true") {
                        echo "<td>" . $aosConfig->getDisplayString("mealFac") . "&nbsp;<select id=\"mtgMealFac\" name=\"mtgMealFac\">";
                        $option = getPeepsForService("mealFac");
                        foreach ($option as $id => $name) {
                            if ($mtgMealFac == $id) {
                                echo "<option value=\"$id\" SELECTED>$name</option>";
                            } else {
                                echo "<option value=\"$id\">$name</option>";
                            }
                        }
                        // add the ghost to the bottom
                        if ($edit) {
                            if ($mtgMealFac == $_gid) {
                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            } else {
                                echo "<option value=\"$_gid\">$_glabel</option>";
                            }
                        } else {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        }
                        echo "</select>";
                    } else {
                        echo "<td>";
                    }
                    echo "</td></tr></table>";
                    echo "</fieldset>";
                    echo "</td></tr></table>";
                } // END OF TABLE 2 (DINNER)
                  
                // BEGINNING TABLE 3
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                if ($configSwitch["reader"] == "true") {
                    // ================================
                    // READERS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("reader") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgReader1\" name=\"mtgReader1\">";
                    $option = getPeepsForService("reader");
                    foreach ($option as $id => $name) {
                        if ($mtgReader1Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgReader1Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<select id=\"mtgReader2\" name=\"mtgReader2\">";
                    foreach ($option as $id => $name) {
                        if ($mtgReader2Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgReader2Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Reader team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["announcements"] == "true") {
                    // ================================
                    // ANNOUNCEMENTS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("announcements") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgAnnouncements\" name=\"mtgAnnouncements\">";
                    $option = getPeepsForService("announcements");
                    foreach ($option as $id => $name) {
                        if ($mtgAnnouncementsFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgAnnouncementsFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Announcement team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($mtgType == "Lesson") {
                    if ($configSwitch["teaching"] == "true") {
                        // ================================
                        // TEACHING IS TRUE = DISPLAY OPTION
                        // ======================================
                        echo "<tr><td>";
                        echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("teaching") . ":</div></td>";
                        echo "<td>";
                        echo "<select id=\"mtgTeaching\" name=\"mtgTeaching\">";
                        $option = getPeepsForService("teaching");
                        foreach ($option as $id => $name) {
                            if ($mtgTeachingFac == $id) {
                                echo "<option value=\"$id\" SELECTED>$name</option>";
                            } else {
                                echo "<option value=\"$id\">$name</option>";
                            }
                        }
                        // add the ghost to the bottom
                        if ($edit) {
                            if ($mtgTeachingFac == $_gid) {
                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            } else {
                                echo "<option value=\"$_gid\">$_glabel</option>";
                            }
                        } else {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        }
                        echo "</select>";
                        echo "<a href=\"#\" title=\"People on Teaching team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                        echo "</td></tr>";
                    }
                }
                if ($configSwitch["chips"] == "true") {
                    // ================================
                    // CHIPS IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("chips") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgChips1\" name=\"mtgChips1\">";
                    $option = getPeepsForService("chips");
                    foreach ($option as $id => $name) {
                        if ($mtgChips1Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgChips1Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<select id=\"mtgChips2\" name=\"mtgChips2\">";
                    foreach ($option as $id => $name) {
                        if ($mtgChips2Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgChips2Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Chips team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["newcomers"] == "true") {
                    // ================================
                    // NEWCOMERS (101) IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("newcomers") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgNewcomers1\" name=\"mtgNewcomers1\">";
                    $option = getPeepsForService("newcomers");
                    foreach ($option as $id => $name) {
                        if ($mtgNewcomers1Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgNewcomers1Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<select id=\"mtgNewcomers2\" name=\"mtgNewcomers2\">";
                    foreach ($option as $id => $name) {
                        if ($mtgNewcomers2Fac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgNewcomers2Fac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Newcomers (101) team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["serenity"] == "true") {
                    // ================================
                    // SERENITY IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("serenity") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgSerenity\" name=\"mtgSerenity\">";
                    $option = getPeepsForService("serenity");
                    foreach ($option as $id => $name) {
                        if ($mtgSerenityFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgSerenityFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Serenity Prayer team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                
                echo "</table>";
                
                // BEGINNING of TABLE 4 (GENERATIONS)
                if ($configSwitch["youth"] == "true" || $configSwitch["children"] == "true" || $configSwitch["nursery"] == "true") {
                    // if any of the generations is enabled, display the table
                    
                    echo "<table><tr><td>";
                    echo "<fieldset><legend>Generations</legend>";
                    echo "<table>";
                    if ($configSwitch["nursery"] == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Nursery:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgNursery\" name=\"mtgNursery\">";
                        for ($a = 0; $a < 201; $a ++) {
                            if ($a == $mtgNurseryCnt) {
                                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
                            } else {
                                echo "<option value=\"" . $a . "\">" . $a . "</option>";
                            }
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($configSwitch["nurseryFac"] == "true") {
                            echo "<td>" . $configSwitch["nurseryFac"] . "</td><td><select id=\"mtgNurseryFac\" name=\"mtgNurseryFac\">";
                            $option = getPeepsForService("nurseryFac");
                            foreach ($option as $id => $name) {
                                if ($mtgNurseryFac == $id) {
                                    echo "<option value=\"$id\" SELECTED>$name</option>";
                                } else {
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            }
                            // add the ghost to the bottom
                            if ($edit) {
                                if ($mtgNurseryFac == $_gid) {
                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                } else {
                                    echo "<option value=\"$_gid\">$_glabel</option>";
                                }
                            } else {
                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            }
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    if ($configSwitch["children"] == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Children:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgChildren\" name=\"mtgChildren\">";
                        for ($a = 0; $a < 201; $a ++) {
                            if ($a == $mtgChildrenCnt) {
                                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
                            } else {
                                echo "<option value=\"" . $a . "\">" . $a . "</option>";
                            }
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($configSwitch["childrenFac"] == "true") {
                            echo "<td>" . $aosConfig->getDisplayString("childrenFac") . "</td><td><select id=\"mtgChildrenFac\" name=\"mtgChildrenFac\">";
                            $option = getPeepsForService("childrenFac");
                            foreach ($option as $id => $name) {
                                if ($mtgChildrenFac == $id) {
                                    echo "<option value=\"$id\" SELECTED>$name</option>";
                                } else {
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            }
                            // add the ghost to the bottom
                            if ($edit) {
                                if ($mtgChildrenFac == $_gid) {
                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                } else {
                                    echo "<option value=\"$_gid\">$_glabel</option>";
                                }
                            } else {
                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            }
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    if ($configSwitch["youth"] == "true") {
                        echo "<tr><td><div class=\"mtgLabels\" style=\"float:right\">Youth:&nbsp;</div></td>";
                        echo "<td><select id=\"mtgYouth\" name=\"mtgYouth\">";
                        for ($a = 0; $a < 201; $a ++) {
                            if ($a == $mtgYouthCnt) {
                                echo "<option value=\"" . $a . "\" SELECTED>" . $a . "</option>";
                            } else {
                                echo "<option value=\"" . $a . "\">" . $a . "</option>";
                            }
                        }
                        echo "</select>";
                        echo "</td>";
                        if ($configSwitch["youthFac"] == "true") {
                            echo "<td>" . $aosConfig->getDisplayString("youthFac") . "</td><td><select id=\"mtgYouthFac\" name=\"mtgYouthFac\">";
                            $option = getPeepsForService("youthFac");
                            foreach ($option as $id => $name) {
                                if ($mtgYouthFac == $id) {
                                    echo "<option value=\"$id\" SELECTED>$name</option>";
                                } else {
                                    echo "<option value=\"$id\">$name</option>";
                                }
                            }
                            // add the ghost to the bottom
                            if ($edit) {
                                if ($mtgYouthFac == $_gid) {
                                    echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                                } else {
                                    echo "<option value=\"$_gid\">$_glabel</option>";
                                }
                            } else {
                                echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                            }
                            echo "</select></td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</fieldset>";
                    echo "</td><tr></table>";
                } // END OF TABLE 4 (GENERATIONS)
                  // BEGINNING TABLE 5
                echo "<table>";
                echo "<tr>";
                echo "<td>";
                if ($configSwitch["cafe"] == "true") {
                    // ================================
                    // CAFE IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("cafe") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgCafe\" name=\"mtgCafe\">";
                    $option = getPeepsForService("cafe");
                    foreach ($option as $id => $name) {
                        if ($mtgCafeFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgCafeFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Cafe team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                if ($configSwitch["teardown"] == "true") {
                    // ================================
                    // TEARDOWN IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("teardown") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgTearDown\" name=\"mtgTearDown\">";
                    $option = getPeepsForService("teardown");
                    foreach ($option as $id => $name) {
                        if ($mtgTearDownFac == $id) {
                            echo "<option value=\"$id\" SELECTED>$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgTearDownFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Tear-Down team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                
                if ($configSwitch["security"] == "true") {
                    // ================================
                    // SECURITY IS TRUE = DISPLAY OPTION
                    // ======================================
                    echo "<tr><td>";
                    echo "<div class=\"mtgLabels\" style=\"float:right\">" . $aosConfig->getDisplayString("security") . ":</div></td>";
                    echo "<td>";
                    echo "<select id=\"mtgSecurity\" name=\"mtgSecurity\">";
                    $option = getPeepsForService("security");
                    foreach ($option as $id => $name) {
                        if ($mtgSecurityFac == $id) {
                            echo "<option value=\"$id\">$name</option>";
                        } else {
                            echo "<option value=\"$id\">$name</option>";
                        }
                    }
                    // add the ghost to the bottom
                    if ($edit) {
                        if ($mtgSecurityFac == $_gid) {
                            echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                        } else {
                            echo "<option value=\"$_gid\">$_glabel</option>";
                        }
                    } else {
                        echo "<option value=\"$_gid\" SELECTED>$_glabel</option>";
                    }
                    echo "</select>";
                    echo "<a href=\"#\" title=\"People on Security team\"><img style=\"width:15px;height:15px;\" src=\"images/toolTipQM.png\" alt=\"( &#x26A0; )\"/></a>";
                    echo "</td></tr>";
                }
                echo "</table>";
                ?>
							</td>
	</tr>
	<tr>
		<td colspan="2">
			<fieldset>
				<legend>Notes and Comments</legend>
                              	<?php
                            if (sizeof($mtgNotes) > 0) {
                                echo "<textarea id=\"mtgNotes\" name=\"mtgNotes\" rows=\"5\" cols=\"80\">" . $mtgNotes . "</textarea>";
                            } else {
                                echo "<textarea id=\"mtgNotes\" name=\"mtgNotes\"  rows=\"5\" cols=\"80\"></textarea>";
                            }
                            ?>
                        	</fieldset>
		</td>
	</tr>
	<tr>
		<td colspan="2"><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<?php
    if ($_SESSION["adminFlag"] == "1") {
        if ($MID > 0) {
            // display update button, otherwise insert
            echo "<button style=\"font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);\" type=\"button\" onclick=\"validateMtgForm()\">UPDATE</button>";
        } else {
            echo "<button style=\"font-family:tahoma; font-size:12pt; color:white; background:green; padding: 5px 15px 5px 15px; border-radius:10px;background-image: linear-gradient(to bottom right, #006600, #33cc33);\" type=\"button\" onclick=\"validateMtgForm()\">INSERT</button>";
        }
    }
    ?>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<button
				style="font-family: tahoma; font-size: 12pt; color: white; background: green; padding: 5px 15px 5px 15px; border-radius: 10px; background-image: linear-gradient(to bottom right, #cc0000, #ff3300);"
				type="button" onclick="cancelMtgForm()">CANCEL</button> <br />
		<br /></td>
	</tr>

</table>
<!-- ########################### -->
<!-- STARTING OPEN SHARE SECTION -->
<!-- ########################### -->
<?php

if (($MID > 0) && ($_SESSION["adminFlag"] == "1")) {
    // don't show groups list if it is a new entry
    ?>
<fieldset>
	<legend>Open Share Groups</legend>
	<div id="groupInformationArea"></div>
</fieldset>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script>
    			$(document).ready(function(){
    				
    				var theUrl = 'http://recovery.help/meeter/api/json/groups/getGroupsForMtgForm.php?client=UAT&MID='+<?php echo $MID?>;
    				var output = '';
        			$.ajax({
        				url: theUrl,
        				dataType: 'json',
        				type: 'get',
        				cache: false,
        				success: function(data) {
            				output += '<table border=1><tr>';
            				<?php if($_SESSION["adminFlag"] == "1"){?>
                				output += '<th></th>';
            				<?php }?>
            				output += '<th>Title</th><th>Facilitator</th><th>Co-Facilitator</th><th>Location</th><th>#</th>';
            				<?php if($_SESSION["adminFlag"] == "1"){?>
                				output += '<th></th>';
            				<?php }?>
            				output += '</tr>';
        					$(data.groups).each(function(index, value){
    //     							console.log(value.Title);
//         							output += '<tr><td>'+value.Title+'</td></tr>';
									output += '<tr>';
									<?php if($_SESSION["adminFlag"] == "1"){?>
										output += '<td valign=\'center\' style=\'padding: 5px\'>';
										var editLink = 'grpForm.php?GID='+value.ID+'&MID='+<?php echo $MID; ?>+'&Action=Edit';
										output += '<a href=\''+editLink+'\'><img src=\'images/btnEdit.gif\' alt=\"(edit)\"></img></a></td>';
									<?php }?>
									output += '<td style=\'padding: 5px\'>'+value.Title+'</td>';
									output += '<td style=\'padding: 10px; text-align: center;\'>'+value.FacFirstName+'</td>';
									output += '<td style=\'padding: 10px; text-align: center;\'>'+value.CoFirstName+'</td>';
									output += '<td>'+value.Location+'</td>';
									output += '<td align=\'center\' style=\'left-padding: 5px; right-padding: 5px;\'>'+value.Attendance+'</td>';
									<?php if($_SESSION["adminFlag"] == "1"){?>
    									editLink = 'mtgAction.php?Action=DeleteGroup&MID='+<?php echo $MID;?>+'&GID='+value.ID;
    									output += '<td width=15px; alight=\'right\'><a href=\''+editLink+'\'><img src=\'images/minusbutton.gif\' alt=\"(remove)\"></img></a></td>';
									<?php }?>
									output += '</tr>';
	
        					});
        					output += '</table>';
        					$('#groupInformationArea').append(output);
    					},
    					error : function(xhr, ajaxOptions, thrownError){
    						var createCall = 'mtgAction.php?Action=PreLoadGroups&MID='+<?php echo $MID;?>
    						
							output = '<a href="'+createCall+'"><img src="images/btnGetLastWeek.png" alt=\"(previous)\"></img></a>';
				           		$('#groupInformationArea').append(output);
    			       	}
    					
        			});
    			});
				</script>
<?php } ?>
<!-- ########################### -->
<!--  ENDING OPEN SHARE SECTION  -->
<!-- ########################### -->
</form>