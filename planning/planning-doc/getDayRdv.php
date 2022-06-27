<?php
include("../bdd.php");

$selectedDay = $_COOKIE["day"];
$usrId = $_COOKIE["id"];
$solutions = array();
$req = "SELECT * FROM rdv WHERE date LIKE '$selectedDay' AND docteurId LIKE '$usrId'";
$Ores = $Bdd->query($req);   
while($usr = $Ores->fetch())
{
    $solutions[] =  $usr;
}

echo json_encode($solutions);

?>