<?php
require_once('sql_functions.php');
if($_SESSION['logged_in']==true) header('Location:Acceuil.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
    <link rel="stylesheet" href="..\css_folder\login.css">
    <link rel="stylesheet" href="..\css_folder\registre.CSS">
</head>
<body>
<div class="whole_page_cont">

    <div class="form_cont">
        <form action="registre.php" method="post">
            <div class="login_cont">
                <img src="..\img_folder\logo_marsa.jpg" alt="">
                <h1>S'inscrire</h1>
                <hr>
                <div class="input_cont">
                    <div class='full_name'>
                        <div>
                            <label for="nom">Nom</label>
                            <input type="text" name="first_name" >
                        </div> 
                        <div>
                            <label for="preno">Prenom</label>
                            <input type="text" name="last_name" >
                        </div>  
                    </div>
                    <label for="Cin">CIN</label>
                    <input type="text" name="cin" >
                    <label for="email">Email</label>
                    <input type="email" name="email">
                    <label for="password">Password</label>
                    <input type="password" name="password" >
                    <?php registre();  ?>
                </div>

                <input type="submit" name="registre" value="S'inscrire" class="submit">

                <div class="lien_exte">
                    <a href="login.php">Se connecter</a>
                </div>
                
            </div>
        </form>
    </div>

    <div class="info_cont">
        <section class="info">
            <h1>
                Bienvenue sur la page de connexion de Marssa Maroc !
            </h1>
            <p>
               Cette page est réservée exclusivement aux employés. Pour en savoir plus sur Marssa Maroc, veuillez cliquer sur le lien externe fourni. Nous vous remercions de respecter la confidentialité de cette page et de ne pas partager vos informations de connexion. Pour toute assistance, contactez notre équipe de support. Merci pour votre compréhension et votre engagement envers Marssa Maroc. <a href="https://www.marsamaroc.co.ma/">Cliquez ici pour en savoir plus sur Marssa Maroc.</a> 
            </p>
            <img src="..\img_folder\pngwing.com.png" alt="">
        </section>
    </div>
</div>
</body>
</html>