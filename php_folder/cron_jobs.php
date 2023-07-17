<?php 

session_start();

$conn = new PDO('mysql:host=localhost;dbname=web_project', 'root', '', [PDO::ATTR_PERSISTENT => true]);



function switch_Shift($i){

    global $conn;

    $requete=$conn->prepare("UPDATE employe_info set dernier_date_shift=CURRENT_DATE");
    $requete->execute();

    $requete=$conn->prepare("SELECT id_shift FROM employe_info");
    $requete->execute();

    $colonne=$requete->fetch(PDO::FETCH_ASSOC);

    $id_shift=$colonne['id_shift'];

    switch($id_shift){
        case 0:
            $id_shift=1;
            break;
        case 1:
            $id_shift=2;
            break;
        case 2:
            $id_shift=0;
            break;
    }

    $requete=$conn->prepare("UPDATE employe_info set id_shift=:id_shift WHERE id_info = :id_info");
    $requete->bindParam(':id_shift', $id_shift);
    $requete->bindParam(':id_info', $i);
    $requete->execute();

}

function Changement_Shift_2(){

    global $conn;

    while(true)
    {
        $requete=$conn->prepare("SELECT COUNT(*) as nb_employe FROM employe_info");
        $requete->execute();

        $colonne = $requete->fetch(PDO::FETCH_ASSOC);

        $nb_employe=$colonne['nb_employe'];

        for($i=1;$i<=$nb_employe;$i++){
            $requete=$conn->prepare("SELECT DATEDIFF(CURRENT_DATE(), dernier_date_shift) as difference_date FROM employe_info WHERE id_info = :id_info");
            $requete->bindParam(':id_info', $i);
            
            $requete->execute();

            $colonne=$requete->fetch(PDO::FETCH_ASSOC);

            if($colonne['difference_date']>=7){
                switch_Shift($i); 
            }
        }
        sleep(3600);
    }

}


?>