<?php
include("/bdd.php");


$req = "SELECT name FROM docteur";;
$Ores = $Bdd->query($req);   
$usr = $Ores->fetch();
echo json_encode($usr);
?>