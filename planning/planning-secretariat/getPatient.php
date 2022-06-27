<?php
include("../bdd.php");


$patientId = $_COOKIE["patientId"];
$req = "SELECT * FROM patient WHERE id LIKE '$patientId'";
$Ores = $Bdd->query($req);   
if($usr = $Ores->fetch())
{
    echo json_encode($usr);
}

?>