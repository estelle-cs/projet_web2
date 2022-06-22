<?php

    $bdUser = "root"; // Utilisateur de la base de données
    $bdPasswd = ""; // Son mot de passe
    $dbname = "mesdocs"; // nom de la base de données
    $host= "localhost"; // Hôte
    try
    {
        $Bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $bdUser, $bdPasswd);// SE CONNECTER A LA BDD
        $Bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // METTRE LE MODE OBJET PAR DEFAUT
    }
    catch (PDOException $e)
    {
        echo ("Erreur : impossible de se connecter à la bdd");
    }
    
?>