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
            <form method ="POST">
            </form>
        </div>
        <form id="search-form">
            <input type="text" id="search-input" name="search" placeholder="Rechercher...">
        </form>
        <div class="filtre">
        <div><h2>Filtres</h2></div>
        <div><img src="image/sexe.png" alt="Icône Sexe"class="sexe"><div>Sexe</div></div>
        <div><img src="image/motif.png" alt="Icône Motif" class="motif"><div>Motif</div></div>
        <div><img src="image/type.png" alt="Icône Type" class="type"><div>Type</div></div>
        <div><img src="image/taille.png" alt="Icône Taille" class="taille"><div>Taille</div></div>
        </div>
    
        <!-- Images de l'accueil -->
        <div class="article-container">
            <img src="image/mot1_punkachat.png" alt="Article 1" class="article-thumbnail" data-article-id="1">
            <img src="image/mot2_voiture.png" alt="Article 2" class="article-thumbnail" data-article-id="2">
            <img src="image/mot3_cranevache.png" alt="Article 3" class="article-thumbnail" data-article-id="3">
            <img src="image/mot4_poseurEncre.png" alt="Article 4" class="article-thumbnail" data-article-id="4">
        </div>

        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <div class="modal-header">
                    <h2 id="modal-title"></h2>
              </div>
                <div class="modal-body">
                    <img src="" alt="" id="modal-image">
                    <p id="modal-description"></p>
                </div>
            </div>
        </div>
        <div class="article-container">
            <img src="image/mot1_punkachat.png" alt="Article 1" class="article-thumbnail" data-article-id="1">
            <!-- Ajoutez une classe CSS pour activer l'animation -->
            <img src="image/mot1_punkachat.png" alt="Article 1" class="article-thumbnail active" data-article-id="1">
            <!-- Autres images -->
        </div>

    </body>
    <script>
        const articles = [
            { id: 1, image: "image/mot1_punkachat.png", description: "Description de l'article 1" },
            { id: 2, image: "image/mot2_voiture.png", description: "Description de l'article 2" },
            { id: 3, image: "image/mot3_cranevache.png", description: "Description de l'article 3" },
            { id: 4, image: "image/mot4_poseurEncre.png", description: "Description de l'article 4" }
        ];
        const thumbnails = document.querySelectorAll(".article-thumbnail");
        const modal = document.getElementById("modal");
        const modalContent = document.querySelector(".modal-content");
        const modalImage = document.getElementById("modal-image");
        const modalDescription = document.getElementById("modal-description");
        const close = document.querySelector(".close");

        thumbnails.forEach(function(thumbnail) {
            thumbnail.addEventListener("click", function() {
                const articleId = thumbnail.getAttribute("data-article-id");
                const article = articles.find(a => a.id === articleId);

                // Supprimez les détails de l'article précédent, s'il y en avait un
                modalContent.innerHTML = "";

                // Ajoutez les détails de l'article actuel
                if (article) {
                    modalImage.src = article.image;
                    modalDescription.textContent = article.description;
                    modalContent.appendChild(modalImage);
                    modalContent.appendChild(modalDescription);
                    modal.style.display = "block";
                }
            });
        });

        close.addEventListener("click", function() {
            modal.style.display = "none";
        });

        window.addEventListener("click", function(event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });
    </script>
</html>