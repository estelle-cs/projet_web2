<?php
    include("bdd.php");
    session_start();
    $req = "SELECT * FROM patient";
    $ORes =  $Bdd->query($req);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiche patient</title>
    <link rel="stylesheet" href="css/annexes.css">
</head>
<body>

    <?php 
    while($all_patient = $ORes->fetch()){
        $name_all = $all_patient->name;
        $id = $all_patient->id;
        echo "$name_all <br>";
        ?>
        <button onclick="open_modal(<?php echo $id ?>)">OUVRIR MODAL</button><br>
        <div id="modal_<?php echo $id ?>" class="modal_close">
            <?php
                $req_patient = "SELECT * FROM patient WHERE patient.id = '$id'";
                $ORes_patient = $Bdd->query($req_patient);

                $patient = $ORes_patient->fetch();
                $name = $patient->name;
                $surname = $patient->surname;
                $birthDate = $patient->birthDate;
                $tel = $patient->tel;
                $email = $patient->email;
                $numSecu = $patient->numSecu;
                $docRef = $patient->docRef;

                $req_docteur ="SELECT * FROM docteur WHERE docteur.id = '$docRef'";
                $ORes_docteur = $Bdd->query($req_docteur);
                $docteur = $ORes_docteur->fetch();
                $name_docteur = $docteur->name;
                $surname_docteur = $docteur->surname;
                $spe_docteur = $docteur->spe;
                $tel_docteur = $docteur->tel;
                $email_docteur = $docteur->email;

            ?>
            <h1 id="h1_fichePatient">FICHE PATIENT</h1>
            <div class="part_inModal">
                <h2 class="h2_fichePatient">Informations sur le patient</h2>
                <span>Nom : <?php echo "$name" ?></span><br>
                <span>Prénom : <?php echo "$surname" ?></span><br>
                <span>Numéro de sécu : <?php echo "$numSecu" ?></span><br>
            </div>
            <div class="part_inModal">
                <h2 class="h2_fichePatient">Coordonnées du patient</h2>
                <span>Numéro de téléphone : <?php echo "$tel" ?></span><br>
                <span>E-mail : <?php echo "$email" ?></span><br>
            </div>
            <div class="part_inModal">
                <h2 class="h2_fichePatient">Médecin référant du patient</h2>
                <span>Nom : <?php echo "$name_docteur" ?></span><br>
                <span>Prénom : <?php echo "$surname_docteur" ?></span><br>
                <span>Spécialité : <?php echo "$spe_docteur" ?></span><br>
                <span>Numéro de téléphone : <?php echo "$tel_docteur" ?></span><br>
                <span>E-mail : <?php echo "$email_docteur" ?></span><br>
            </div>

            <button id="btn_close_modal" onclick="close_modal(<?php echo $id ?>)">Retour</button>
        </div>

        <?php
    }
    
    ?>

    <!--<button onclick="open_modal()">OUVRIR MODAL</button>-->


    <script>
        function open_modal(id){
            document.getElementById(`modal_${id}`).className = "modal_open";   
        }

        function close_modal(id){
            document.getElementById(`modal_${id}`).className = "modal_close";
        }

    </script>
    



    
</body>
</html>  