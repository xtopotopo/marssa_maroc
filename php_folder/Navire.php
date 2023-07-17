<?php
require_once('sql_functions.php');
require('navbar.php');

        $requete=$conn->prepare('SELECT etat_dechargement from navire where etat_dechargement=1');
        $requete->execute();
        $colonne=$requete->fetch(PDO::FETCH_ASSOC);

        if($colonne['etat_dechargement']==1){
            header('Location:emploi_temps.php');
        }

?>

<script>
    function redirectToNavire() {
        window.location.href = "Navire.php";
    }
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navire</title>
    
    <link rel="stylesheet" href="..\css_folder\Navire.css">
    <link rel="stylesheet" href="..\css_folder\rp.css">
    <script src="..\script.js"></script>
</head>
<body>
<H1>Navire</H1>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Numéro de visite</th>
            <th>Date d'accostage</th>
            <th>Marchandise</th>
            <th>actif</th>
        </tr>
    </thead>
    <tbody>
    <?php
    foreach($tableData as $row){
        echo "<tr>";
        echo "<td>" . $row["Nom"] . "</td>";
        echo "<td>" . $row["NumeroVisite"] . "</td>";
        echo "<td>" . $row["DateAccostage"] . "</td>";
        echo "<td>" . $row["Marchandise"] . "</td>";
        echo "<td> <a class=\"submit\" href='?id=".$row["id_navire"]."'>Choisir </a> </td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<button id="ajoute_btn" class="submit ajt_btn">Ajouter une navire</button> <br>



<form action="Navire.php" method="post" id="navire_forme" class="navire_forme">
    <div class="login_cont">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Numéro de visite</th>
                    <th>Date d'accostage</th>
                    <th>Marchandise</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <input type="text" name="Nom" class="Navire_input">
                    </td>
                    <td>
                        <input type="number" name="NumeroVisite" class="Navire_input">
                    </td>
                    <td>
                        <input type="date" name="DateAccostage" class="Navire_input">
                    </td>
                    <td>
                        <input type="text" name="Marchandise" class="Navire_input">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="btn_div">
        <input class="cfm_btn" name="cfm_btn" type="submit" value="comfirmer">
        <button id="annuler_btn" class="anl_btn">Annuler</button>
    </div>
    
</form>

<?php if (isset($_POST['cfm_btn'])) {ajoute_navire();  }?>

</body>
</html>
