<?php

require_once('sql_functions.php');
require('navbar.php');


$requete_email=$conn->prepare("SELECT email FROM login_info WHERE id_info=:id_info");
$requete_email->bindParam(':id_info',select_from_employe('id_info'));
$requete_email->execute();

$colonne_email=$requete_email->fetch(PDO::FETCH_ASSOC);


$requete_cin=$conn->prepare("SELECT cin FROM cin WHERE id_cin=:id_cin");
$requete_cin->bindParam(':id_cin',select_from_employe('id_cin'));
$requete_cin->execute();

$colonne_cin=$requete_cin->fetch(PDO::FETCH_ASSOC);


$requete_password=$conn->prepare("SELECT password FROM login_info WHERE id_info=:id_info;");
$requete_password->bindParam(':id_info',select_from_employe('id_info'));
$requete_password->execute();

$colonne_password=$requete_password->fetch(PDO::FETCH_ASSOC);







if(isset($_POST['chg_mdp'])) changer_mot_de_passe();
?>


<script>
    function redirectToCompte() {
        window.location.href = "Acceuil.php";
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte</title>
    <link rel="stylesheet" href="..\css_folder\rp.css">
    <link rel="stylesheet" href="..\css_folder\compte.css">
</head>
<body>
<h1>Compte</h1>
<div class="container">

    <div class="info">
      <h2>Informations de l'employé</h2>
      <div class="field">
        <label>Nom:</label>
        <span id="nom"><?php echo select_from_employe('nom')   ?></span>
      </div>
      <div class="field">
        <label>Prénom:</label>
        <span id="prenom"><?php echo select_from_employe('prenom')   ?></span>
      </div>
      <div class="field">
        <label>CIN:</label>
        <span id="cin"><?php echo $colonne_cin['cin'] ?></span>
      </div>
      <div class="field">
        <label>Email:</label> 
        <span id="email"><?php echo $colonne_email['email'] ?></span>
      </div>
    </div>
    <div class="change-password">
      <h2>Changer le mot de passe</h2>
      <form action="compte.php" method="post">
        <div class="field">
          <label for="old-password">Ancien mot de passe:</label>
          <input type="password" id="old-password" name="old_password">
        </div>
        <div class="field">
          <label for="new-password">Nouveau mot de passe:</label>
          <input type="password" id="new-password" name="new_password">
        </div>
        <div class="field">
          <label for="confirm-password">Confirmer le nouveau mot de passe:</label>
          <input type="password" id="confirm-password" name="confirm_password">
        </div>
        <input class="submit" type="submit" value="Chnager le mot de passe" name="chg_mdp"> 
      </form>
    </div>

</div>
    
</body>
</html>