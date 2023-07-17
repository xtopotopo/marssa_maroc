<?php
require_once('sql_functions.php');
require_once('navbar.php');





$requete = $conn->prepare("SELECT Nom FROM navire WHERE etat_dechargement=1");
$requete->execute();
$tableData = $requete->fetchAll(PDO::FETCH_ASSOC);




$requete=$conn->prepare('SELECT etat_dechargement from navire where etat_dechargement=1');
$requete->execute();
$colonne=$requete->fetch(PDO::FETCH_ASSOC);

if($colonne['etat_dechargement']!=1){
    header('Location:Navire.php');
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>emplooi temps</title>
    <link rel="stylesheet" href="..\css_folder\rp.css">
    <link rel="stylesheet" href="..\css_folder\emploi.css">
    <script src="..\Dashboard.js"></script>

</head>


<body>
    
<h1>Emploi temps</h1>

<table>
    <thead>
    <tr>
        <th>Nom navire</th>
        <th>Date d'accostage</th>
        <th>shift</th>
        <th>outil</th>
        <th></th>
    </tr>
    </thead>
    <td>
        <?php

        $requete = $conn->prepare("SELECT * FROM navire WHERE etat_dechargement=1");
        $requete->execute();
        $colonne = $requete->fetch(PDO::FETCH_ASSOC);

        echo  $colonne["Nom"] ;
        
        ?>
    </td>

    <td>
        <?php
            echo  $colonne["DateAccostage"] ;
        ?>
    </td>

    <td>

        <strong><p>midi:</p></strong>
        <?php
        $requete = $conn->prepare("SELECT concat(nom,' ',prenom) as nom_prenom FROM employe_info WHERE decharge=1  and id_shift=0");
        $requete->execute();
        $colonne = $requete->fetchAll(PDO::FETCH_ASSOC);

        
        foreach($colonne as $row){
            echo $row['nom_prenom']."<br>";
        }
        ?>
<br>
        <strong><p>Apres midi:</p></strong>
        <?php
        $requete = $conn->prepare("SELECT concat(nom,' ',prenom) as nom_prenom FROM employe_info WHERE decharge=1  and id_shift=1 ");
        $requete->execute();
        $colonne = $requete->fetchAll(PDO::FETCH_ASSOC);

        
        foreach($colonne as $row){
            echo $row['nom_prenom']."<br>" ;
        }
        ?>
<br>
        <strong><p> Soir:</p></strong>
        <?php
        $requete = $conn->prepare("SELECT concat(nom,' ',prenom) as nom_prenom FROM employe_info WHERE decharge=1  and id_shift=2");
        $requete->execute();
        $colonne = $requete->fetchAll(PDO::FETCH_ASSOC);

        
        foreach($colonne as $row){
            echo $row['nom_prenom']."<br>" ;
        }
        ?>
    <br>
    </td>

    <td>
        <?php
        $requete = $conn->prepare("SELECT *  FROM outil ");
        $requete->execute();
        $colonne = $requete->fetchAll(PDO::FETCH_ASSOC);

        
        foreach($colonne as $row){
            echo "<strong><p>".$row['Nom_outil'].":</strong>".$row['quantite_utilise']."</p><br>" ;
        }

        ?>
    </td>

    <td>
    <form action="emploi_temps.php" method="post">
    <input type="submit" name="truncate" class='anl_btn submit' value="Terminer">
    <?php
    if(isset($_POST['truncate']) ){
        $requete=$conn->prepare('UPDATE outil SET quantite_utilise = 0 WHERE quantite_utilise>0;');
        $requete->execute(); 

        $requete=$conn->prepare('UPDATE employe_info SET decharge = 0 WHERE decharge>0;');
        $requete->execute(); 


        $requete=$conn->prepare('UPDATE navire SET etat_dechargement = 0 WHERE etat_dechargement=1;');
        $requete->execute(); 

        header('Location:Navire.php');

    }
    ?>
</form>
    </td>

</table>







</body>
</html>