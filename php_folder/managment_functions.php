<?php 

function session_verification()
{
    if (!isset( $_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){  
        header("Location: login.php");
        exit(); 
    }
}

function logout()
{
    if (isset($_GET['logout'])){
        $_SESSION['logged_in']=false;
        session_destroy();
        header("Location: login.php");
        exit();
    }
}

function maFonction() {

    global $conn;

    if (isset($_GET['action']) && $_GET['action'] === 'executer') {

        $requete=$conn->prepare('SELECT etat_dechargement from navire where etat_dechargement=1');
        $requete->execute();
        $colonne=$requete->fetch(PDO::FETCH_ASSOC);

        if($colonne['etat_dechargement']==1){
            header('Location:emploi_temps.php');
            
        }
        else{
            header('Location:Navire.php');
        }
    }
}

?>