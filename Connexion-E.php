<?php session_start(); ?>

<?php
try {
	
	$mysqlClient = new PDO('mysql:host=localhost:3307;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e) 
{
	die('Erreur  : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet"  type="text/css" href="Connexion-E.css">
</head>
<body>
    <h1>Formulaire de connexion</h1>
    <div class = formulaire>
        <form method="post">
            <?php
            if(isset($_POST["Valider"]))
            {
                // Récupère les données saisies par l'utilisateur
                $email=$_POST["e-mail"];
                $mdp=$_POST["e-mdp"];

                // Vérifie si les identifiants sont corrects
                $QueryConnexion = "SELECT * FROM client WHERE E_mailClt = :email";
                $resultat = $mysqlClient->prepare($QueryConnexion);
                $resultat->bindParam(':email', $email, PDO::PARAM_STR);
                $resultat->execute();
                $row = $resultat->fetch(PDO::FETCH_ASSOC);
                if($row && password_verify($mdp, $row['MdpClt']))
                {
                    // Redirige l'utilisateur vers la page d'accueil s'il est connecté
                    $_SESSION['IdClt'] = $row['IdClt'];
                  // header("Location: Accueil-E.php");
                  header("Location: Accueil-E.php");
                    //exit();
                }
                else
                {
                    // Affiche un message d'erreur si les identifiants sont incorrects
                    echo 'Identifiants invalides';
                }
            }
            ?>
            <p>
                <label for="mail">Adresse e-mail</label>
                <input type="email" id="mail" name="e-mail" placeholder = "Adresse e-mail" required>
            </p>
            <p>
                <label for="mot de passe">Mot de passe</label>
                <input type="password" id="mdp" name="e-mdp" placeholder = "Mot de passe" required>
                <img src="red_eye.png" id="eye" onclick="changer()" width="20" height="20">
            </p>
            <p>
                <input type="submit" name="Valider" value="Valider">
            </p>
        </form>
        <a href="http://localhost/E-Commerce/Inscription-E.php">S'inscrire →</a>
        <script>
            //L'oeil masqué
            e=true;
            function changer()
            {
                if(e)
                {
                    document.getElementById("mdp").setAttribute("type","text");
                    document.getElementById("eye").src="image/green_eye.png";
                    e=false;
                }
                else
                {
                    document.getElementById("mdp").setAttribute("type","password");
                    document.getElementById("eye").src="image/red_eye.png";
                    e=true;}
            }
        </script>
    </div>
</body>
</html>