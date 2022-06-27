<?php
    // CHANGER TOUTES LES BALISES "ALERT"
    session_start();
    //Inclusion de la Base de donnée :
    include("bdd.php");
    if(isset($_POST["email"]))
    { 
        if($_POST["mdp"]!=$_POST["mdp2"]){
            echo '<script language="Javascript"> alert ("Les 2 mots de passe ne sont pas identiques!" ) </script>';
        }
      //Vérification de l'e-mail saisie
      $email = $_POST["email"];
      $req = "SELECT * FROM patient WHERE email LIKE '".$_POST['email']."';";
      $Ores = $Bdd->query($req);   
      if($usr = $Ores->fetch())
      {
        // L'email saisie est inscrit en BDD et correspond bien à un user
        echo '<script language="Javascript"> alert ("Cette adresse e-mail est déjà enregistrée!" ) </script>';
      }
      else
      {

        // L'email saisie n'est pas inscrit en BDD et correspond à aucun user
        if(isset($_POST["email"])&& isset($_POST["name"])&& isset($_POST["surname"])&& isset($_POST["birthDate"])&& isset($_POST["tel"])&& isset($_POST["numSecu"])&& isset($_POST["genreBiologique"]))
        {
				//Vérifier si le mot de passe saisie correspond bien au mot de passe de l'user
          //Changer en md5
          $req1 = "INSERT INTO patient(userType, name, surname, birthDate, tel, email, numSecu, genreBiologique,mdp) VALUES (3,'".$_POST["name"]."','".$_POST["surname"]."','".$_POST["birthDate"]."','".$_POST["tel"]."','".$_POST["email"]."','".$_POST["numSecu"]."','".$_POST["genreBiologique"]."','".md5($_POST["mdp"])."')";
          if($Bdd->query($req1)==TRUE){
			$_SESSION['id']=$usr->id;
			echo '<script language="Javascript"> alert ("Le compte a été créé! Veuillez vous connecter au compte." ) </script>';
            header('Location: connexion-patient.php');
            exit;    
		  }else{
			echo '<script language="Javascript"> alert ("Erreur BDD '.$req1.$Bdd->error.'") </script>';
		  }
			
          
		  
            // Le mdp saisie est correct et correspond bien à l'email de l'user
			    
          
                
        }else{
			echo '<script language="Javascript"> alert ("Des champs obligatoires ne sont pas remplis" ) </script>';
		}
      }
    }
    if(isset($_SESSION["id"])){
      switch ($_SESSION["userType"]){
        case 1:
          return header('Location: moncompte-docteur.php');
          break;
        case 2:
          return header('Location: moncompte-secretaire.php');
          break;
        case 3:
          return header('Location: moncompte-patient.php');
          break;
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Inscription</title>
	<meta charset="UTF-8">
  <link rel="stylesheet" href="page-compte.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@100&display=swap" rel="stylesheet"> 
</head>
<body>
<header class="navbar">
      <h1>MesDocs</h1>
      <div></div>
      <a class="primary switchuser" href="<?php
      if(!isset($_SESSION['id'])){
        echo "connexion-patient.php";
        
      }else{
        echo "moncompte-patient.php";
      }
      ?>">
      <?php
      if(!isset($_SESSION['id'])){
        echo "Se connecter";
        
      }else{
        echo "Mon compte";
      }
      ?>
    </a>
      

</header>
<div class="contbox">
      <h1>Créez votre compte patient</h1>
        <form action="" method="POST">
            <input type="email" placeholder="email" name="email" required><br>
            <input type="text" name="name" placeholder="Nom" required><br>
            <input type="text" name="surname" placeholder="Prénom" required><br>
            <input type="date" name="birthDate" placeholder="Date de naissance" required><br>
            <input type="tel" name="tel" placeholder="N° de téléphone" required><br>
            <input type="text" placeholder="Numéro de sécurité sociale" name="numSecu" required><br>
            <div class="radiocont">
              <input type="radio" name="genreBiologique" value="0" id="homme" required>
              <label for="homme">Homme</label>
            </div>
            <div class="radiocont">
              <input type="radio" name="genreBiologique" value="1" id="homme" required>
              <label for="homme">Femme</label>
            </div>
            <input type="password" name="mdp" placeholder="Mot de passe">
            <input type="password" name="mdp2" placeholder="Retaper le mot de passe"><br>
            <input type="submit"><br>
        </form>
        <div class="contbox">
        <a href="connexion-patient.php" class="primary switchuser">Retour à la page connexion</a>
        </div>
    </div>
</body>
</html>