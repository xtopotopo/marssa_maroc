<?php
require_once('sql_functions.php');
require('navbar.php');

supprimer_employe();
ajouter_admin();
ajouter_employe();
delete_admin();



?>

<!DOCTYPE html>
<html>
<head>
  <title>Tableau de bord futuriste</title>
  <link rel="stylesheet" href="..\css_folder\Dashboard.css">
  <link rel="stylesheet" href="..\css_folder\rp.css">
  <script src="..\Dashboard.js"></script>


  
  </style>
</head>
<body>

<h1>Dashboard</h1>
<div class="button_div"> 
  <button type="button" class="employe_btn btn" id="employe_btn">Employé</button>
  <button  type="button" class="admin_btn btn"  id="admin_btn">Admin</button> 
</div>
<form action="Dashboard.php" method="post">
  <div class="container">
    <div class="employee-section" id="employe_section">
      <h2>Ajouter un employé</h2>
     
      <input type="text" id="employee-cin" name="ajt_employee_cin" placeholder="CIN">
      <input type="submit" name="ajouter_employer" class="ajt_btn x"  value="ajouter" >

      <hr>
      
      <h2>Supprimer un employé</h2>
     
      <input type="text" id="employee-cin" name="spr_employee_cin" placeholder="CIN">
      <input type="submit" name="suprimer_employer" class="spr_btn ajt_btn" value="suprimer" >
    </div>
    
    
    <div class="admin-section"  id="admin_section">
      <h2>Ajouter un administrateur</h2>
      
      <input type="text" id="admin-cin" name="admin_cin" placeholder="CIN"><br><br>

      <input type="text" id="admin-nom" name="admin_nom" placeholder="NOM"><br><br>
 
      <input type="text" id="admin-prenom" name="admin_prenom" placeholder="PRENOM"><br><br>

      <input type="email" id="admin-email" name="admin_email" placeholder="EMAIL"><br><br>
      
      <input type="submit" name="ajouter_admin" class="ajt_btn" value="ajouter" >
    </div>
    <BR></BR>
    <div class="table-section  admin-section" id="admin_section2">
      <h2>Liste des administrateurs</h2>
      <table>
        <thead>
          <tr>
            <th>CIN</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          
        <?php
            $requete = $conn->prepare('SELECT * FROM employe_info WHERE is_admin=1');
            $requete->execute();
            $colonne = $requete->fetchall(PDO::FETCH_ASSOC);

            foreach($colonne as $row) {
                $requete = $conn->prepare('SELECT cin FROM cin WHERE id_cin=:id_cin');
                $requete->bindParam(':id_cin', $row['id_cin']);
                $requete->execute();

                $colonne_tmp = $requete->fetch(PDO::FETCH_ASSOC);
                
                echo "<tr><td>". $colonne_tmp['cin'] ."</td>";
                echo "<td>". $row['nom'] ."</td>";
                echo "<td>". $row['prenom'] ."</td>";

                $requete = $conn->prepare('SELECT email FROM login_info WHERE id_info=:id_info');
                $requete->bindParam(':id_info', $row['id_info']);
                $requete->execute();

                $colonne_tmp = $requete->fetch(PDO::FETCH_ASSOC);

                echo "<td>". $colonne_tmp['email'] ."</td>";
		            echo "<td><a href='?supprimer=".$row['id_cin']."' class=\"delete-link\">Supprimer</a></td></tr>";
            }
           ?>
        </tbody>
      </table>
    </div>
  </div>
</form>
</body>
</html>
