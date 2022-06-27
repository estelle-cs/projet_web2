<?php 
include("bdd.php");
session_start();

$idSession = $_SESSION['id'];
$req = "SELECT * FROM rdv WHERE rdv.patientId = '$idSession' AND rdv.date > CURDATE() OR rdv.date = CURDATE() AND rdv.heureDebut > CURRENT_TIME() ORDER BY rdv.date";
$req2 = "SELECT * FROM rdv WHERE rdv.patientId = '$idSession' AND rdv.date < CURDATE() OR rdv.date = CURDATE() AND rdv.heureDebut < CURRENT_TIME() ORDER BY rdv.date DESC";

$ORes = $Bdd->query($req);  
$ORes2 = $Bdd->query($req2); 

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

    <h1 style="color:white">Vos rendez-vous : </h1>
    <div class="part">
        <h2>Vos rendez-vous à venir</h2>
        
            <?php
                while($rdv = $ORes->fetch()){
                    $docId = $rdv->docteurId;
                    $req_docteur ="SELECT * FROM docteur WHERE docteur.id = '$docId'";
                    $ORes_docteur = $Bdd->query($req_docteur);
                    $docteur = $ORes_docteur->fetch();
                    $name_docteur = $docteur->name;
                    $surname_docteur = $docteur->surname;
                    $spe_docteur = $docteur->spe;
                    ?>
                    <div class="case_rdv">
                        <?php
                        $date = $rdv->date;
                        $heure = $rdv->heureDebut;
                        ?>
                        <span style="font-weight: 800">Date du rdv :</span>
                        <?php echo "$date" ?>

                        <br><span style="font-weight: 800">Heure du rdv :</span>
                        <?php echo "$heure" ?>

                        <br><span style="font-weight: 800">Médecin :</span>
                        <?php echo "$name_docteur $surname_docteur, $spe_docteur" ?>

                        <button>Annuler</button>
                        <button>Modifier le rendez-vous</button>
                        
                    </div>
                    <?php
                }
            ?>
        </div>
    </div>

    <div class="part">
        <h2>Demander un nouveau rdv</h2>
        <button class="btn_main">Voir les disponibilités</button>
    </div>

    <div class="part">
        <h2>Vous souhaitez annuler ou déplacer un rdv ?</h2>
        <span>Pour cela, vous pouvez appeler le secrétariat à ce numéro :</span>

    </div>

    <!-- LES ANCIENS RDV-->
    <div class="part">
        <h2 onclick="show_old_rdv()" style="cursor:pointer">Vos rendez-vous passés<img id="chevron" style="float:right;width:25px" src="img/chevron_right.png"></h2>
        <?php
            while($rdv = $ORes2->fetch()){
                $docId = $rdv->docteurId;
                $req_docteur ="SELECT * FROM docteur WHERE docteur.id = '$docId'";
                $ORes_docteur = $Bdd->query($req_docteur);
                $docteur = $ORes_docteur->fetch();
                $name_docteur = $docteur->name;
                $surname_docteur = $docteur->surname;
                $spe_docteur = $docteur->spe;
                ?>
                <div style="display:none" id="divOldRdv" class="case_rdv">
                    <?php
                    $date = $rdv->date;
                    $heure = $rdv->heureDebut;
                    $id_rdv = $rdv->id;
                    $cr_rdv = $rdv->compteRendu;
                    ?>
                    <span style="font-weight: 800">Date du rdv :</span>
                    <?php echo "$date" ?>

                    <br><span style="font-weight: 800">Heure du rdv :</span>
                    <?php echo "$heure" ?>

                    <br><span style="font-weight: 800">Médecin :</span>
                    <?php echo "$name_docteur $surname_docteur, $spe_docteur" ?>

                    <br><button onclick="open_cr_modal(<?php echo $id_rdv ?>)" style="padding:5px 8px" class="btn_main">Voir le compte-rendu</button>
                    <div id="modal_cr_<?php echo $id_rdv ?>" class="modal_close">
                        <h1>COMPTE-RENDU</h1>
                        <span style="font-weight: 800">Date : </span><?php echo "$date" ?>
                        <span style="font-weight: 800;margin-left:40px">Heure : </span><?php echo "$heure" ?>
                        <br><span style="font-weight: 800">Médecin :</span><?php echo " $name_docteur $surname_docteur, $spe_docteur" ?>
                        <div class="div_cr">
                            <?php echo "<span id='div_cr_$id_rdv'> $cr_rdv </span>"?>
                            
                        </div>
                        <button id="btn_close_modal" onclick="close_cr_modal(<?php echo $id_rdv ?>)">Retour</button>
                        <button onclick="edit_cr(<?php echo $id_rdv ?>)">Modifier le compte-rendu</button>
                    </div>
                </div>
                <?php
            }
        ?>
    </div>
    
    <script>
        function show_old_rdv(){
            if(document.getElementById('divOldRdv').style.display == "none"){
                document.getElementById('divOldRdv').style.display = "table";
                document.getElementById('chevron').src = "img/chevron_down.png";
            }
            else{
                document.getElementById('divOldRdv').style.display = "none";
                document.getElementById('chevron').src = "img/chevron_right.png";
            }
        }

        function open_cr_modal(id){
            document.getElementById(`modal_cr_${id}`).className = "modal_open";   
        }

        function close_cr_modal(id){
            document.getElementById(`modal_cr_${id}`).className = "modal_close";
        }

        function edit_cr(id_rdv){
            document.getElementById(`div_cr_${id_rdv}`).style.display = "none";

        }
    </script>
</body>
</html>