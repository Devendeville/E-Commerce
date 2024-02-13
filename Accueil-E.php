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
    <div class="button-group">
        <input type="submit" name="Inscription" value="Inscription"class="submit">
        <input type="submit" name="Inscription" value="Connexion"classe="submit">
    </div>
    <div class = "formulaire">
        <form method ="POST">
        </form>
    </div>
    <form id="search-form">
        <input type="text" id="search-input" placeholder="Rechercher...">
        <input type="submit" value="Rechercher">
    </form>

    <table id="search-results">
        <thead>
            <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            </tr>
        </thead>
        <tbody>
            <!-- Résultats de recherche seront affichés ici -->
        </tbody>
    </table>
</body>