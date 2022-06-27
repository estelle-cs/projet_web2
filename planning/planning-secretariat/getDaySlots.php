<?php
include("../bdd.php");

$docName = $_COOKIE["docName"];
$day = $_COOKIE["day"];

$solutions = array();

$req = "SELECT id FROM docteur WHERE name LIKE '$docName'";
$Ores = $Bdd->query($req);   

if($docId = $Ores->fetch())
{
    $array = get_object_vars($docId);
    $req2 = "SELECT * FROM rdv WHERE docteurId LIKE '$array[id]' AND date LIKE '$day'";
    $Ores2 = $Bdd->query($req2);   

    while($usr2 = $Ores2->fetch()){
        $solutions[] =  $usr2;
    }

    echo json_encode($solutions);
}

?>