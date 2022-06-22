<?php 

    function getPDO()
    {
        $bdUser = "root"; // Utilisateur de la base de données
        $bdPasswd = ""; // Son mot de passe
        $dbname = "plop_pizza"; // nom de la base de données
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
        return $Bdd;
    }


?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/annexes.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;700&display=swap" rel="stylesheet">
    <title>Mes rendez-vous</title>
</head>
<body>

    <div class="part">
    <h2>Rendez-vous à venir</h2>

    </div>
    
</body>
</html>