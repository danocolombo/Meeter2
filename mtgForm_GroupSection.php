<?php
// $MID = $_GET["MID"];
echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
if($MID>0){
    echo "<br/>WE HAVE A MEETING ID!!<br/>";
}else{
    echo "no meeting ID";
}