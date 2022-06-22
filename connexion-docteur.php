<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include("bdd.php");
if(isset($_POST["email"]))
    { 
      //Vérification de l'e-mail saisie
      $email = $_POST["email"];
      $req = "SELECT * FROM docteur WHERE Email LIKE '$email'";;
      $Ores = $Bdd->query($req);   
      if($usr = $Ores->fetch())
      {
        // L'email saisie est inscrit en BDD et correspond bien à un user
        if(isset($_POST["mdp"]))
        {
          //Vérifier si le mot de passe saisie correspond bien au mot de passe de l'user
          $req1 = "SELECT * FROM docteur WHERE email LIKE '$email' AND mdp LIKE '".md5($_POST["mdp"])."';";;
          $Ores1 = $Bdd->query($req1);
		  
          if($usr = $Ores1->fetch())
          {
            // Le mdp saisie est correct et correspond bien à l'email de l'user
			$_SESSION['id']=$usr->id;
            echo '<script language="Javascript"> alert ("Connexion réussie! (A rediriger vers la page mais elle existe pas encore)" ) </script>';

            exit;        
          }
          else
          {
            // Le mdp saisi est incorrect et ne correspond pas à l'email de l'user
            echo '<script language="Javascript"> alert ("Vous êtes bien enregistré mais le mot de passe est incorrect !" ) </script>';
          }      
        }
      }
      else
      {
        // L'email saisie n'est pas inscrit en BDD et correspond à aucun user
        echo '<script language="Javascript"> alert ("L\'identifiant saisi est incorrect ! Veuillez réessayer !" ) </script>';
      }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
</head>
<body>
    <div class="contbox">
        <form action="" method="POST">
            <input type="email" placeholder="email" name="email" required><br>
            <input type="password" placeholder="Mot de passe" name="mdp" required><br>
            <input type="submit">
        </form>
    </div>
    <p>Pour s'inscrire, demandez au personnel.</p><br>
    <a href="connexion-patient.php">Vous êtes un patient?</a><br>
    <a href="connexion-secretaire.php">Vous êtes un secrétaire?</a><br>

</body>
</html>