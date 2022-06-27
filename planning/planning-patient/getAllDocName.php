<?php
include("../bdd.php");

$solutions = array();

$req = "SELECT name FROM docteur";;
$Ores = $Bdd->query($req);   


while($usr = $Ores->fetch()){
    $solutions[] =  $usr;
}
echo json_encode($solutions);
?>