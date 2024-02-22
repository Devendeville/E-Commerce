<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet"  type="text/css" href="Connexion-E.css">
</head>
<?php
try {
	
	$mysqlClient = new PDO('mysql:host=localhost:3306;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e) 
{
	die('Erreur  : ' . $e->getMessage());
}
?>
<body>
    <h1>Formulaire de connexion</h1>
    <div class = formulaire>

        <form method="post">
            <?php
            if(isset($_POST["Valider"]))
            {
                $email=$_POST["e-mail"];
                $mdp=$_POST["e-mdp"];
                $QueryConnexion = "SELECT * FROM client WHERE E_mailClt = :email";
                $resultat = $mysqlClient->prepare($QueryConnexion);
                $resultat->execute([':email' => $email]);
                $row = $resultat->fetch(PDO::FETCH_ASSOC);
                if(password_verify($mdp, $row['MdpClt']))
                {
                    header("location : h");
                    exit();
                }
                else
                {
                    if(!isset($NBessaie))
                    {
                        $NBessaie = 0;
                    }
                }
                if(++$NBessaie>=3)
                {
                    echo 'Contacter un responsable du site.';
                    unset($_SESSION['NBessaie']);
                }
                else
                {
                    $_SESSION['NBessaie'] = $NBessaie;
                }

                
                $QueryConnexion = "SELECT IdClt, MdpClt, E_mailClt FROM client WHERE E_mailClt = :email";
                $rq_connexion = $mysqlClient->prepare($QueryConnexion);
                $rq_connexion->bindParam(':email',$email,PDO::PARAM_STR);
                $rq_connexion->execute();
                $user = [];
                while ($ligne = $rq_connexion->fetch(PDO::FETCH_ASSOC)){
                    $user[] = $ligne;
                }
                if (empty($user)) {
                    echo 'Aucun compte trouvé avec cette adresse email.';
                } else {
                    if (password_verify($mdp,$user[0]['MdpClt']))
                    {
                        $_SESSION['IdClt'] = $user[0]['IdClt'];
                        header("Location: Accueil-E.php");
                        exit();
                    }else 
                    {
                        echo 'Mot de passe invalide';
                    }
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
                    document.getElementById("eye").src="green_eye.png";
                    e=false;
                }
                else
                {
                    document.getElementById("mdp").setAttribute("type","password");
                    document.getElementById("eye").src="red_eye.png";
                    e=true;
                }
            }
        </script>
    </div>
</body>
</html>