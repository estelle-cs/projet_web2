<?php
include("../bdd.php");

$req = "SELECT docRef FROM patient WHERE name LIKE 'a'";
$Ores = $Bdd->query($req);   
if($usr = $Ores->fetch())
{
    $req2 = "SELECT name FROM docteur WHERE id LIKE '$usr->docRef' ";
    $Ores2 = $Bdd->query($req2);   
    $usr2 = $Ores2->fetch();
    echo json_encode($usr2);
}

?>