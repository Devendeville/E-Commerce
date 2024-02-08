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
            <p>
                <label for="log">Nom</label>
                <input type="text" id="log" name="u_nom" placeholder="Nom" required/>
            </p>
            <p>
                <label for="log">Prénom</label>
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
            <?php
            if (isset($_POST["Continue"])) 
            {
                $nom = $_POST["u_nom"];
                $prenom = $_POST["u_prenom"];
                $mail = $_POST["u_mail"];
                $mdp = password_hash($_POST["u_mdp"], PASSWORD_DEFAULT);
                $QuerySignUp = "INSERT INTO client(NomClt, PrenomClt, E_mailClt, MdpClt) VALUES (?, ?, ?, ?)";
                $RecupLog = $mysqlClient->prepare($QuerySignUp);
                $RecupLog->execute([$nom, $prenom, $mail, $mdp]);
            }
            ?>
            </p>
        </form>
    </div>
</body>
</html>
