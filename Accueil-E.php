<?php 
session_start(); 

try 
{
	// Connexion à la base de données
	$mysqlClient = new PDO('mysql:host=localhost:3306;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e)
{
	// Affichage d'une erreur en cas d'exception
	die('Erreur  : ' . $e->getMessage());
}

// Récupère les articles de la base de données
$query = $mysqlClient->query("SELECT * FROM produit");
$produits = $query->fetchAll(PDO::FETCH_ASSOC);

if (empty($produits)) 
{
    echo "Error: No data found.";
} else 
{
    // Display the products
    for ($i = 0; $i < count($produits); $i++) {
        // ...
    }
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
            <a href="Inscription-E.php" class="submit">
                <input type="button" name="Inscription" value="Inscription">
            </a>
            <a href="Connexion-E.php" class="submit">
                <input type="button" name="Connexion" value="Connexion">
            </a>
        </div>
        <div class = "formulaire">
            <form method ="POST" action="panier.php">
            <?php
            
            // Parcourez les articles et affichez chacun d'eux avec un formulaire
            for ($i = 0; $i < count($produits); $i++) {
                echo '<div class="article">';
                echo '<h2>' . htmlspecialchars($produits[$i]['libelleProduit']) . '</h2>';
                echo '<p>Prix: ' . htmlspecialchars($produits[$i]['prixProduit']) . '</p>';
                echo '<input type="hidden" name="l[]" value="' . htmlspecialchars($produits[$i]['libelleProduit']) . '">';
                echo '<input type="hidden" name="p[]" value="' . htmlspecialchars($produits[$i]['prixProduit']) . '">';
                echo '<label for="q' . $i . '">Quantité:</label>';
                echo '<input type="number" id="q' . $i . '" name="q[]" min="1" value="1">';
                echo '<input type="submit" name="ajouter" value="Ajouter">';
                echo '</div>';
            }
            ?>
            </form>
        </div>
        <form id="search-form">
            <input type="text" id="search-input" name="search" placeholder="Rechercher...">
        </form>

    </body>
</html>