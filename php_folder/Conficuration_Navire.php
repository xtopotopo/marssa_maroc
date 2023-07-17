<?php 

require_once('sql_functions.php');
require('navbar.php');




configuration_navire()

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration de Navire</title>
    <link rel="stylesheet" href="..\css_folder\Configuration_Navire.css">
    
    <link rel="stylesheet" href="..\css_folder\rp.css">

</head>
<body>
    
<h1>Configuration du Navire</h1>
<div class="cf_nav_cont">
    <h2><?php Navire_info('Nom') ?></h2>

    
    <form action="Conficuration_Navire.php" method="post">

    <hr>

        <div class="date_heure_cont">
            <div class="date_time_cont_2 " >
                <input type="datetime-local"   name="Date_Time_accostage" placeholder="Date/heure accostage" class="fc">
            </div>

            <div class="date_time_cont_2">
                <input type="datetime-local" name="Date_Time_sortie" placeholder="Date/heure fin dechargement" class="lc">
            </div>
        </div>


        <div class="outils_cont">
            <div class="outils_cont_2 ">
                <input type="number"   name="nb_Grues" placeholder="Nombre de Grues" class="fc">
            </div>

            <div class="outils_cont_2">
                <input type="number" name="nb_Chariots" placeholder="Nombre de Chariots">
            </div>

            <div class="outils_cont_2">
                <input type="number" name="nb_Convoyeurs" placeholder="Nombre de Convoyeurs">
            </div>

            <div class="outils_cont_2 ">
                <input type="number" name="nb_Élingues" placeholder="Nombre de Élingues" class="lc">
            </div>

        </div>


        <div class="personne_cont">
            <input type="number" name="nb_personne" placeholder="Nombre de personne">
        </div>
        

        <input type="submit" value="comfirmer" name="comfirmer" class="submit"> 
    </form>
</div>
</body>
</html>