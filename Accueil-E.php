<?php 
session_start(); 

try 
{
	// Connexion à la base de données
	$host = 'localhost:3307';
    $dbname = 'le_monde_est_vache';
    $user = 'root';
    $password = '';

    $mysqlClient = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
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
    // afficher les produits
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
            <?php 
             if (isset($_SESSION['user'])) {
                // Si l’utilisateur est connecté, afficher le texte connecté
                echo '<span class="connected">Connecté(e)</span>';
            } else 
                // Si l’utilisateur n’est pas connecté, afficher le texte de connexion
                echo '<a href="Connexion-E.php" class="submit"> <input type="button" name"Connexion" value="Connexion"></a>'; 
            ?>
            <a href="Panier-E.php" class="submit">
                <input type="button" name="Panier" value="Panier">
            </a>
        </div>
        <div class="formulaire">
            <form method="POST" action="Panier-E.php">
                <?php 
                // Récupérer le nom de la taille à partir de l'identifiant
                function getTypeName($idTaille, $mysqlClient) {
                    $query = "SELECT produit.IdPrd, produit.NomPrd, produit.IdTlle FROM produit JOIN taille ON produit.IdTlle = taille.IdTlle";
                    $stmt = $mysqlClient->prepare($query);
                    $stmt->bindParam(':idTaille', $idTaille, PDO::PARAM_INT);

                    $taillenom = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $taillenom['NomTlle'] ?? '';
                }

                // Parcourez les articles et affichez chacun d'eux avec un formulaire
                for ($i = 0; $i < count($produits); $i++) {
                    echo '<div class="article">';

                    // Affiche le nom de l'article
                    echo '<h2>' . htmlspecialchars($produits[$i]['NomPrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</h2>'; 

                    // Affiche l'image de l'article
                    echo '<img src="image/' . htmlspecialchars($produits[$i]['ImagePrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '.png" alt="' . htmlspecialchars($produits[$i]['ImagePrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">';
                    
                    // Affiche le prix de l'article
                    echo '<p>Prix: ' . htmlspecialchars($produits[$i]['PrixPrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '</p>'; 

                    // Appelle la fonction "getTypeName" avec les paramètres nécessaires
                    $taillenom = getTypeName($produits[$i]['IdTlle'], $mysqlClient);

                    // Afficher le nom de la taille
                    if (!is_null($taillenom)) {
                        echo '<p>Taille : '. htmlspecialchars($taillenom, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'). '</p>';
                    }

                    // Crée un champ caché pour enregistrer le nom de l'article
                    echo '<input type="hidden" name="l[]" value="' . htmlspecialchars($produits[$i]['NomPrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">'; 
                    
                    // Crée un champ caché pour enregistrer le prix de l'article
                    echo '<input type="hidden" name="p[]" value="' . htmlspecialchars($produits[$i]['PrixPrd'] ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '">'; 
                    
                    // Crée une étiquette pour le champ de quantité
                    echo '<label for="q' . $i . '">Quantité:</label>'; 
                    
                    // Crée un champ pour saisir la quantité
                    echo '<input type="number" id="q' . $i . '" name="q[]" min="0" value="0">'; 
        
                    // Crée un bouton pour ajouter l'article au panier
                    echo '<input type="submit" name="ajouter" value="Ajouter">'; 
                    echo '</div>';
                    if (isset($_POST['ajouter'])) {

                        // Appelle la fonction "ajouterArticle" avec les paramètres nécessaires
                        ajouterArticle($produits[$i]['NomPrd'], 1, $produits[$i]['PrixPrd']);
                    }
                }
            
                ?>
            </form>
        </div>
    </body>
</html>