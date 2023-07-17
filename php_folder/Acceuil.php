<?php 

require_once('sql_functions.php');
require_once('navbar.php');



?>





<script>
  $(document).ready(function() {
    $(window).scroll(function() {
      var scrollPosition = $(window).scrollTop();
      var windowHeight = $(window).height();
      var documentHeight = $(document).height();
      var imageHeight = $('.accl_cover').height();

      if ((scrollPosition + windowHeight) >= (documentHeight - imageHeight)) {
        $('#accl_cover').addClass('large');
      } else {
        $('#accl_cover').removeClass('large');
      }
    });
  });
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css_folder\rp.css">
    <link rel="stylesheet" href="..\css_folder\Acceuil.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Acceuil</title>
</head>
<body>


   <h1>Acceuil</h1>

 
 <section class="hero">
    <div class="hero-content">
    <h2>bonjour <?php echo  select_from_employe('nom').' '.select_from_employe('prenom') ?></h2>
    
      
      <div class="div_acc_cvr">
      <img src="..\img_folder\58f1e5c1668f1.jpg" id="accl_cover"alt="" class="accl_cover">
      </div>
    </div>
  </section>

  <h3>A propos d'aujoudhui:</h3>
  <table>
    <thead>
      <th>Shift</th>
      <th>Navire</th>
      <th>Marchandise</th>
      <th>coequipié</th>
      
    </thead>
    <tbody>
    <?php    
$requete = $conn->prepare('SELECT * from employe_info where id_info=:id_info');
$requete->bindParam(':id_info', select_from_employe('id_info'));
$requete->execute();
$colonne = $requete->fetch(PDO::FETCH_ASSOC);

$id_shift = $colonne['id_shift'];
$decharge = $colonne['Decharge'];


$requete = $conn->prepare('SELECT nom_shift from shift where id_shift=:id_shift');
$requete->bindParam(':id_shift', $id_shift);
$requete->execute();
$colonne_shift = $requete->fetch(PDO::FETCH_ASSOC);

echo "<td>" . $colonne_shift['nom_shift'] . "</td>";

if ($decharge == 1) {
  $requete = $conn->prepare('SELECT Nom, Marchandise from navire where etat_dechargement=1');
  $requete->execute();
  $colonne_navire = $requete->fetch(PDO::FETCH_ASSOC);

  echo "<td>" . $colonne_navire['Nom'] . "</td>";
  echo "<td>" . $colonne_navire['Marchandise'] . "</td>";

  $requete = $conn->prepare("SELECT CONCAT(nom,' ',prenom) AS NomComplet from employe_info where Decharge=1 AND id_shift=:id_shift and id_info!=:id_info");
  $requete->bindParam(':id_info', select_from_employe('id_info'));
  $requete->bindParam(':id_shift', $id_shift);
  $requete->execute();
  $colonne_employes = $requete->fetchAll(PDO::FETCH_ASSOC);

  echo "<td>";
  foreach ($colonne_employes as $row) {
    echo $row['NomComplet'] . "<br>";
  }
  echo "</td>";
} else {
  echo "<td colspan=\"3\">Vous n'avez  de déchargement pour aujourd'hui</td>";
}

?>




    </tbody>

  </table>
</body>
</html>

   
</body>
</html>