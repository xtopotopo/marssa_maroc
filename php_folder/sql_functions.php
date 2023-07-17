<?php

error_reporting(1);
session_start();

$conn = new PDO('mysql:host=localhost;dbname=web_project', 'root', '', [PDO::ATTR_PERSISTENT => true]);

$email=$_POST['email'];

/* ---------------------------------Login-------------------------------------- */
function login()
{

    global $conn;
    
    $email=$_POST['email'];
    $password=$_POST['password'];

    if (isset($_POST['submit'])) {
        $requette=$conn->prepare("SELECT * FROM login_info WHERE email=:email");
        $requette->bindParam(':email',$email);
        $requette->execute();

        $colonne=$requette->fetch(PDO::FETCH_ASSOC);

        if ($colonne && $password==$colonne['password']) {
            
            $_SESSION['id_info']=$colonne['id_info'];
            $_SESSION['logged_in']=true;

            header('Location:Acceuil.php');
            exit();
        } elseif ($colonne && $password!=$colonne['password']) {
            $_SESSION['logged_in']=false;
            echo '<p class="alert_fail">Mot de passe incorrect</p>';
        } else {
            $_SESSION['logged_in']=false;
            echo '<p class="alert_fail">Ce compte n\'existe pas</p>';
        }
    }  
}
/*-------------------------------------shift---------------------------------------------*/

function Plus_Petit_Shift() {
   
    global $conn;

    $requete = $conn->prepare("SELECT id_shift, COUNT(*) AS employee_count FROM employe_info GROUP BY id_shift ORDER BY employee_count ASC LIMIT 1");
    $requete->execute();

    $colonne = $requete->fetch(PDO::FETCH_ASSOC);

    if ($colonne) {
        return $colonne['id_shift'];
    }

    return null;
}


/*--------------------------------------------registration---------------------------------*/ 
function registre() {
    
    global $conn;

    if(isset($_POST['registre'])) {
        $email=$_POST['email'];
        $password=$_POST['password'];
        $first_name=$_POST['first_name'];
        $last_name=$_POST['last_name'];
        $cin=$_POST['cin'];

        if(empty($email) || empty($password) || empty($first_name) || empty($last_name)) {
            echo '<p class="alert_fail">Veuillez saisir tous les champs</p>'; 
        }else {
            $requete_cin=$conn->prepare("SELECT id_cin FROM cin WHERE cin=:cin");
            $requete_cin->bindParam(':cin',$cin);
            $requete_cin->execute();
    
            $colonne_cin=$requete_cin->fetch(PDO::FETCH_ASSOC);
            
            
            if(!$colonne_cin){
                echo '<p class="alert_fail">vous etes pas un employe dans notre marsa maroc</p>'; 
            }else{
                $requete_email=$conn->prepare("SELECT email FROM login_info WHERE email=:email");
                $requete_email->bindParam(':email',$email);
                $requete_email->execute();
    
                $colonne_email=$requete_email->fetch(PDO::FETCH_ASSOC);

                if($colonne_email){
                    echo '<p class="alert_fail">Ce compte deja exicte</p>'; 
                }else{

                    $id_shift=Plus_Petit_Shift();

                    $requete_registre=$conn->prepare("INSERT INTO employe_info (nom,prenom,dernier_date_shift,id_shift,id_srv,id_cin) VALUES (:nom,:prenom,current_date,:id_shift,0,:id_cin)");
                    $requete_registre->bindParam(':nom',$first_name);
                    $requete_registre->bindParam(':prenom',$last_name);
                    $requete_registre->bindParam(':id_shift',$id_shift);
                    $requete_registre->bindParam(':id_cin',$colonne_cin['id_cin']);
                    $requete_registre->execute();

                    if($requete_registre){  
                        $requete=$conn->prepare("SELECT * FROM employe_info WHERE id_cin=:id_cin");
                        $requete->bindParam(':id_cin',$colonne_cin['id_cin']);
                        $requete->execute();
            
                        $id_info=$requete->fetch(PDO::FETCH_ASSOC);
            
                        $requete_login=$conn->prepare("INSERT INTO login_info (id_info,email,password) VALUES (:id_info,:email,:password)");
                        $requete_login->bindParam(':id_info',$id_info['id_info']);
                        $requete_login->bindParam(':email',$email);
                        $requete_login->bindParam(':password',$password);
                        $requete_login->execute();
                    }
                }
            }  
        }
    }
}  

/*********************************************Ajout Navire******************************************************* */

$requete = $conn->prepare("SELECT * FROM navire where etat_dechargement=2 order by DateAccostage asc");
$requete->execute();
$tableData = $requete->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['id'])){
    $_SESSION['id_navire']=$_GET['id'];
    header('Location:Conficuration_Navire.php');
}

function ajoute_navire() {
    global $conn;

    if (isset($_POST['cfm_btn'])) {
        $nom = $_POST['Nom'];
        $numeroVisite = $_POST['NumeroVisite'];
        $dateAccostage = $_POST['DateAccostage'];
        $marchandise = $_POST['Marchandise'];

    
        if((!isset($_POST['Nom']) || empty($_POST['Nom'])) 
        || (!isset($_POST['NumeroVisite']) || empty($_POST['NumeroVisite'])) 
        || (!isset($_POST['DateAccostage']) || empty($_POST['DateAccostage'])) 
        || !isset($_POST['Marchandise']) || empty($_POST['Marchandise'])){
            
            echo '<script type="text/javascript">';
            echo 'alert("Veuillez saisir tous les champs");';
            echo '</script>';
        
                    }else{
           

            $query = "INSERT INTO Navire (Nom, NumeroVisite, DateAccostage, Marchandise)
                      VALUES (:nom, :numeroVisite, :dateAccostage, :marchandise)";
            $stmt = $conn->prepare($query);

            
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':numeroVisite', $numeroVisite);
            $stmt->bindParam(':dateAccostage', $dateAccostage);
            $stmt->bindParam(':marchandise', $marchandise);

           
            $stmt->execute();

            
            echo '<script>redirectToNavire();</script>';
        
            exit();
            
        
            
        }
    }
}


/*********************************************configuration Navire******************************************************* */

function Navire_info($witch_row){
    global $conn;

    $id_navire=$_SESSION['id_navire'];
    $requete=$conn->prepare("SELECT * FROM navire WHERE id_navire=:id_navire");
    $requete->bindParam('id_navire',$id_navire);
    $requete->execute();

    $colonne=$requete->fetch(PDO::FETCH_ASSOC);

    echo $colonne[$witch_row];
}

function configuration_navire() {
    global $conn;

    if (isset($_POST['comfirmer'])) {
        $Date_Time_accostage = $_POST['Date_Time_accostage'];
        $Date_Time_sortie = $_POST['Date_Time_sortie'];
        $nb_Grues = $_POST['nb_Grues'];
        $nb_Chariots = $_POST['nb_Chariots'];
        $nb_Convoyeurs = $_POST['nb_Convoyeurs'];
        $nb_Élingues = $_POST['nb_Élingues'];
        $nb_personne = $_POST['nb_personne'];
        $id_navire = $_SESSION['id_navire'];

        if (empty($Date_Time_accostage)
            || empty($Date_Time_sortie)
            || empty($nb_Grues)
            || empty($nb_Chariots)
            || empty($nb_Convoyeurs)
            || empty($nb_Élingues)
            || empty($nb_personne)
            || empty($id_navire)
        ) {
            echo '<script type="text/javascript">';
            echo 'alert("Veuillez saisir tous les champs");';
            echo '</script>';
        } else {
            $nb_heure = date_heure_converter($Date_Time_accostage, $Date_Time_sortie);

            $heure_accostage = strtotime($Date_Time_accostage);
            $heure_accostage = date('H', $heure_accostage);

            $heure_sortie = strtotime($Date_Time_sortie);
            $heure_sortie = date('H', $heure_sortie);

            if ($nb_heure < 8) {
                if (($heure_accostage >= 6 && $heure_accostage < 14) && ($heure_sortie >= 14 && $heure_sortie < 22)) {
                    select_from_shift($nb_personne, 0);
                    select_from_shift($nb_personne, 1);
                } elseif (($heure_accostage >= 14 && $heure_accostage < 22) && ($heure_sortie >= 22 || ($heure_sortie >= 0 && $heure_sortie < 6))) {
                    select_from_shift($nb_personne, 1);
                    select_from_shift($nb_personne, 2);
                } elseif (($heure_sortie >= 6 && $heure_sortie < 14) && ($heure_accostage >= 22 || ($heure_accostage >= 0 && $heure_accostage < 6))) {
                    select_from_shift($nb_personne, 2);
                    select_from_shift($nb_personne, 0);
                } elseif ($heure_accostage >= 6 && $heure_sortie < 14) {
                    select_from_shift($nb_personne, 0);
                } elseif ($heure_accostage >= 14 && $heure_sortie < 22) {
                    select_from_shift($nb_personne, 1);
                } elseif ($heure_accostage >= 22 && ($heure_sortie >= 0 && $heure_sortie < 6)) {
                    select_from_shift($nb_personne, 2);
                }
            } elseif ($nb_heure >= 8 && $nb_heure < 16) {
                if (($heure_accostage >= 6 && $heure_accostage < 14) && ($heure_sortie >= 14 && $heure_sortie < 22)) {
                    select_from_shift($nb_personne, 0);
                    select_from_shift($nb_personne, 1);
                } elseif (($heure_accostage >= 14 && $heure_accostage < 22) && ($heure_sortie >= 22 || ($heure_sortie >= 0 && $heure_sortie < 6))) {
                    select_from_shift($nb_personne, 1);
                    select_from_shift($nb_personne, 2);
                } elseif (($heure_accostage >= 22 || ($heure_accostage >= 0 && $heure_accostage < 6)) && ($heure_sortie >= 6 && $heure_sortie < 14)) {
                    select_from_shift($nb_personne, 2);
                    select_from_shift($nb_personne, 0);
                } else {
                    select_from_shift($nb_personne, 0);
                    select_from_shift($nb_personne, 2);
                    select_from_shift($nb_personne, 1);
                }
            } else {
                select_from_shift($nb_personne, 0);
                select_from_shift($nb_personne, 2);
                select_from_shift($nb_personne, 1);
            }

            update_decharge_navire(1, $id_navire);

            update_quantite_outil($nb_Grues, 'Grues portuaires');
            update_quantite_outil($nb_Convoyeurs, 'Convoyeurs');
            update_quantite_outil($nb_Chariots, 'Chariots élévateurs');
            update_quantite_outil($nb_Élingues, 'Élingues et palans');

            $requete = $conn->prepare('UPDATE employe_info SET dernier_date_dechargemt = current_date WHERE decharge = 1;');
            $requete->execute();

            header('Location: emploi_temps.php');
        }
    }
}

    
function update_quantite_outil( $quantite_utilise,$Nom_outil){

    global $conn;

    $requete=$conn->prepare('UPDATE outil SET quantite_utilise = :quantite_utilise WHERE Nom_outil = :Nom_outil ;');
    $requete->bindParam(':quantite_utilise', $quantite_utilise, PDO::PARAM_INT);
    $requete->bindParam(':Nom_outil', $Nom_outil);

    $requete->execute(); 

}


function update_decharge_navire(int $valeur,int $id_navire){

    global $conn;

        /*
        2:n'est pas dechargé
        1:en_cours de dechargement
        0:dechargé 
        */
    $requete=$conn->prepare('UPDATE navire SET etat_dechargement = :valeur WHERE id_navire = :id_navire ;');
    $requete->bindParam(':valeur', $valeur, PDO::PARAM_INT);
    $requete->bindParam(':id_navire', $id_navire, PDO::PARAM_INT);

    $requete->execute(); 

}



function select_from_shift(int $nb_personne,int $id_shift){
    global $conn;

    $requete=$conn->prepare('UPDATE employe_info SET Decharge = 1,dernier_date_shift = current_date WHERE id_shift = :id_shift AND is_admin!=1 ORDER BY dernier_date_dechargemt ASC LIMIT :nb_personne;');
    $requete->bindParam(':nb_personne', $nb_personne, PDO::PARAM_INT);
    $requete->bindParam(':id_shift', $id_shift, PDO::PARAM_INT);

    $requete->execute(); 

}

function date_heure_converter($D_T_accostage,$D_T_sortie){
   
    $date1 = strtotime($D_T_accostage);
    $date2 = strtotime($D_T_sortie);

    return ceil(abs($date1 - $date2) / 3600);
}
/******************************************************* Dashboard.php *************************************************************/ 


function supprimer_employe(){

    global $conn;

    if(isset($_POST['suprimer_employer']) && !empty($_POST['suprimer_employer'])){
        $cin=$_POST['spr_employee_cin'];
        $requete=$conn->prepare("DELETE FROM cin WHERE cin=:cin");
        $requete->bindParam(':cin',$cin);

        $requete->execute();
        header("Location: Dashboard.php");

    }

}

function ajouter_employe() {
    global $conn;
    if(isset($_POST['ajouter_employer']) && !empty($_POST['ajouter_employer'])){ 
        $cin=$_POST['ajt_employee_cin']; 
        $requete=$conn->prepare("INSERT INTO cin(cin) VALUES(:cin)");
        $requete->bindParam(':cin',$cin);
        $requete->execute();
        header("Location: Dashboard.php");
    }
}

function ajouter_admin() {
    global $conn;

    if(isset($_POST['ajouter_admin']) && !empty($_POST['ajouter_admin'])) {

        $cin = $_POST['admin_cin'];
        $nom = $_POST['admin_nom'];
        $prenom = $_POST['admin_prenom'];
        $email = $_POST['admin_email'];

        if(empty($email) || empty($cin) || empty($nom) || empty($prenom)) {
            echo '<script type="text/javascript">';
            echo 'alert("Veuillez saisir tous les champs");';
            echo '</script>'; 
        } else {
           
            $requete = $conn->prepare("INSERT INTO cin(cin) VALUES(:cin)");
            $requete->bindParam(':cin', $cin);
            if(!$requete->execute()) {
                echo "Erreur lors de l'insertion du numéro de carte d'identité";
             
            }

            $requete = $conn->prepare("SELECT * FROM cin WHERE cin=:cin");
            $requete->bindParam(':cin', $cin);
            if(!$requete->execute()) {
                echo "Erreur lors de la récupération des informations de la table cin";
               
            }

            $colonne_cin = $requete->fetch(PDO::FETCH_ASSOC);

            $is_admin = 1;
            $requete_registre = $conn->prepare("INSERT INTO employe_info (nom, prenom, is_admin, id_srv, id_cin) VALUES (:nom, :prenom, :is_admin, 0, :id_cin)");
            $requete_registre->bindParam(':nom', $nom);
            $requete_registre->bindParam(':prenom', $prenom);
            $requete_registre->bindParam(':is_admin', $is_admin);
            $requete_registre->bindParam(':id_cin', $colonne_cin['id_cin']);
            if(!$requete_registre->execute()) {
                echo "Erreur lors de l'insertion des informations dans la table employe_info";
                
            }

            if($requete_registre) {  
                $requete = $conn->prepare("SELECT * FROM employe_info WHERE id_cin=:id_cin");
                $requete->bindParam(':id_cin', $colonne_cin['id_cin']);
                if(!$requete->execute()) {
                    echo "Erreur lors de la récupération des informations de la table employe_info";
                }
            
                $id_info = $requete->fetch(PDO::FETCH_ASSOC);
            
                $requete_login = $conn->prepare("INSERT INTO login_info (id_info, email, password) VALUES (:id_info, :email, :password)");
                $requete_login->bindParam(':id_info', $id_info['id_info']);
                $requete_login->bindParam(':email', $email);
                $requete_login->bindParam(':password', $cin); 
                if(!$requete_login->execute()) {
                    echo "Erreur lors de l'insertion des informations dans la table login_info";
                  
                }
            }
            header('Location:Dashboard.php');
        }
    }  
}




function delete_admin() {
    global $conn;
  
    if (isset($_GET['supprimer'])) {
        $id_cin = $_GET['supprimer'];
        $requete = $conn->prepare("DELETE FROM cin WHERE id_cin=:id_cin");
        $requete->bindParam(':id_cin', $id_cin);
  
        $requete->execute();
        header('Location:Dashboard.php');
  
    }
  }


/**************************************************************Compte.php***********************************************************/

  function changer_mot_de_passe(){

    global $conn;

    $old_password=$_POST['old_password'];
    $new_password=$_POST['new_password'];
    $confirm_password=$_POST['confirm_password'];


        if((isset($_POST['old_password']) && !empty($_POST['old_password']))
            && (isset($_POST['new_password']) && !empty($_POST['new_password']))
            && (isset($_POST['confirm_password']) && !empty($_POST['confirm_password']))){

         

            $requete_password=$conn->prepare("SELECT password FROM login_info WHERE id_info=:id_info;");
            $requete_password->bindParam(':id_info',select_from_employe('id_info'));
            $requete_password->execute();

            $colonne_password=$requete_password->fetch(PDO::FETCH_ASSOC);

            if($old_password == $colonne_password['password'] ){
                if($new_password==$confirm_password){
                    $requete = $conn->prepare('UPDATE login_info SET password = :password WHERE id_info=:id_info;');
                    $requete->bindParam(':id_info', select_from_employe('id_info'));
                    $requete->bindParam(':password', $new_password);
                    $requete->execute();

                    header('Location:Compte.php');
                    
             
                }else{
                    echo '<script type="text/javascript">';
                    echo 'alert("les deux code sont different new='. $new_password.'comfirm='. $confirm_password.'");';
                    echo '</script>';
                }

            }else{
                echo '<script type="text/javascript">';
                echo 'alert("l\'ancien mot de passe est incorrecte mdp='.$old_password.'");';
                echo '</script>';
            }


    }else{
        echo '<script type="text/javascript">';
            echo 'alert("Veuillez saisir tous les champs");';
            echo '</script>';
    }

}

?>

