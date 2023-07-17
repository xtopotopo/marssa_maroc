<?php
require_once('sql_functions.php');

if($_SESSION['logged_in']==true) header('Location:Acceuil.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>identification</title>
    <link rel="stylesheet" href="..\css_folder\login.css">
</head>
<body>
<div class="whole_page_cont">

    <div class="form_cont">
        <form action="Login.php" method="post">
            <div class="login_cont">
                <img src="..\img_folder\logo_marsa.jpg" alt="">
                <h1>S'identifier</h1>
                <hr>
                <div class="input_cont">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];}; ?>">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="">
                    <?php  login(); ?>
                </div>

                <input type="submit" name="submit" value="S'identifier" class="submit"> 

                <div class="lien_exte">
                    <a href="">Mot de passe oublié?</a>
                    <a href="registre.php">Première fois?</a>
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