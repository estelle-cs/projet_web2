<?php
    session_start();
    include("bdd.php");

	if(!isset($_SESSION['id'])){
		echo "Vous n'êtes pas connecté! Redirection vers la page de connection...";
		return header('Location: connexion-patient.php');
	}
	try {
		$Bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $bdUser, $bdPasswd); // SE CONNECTER A LA BDD
		$Bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // METTRE LE MODE OBJET PAR DEFAUT
	} catch (PDOException $e) {
		echo ("Erreur : impossible de se connecter à la bdd");
	}
		if ($_SESSION['userType']==1){
			return header('Location: moncompte-secretaire.php');
		}
		if($_SESSION['userType']==3){
			return header('Location: moncompte-patient.php');
		}

    if(isset($_POST['oldmdp'])){
        $req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
        $ORes = $Bdd->query($req);
        while($usr = $ORes->fetch())
        {
            $mdp_bdd=$usr->mdp;
        }
        if(md5($_POST['oldmdp'])==$mdp_bdd){
            if(isset($_POST['newmdp1'])||isset($_POST['newmdp2'])){
                        if($_POST['newmdp1']!=$_POST['newmdp2']){
                            echo '<script language="Javascript"> alert ("Les 2 nouveaux mots de passe ne sont pas identiques" ) </script>';
                            
                        }else{
                            $newmdp=md5($_POST["newmdp1"]);
                            //Changer mdp
                            $reqChangePass = "UPDATE docteur SET mdp='$newmdp' WHERE id='".$_SESSION["id"]."'";
                            if($OresChangePass = $Bdd->query($reqChangePass)){
                                echo '<script language="Javascript"> alert ("Le mot de passe a bien été changé!") </script>';
                            }
                            else{
                                echo '<script language="Javascript"> alert ("Erreur SQL lors du changement de mot de passe") </script>';
                            }
                            
                        }
                    }
            if(isset($_POST["email"])){
                $email=$_POST["email"];
                $req="UPDATE docteur SET email='$email' WHERE id='".$_SESSION["id"]."'";
                $Ores = $Bdd->query($req);
            }
            if(isset($_POST["name"])){
                $name=$_POST["name"];
                $req="UPDATE docteur SET name='$name' WHERE id='".$_SESSION["id"]."'";
                $Ores = $Bdd->query($req);
            }
            if(isset($_POST["surname"])){
                $surname=$_POST["surname"];
                $req="UPDATE docteur SET surname='$surname' WHERE id='".$_SESSION["id"]."'";
                $Ores = $Bdd->query($req);
            }
            if(isset($_POST["tel"])){
                $tel=$_POST["tel"];
                $req="UPDATE docteur SET tel='$tel' WHERE id='".$_SESSION["id"]."'";
                $Ores = $Bdd->query($req);
            }
        }else{
            echo '<script language="Javascript"> alert ("L\'ancien mot de passe est incorrect") </script>';
        }
        

    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
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
<?php 

$req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
$ORes = $Bdd->query($req);
while($users = $ORes->fetch())
{
    echo "<h1>Bonjour $users->name $users->surname!</h1>";
}

?>
<a href="javascript:alert('Svp rediriger vers le calendrier du docteur!')" class="primary">Voir mon calendrier</a>
<a href="logout.php" class="primary switchuser">Se déconnecter</a>
<h3><?php 
$req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
$ORes = $Bdd->query($req);
while($users = $ORes->fetch())
{
    echo "<h3>Adresse e-mail : $users->email</h3>";
}


?></h3>

<h2 class="textsep">Modifier mes informations</h2>
<form action="" method="POST">
<input required name="name" type="text" placeholder="Nom" value="<?php
        $req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
        $ORes = $Bdd->query($req);
        while($users = $ORes->fetch())
        {
            echo "$users->name";
        }
    ?>">
    <input required name="surname" type="text" placeholder="Prénom" value="<?php
        $req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
        $ORes = $Bdd->query($req);
        while($users = $ORes->fetch())
        {
            echo "$users->surname";
        }
    ?>">
    <input required name="email" type="email" placeholder="Adresse e-mail" value="<?php
        $req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
        $ORes = $Bdd->query($req);
        while($users = $ORes->fetch())
        {
            echo "$users->email";
        }
    ?>">
        <input required name="tel" type="tel" placeholder="Numéro de téléphone" value="<?php
        $req = "SELECT * FROM docteur WHERE id=".$_SESSION['id'].";";
        $ORes = $Bdd->query($req);
        while($users = $ORes->fetch())
        {
            echo "$users->tel";
        }
    ?>">
        <input required name="oldmdp" type="password" placeholder="Mot de passe actuel">
        <input name="newmdp1" type="password" placeholder="Nouveau mot de passe (facultatif)">
        <input name="newmdp2" type="password" placeholder="Retaper le nouveau mot de passe">
        <input type="submit">
</form>
</div>
</body>
</html>