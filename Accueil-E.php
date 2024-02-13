<?php 
session_start(); 

try 
{
	$mysqlClient = new PDO('mysql:host=localhost:3306;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e)
{
	die('Erreur  : ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<title>Accueil-E</title>
	<link rel="stylesheet" type="text/css" href="Accueil-E.css"/>
</head>
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
        <input type="text" id="search-input" placeholder="Rechercher..." placeholder="Rechercher...">
        <input type="submit" value="Rechercher">
    </form>
    <div>
    <div><h2>Filtres</h2></div>
    <div><i class="sexe"></i><div>Sexe</div></div>
    <div><i class="motif"></i><div>Motif</div></div>
    <div><i class="type"></i><div>Type</div></div>
    <div><i class="taille"></i><div>Taille</div></div>
    </div>
    
    <!--image de l'accueil-->
    <div class="article-container">
        <img src="article1.jpg" alt="Article 1" class="article-thumbnail" data-article-id="1">
        <img src="article2.jpg" alt="Article 2" class="article-thumbnail" data-article-id="2">
        <img src="article3.jpg" alt="Article 3" class="article-thumbnail" data-article-id="3">
        <img src="article4.jpg" alt="Article 4" class="article-thumbnail" data-article-id="4">
    </div>

    <div class="article-details">
        <!-- Les détails de l'article seront affichés ici -->
    </div>
</body>