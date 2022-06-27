<?php
include("../bdd.php");

/*$req = "SELECT docRef FROM docteur WHERE name LIKE 'a'";
$Ores = $Bdd->query($req);   
if($usr = $Ores->fetch())
{
    echo json_encode($usr);
}*/

echo json_encode($_COOKIE["day"]);

?>