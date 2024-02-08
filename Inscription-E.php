<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Inscription</title>
	<link rel="stylesheet" href="Inscription-E.css"/>
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
    <h1>Inscription</h1>
    <div class="formulaire">
        <form method="POST">
            <?php
            if (isset($_POST["Continue"])) 
            {
                $nom = $_POST["u_nom"];
                $prenom = $_POST["u_prenom"];
                $email = $_POST["u_mail"];
                $mdp = password_hash($_POST["u_mdp"], PASSWORD_DEFAULT);
                           
                    $QueryVerifEmail = "SELECT COUNT(*) as nb FROM client WHERE E_mailClt = :email";
                    $rq_verif_email = $mysqlClient->prepare($QueryVerifEmail);
                    $rq_verif_email->bindParam(':email', $email, PDO::PARAM_STR);
                    $rq_verif_email->execute();
                    $verif_email = $rq_verif_email->fetch(PDO::FETCH_ASSOC);
                    if ($verif_email['nb'] > 0) {
                        echo"<p>Cette adresse email est déjà utilisée.</p>";
                    } else {
                        $QuerySignUp = "INSERT INTO client(NomClt, PrenomClt, E_mailClt, MdpClt) VALUES (?, ?, ?, ?)";
                        $RecupLog = $mysqlClient->prepare($QuerySignUp);
                        $RecupLog->execute([$nom, $prenom, $email, $mdp]);
                        // Stocker l'ID de l'utilisateur dans la session
                        $_SESSION['IdClt'] = $mysqlClient->lastInsertId();
                        // Rediriger vers la page de connexion
                        header("Location: Connexion-E.php");
                    }
                }
            ?>
            <p>
                <label for="log">Nom</label>
                <input type="text" id="log" name="u_nom" placeholder="Nom" required/>
            </p>
            <p>
                
                <label for="log">Prénom </label> 
                <input type="text" id="log" name="u_prenom" placeholder="Prénom" required/>
            </p>
            <p>
				<label for="mail">Adresse e-mail</label>

				<input type="email" id="mail" name="u_mail" placeholder="Adresse e-mail" required />
			</p>
            <p>
				<label for="mdp">Mot de passe</label>
				<input type="password" id="mdp" name="u_mdp" placeholder="Mot de passe" required />
			</p>
            <p>
                <input type="submit" name="Continue" value="Continue" />
            </p>
            <p>
            </p>
        </form>
        <a href="http://localhost/E-Commerce/Connexion-E.php">← Retour à la page de connexion</a>
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