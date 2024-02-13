<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Accueil-E</title>
	<link rel="stylesheet" type="text/css" href="Accueil-E.css"/>
</head>

<?php
try 
{
	$mysqlClient = new PDO('mysql:host=localhost:3306;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e)
{
	die('Erreur  : ' . $e->getMessage());
}          
?>
<body>
    <h1>Le monde est vache</h1>
    <div class = "formulaire">
        <form method ="POST">
            

        </form>
        <a href="http://localhost/E-Commerce/Connexion-E.php">Connexion</a>
        <a href="http://localhost/E-Commerce/Inscription-E.php">Inscription</a>
    </div>
</body>