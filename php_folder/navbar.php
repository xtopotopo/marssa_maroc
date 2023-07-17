<?php


function active_class($a)
{
    if ($a == $_SERVER['PHP_SELF'])
    {
        echo "active";
    }
}

require_once('managment_functions.php');
session_verification();
logout();
maFonction();

function select_from_employe($wich_row) {

    global $conn;
    $id_info=$_SESSION['id_info'];
  
    $requete=$conn->prepare("SELECT * FROM employe_info where id_info =:id_info");
    $requete->bindParam(':id_info',$id_info);
    $requete->execute();
  
    $colonne=$requete->fetch(PDO::FETCH_ASSOC);
  
    return $colonne[$wich_row];
  }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="..\css_folder\navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <script src="..\script.js"></script>
</head>


<aside>

    <nav>
    <button id="open_butt"><i class="uil uil-list-ul"></i></button>
        <div class="navbar">
        <button id="close_butt"><i class="uil uil-times"></i></button>
            <div class="logo">
                <a href="Acceuil.php">
                    <img src="..\img_folder\logo_marsa.jpg" alt="logo">
                </a>
               
            </div>
            <ul class="ele_cont">
            <li class="nav_ele <?= active_class('/php_folder/Acceuil.php')?>" ><a href="Acceuil.php">Acceuil</a></li>
                <?php
                    if( select_from_employe('is_admin')==1){
                        echo "<li class=\"nav_ele <?php active_class('/php_folder/Navire.php')?>\" > <a href=\"Acceuil.php?action=executer\">Navire</a></li> ";
                        echo "<li class=\"nav_ele <?php active_class('/php_folder/Dashboard.php')?>\" ><a href=\"Dashboard.php\">Dashboard </a></li> ";
                    }
                ?>
                
                
                
                <li class="nav_ele <?= active_class('/php_folder/Compte.php')?>" ><a href="compte.php">Compte</a></li>
            </ul>
            
            
                
            <div class="deco_div" > 
                <a href="?logout=true" class="deconnexion">Deconnexion</a>
            </div>

        </div>
    </nav>
</aside>



</html>