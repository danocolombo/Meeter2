<?php
include '../includes/sec.inc.php';

$em = 'dude@mail.com';
$linen = fold($em, "UAT");

echo "------------------------\n";
echo $linen;
echo "\n=============================\n";

$pile = ufold($linen, "UAT");

echo "********************************\n";
echo $pile;
echo "********************************\n";


?>