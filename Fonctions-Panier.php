<?php
// Fonction pour créer le panier s'il n'existe pas
function creationPanier()
{
    // Vérifie si la variable de session 'panier' existe
    if (!isset($_SESSION['panier'])) {
        // Si non, on l'initialise en un tableau à trois dimensions
        $_SESSION['panier'] = array(
            'NomPrd' => array(),
            'Quantite' => array(),
            'PrixPrd' => array()
        );
    }
    return true;
}
function ajouterArticle($NomPrd, $Quantite, $PrixPrd)
{
    if (creationPanier() && !isVerrouille()) {
        $nbArticles = compterArticles();
        if ($nbArticles > 0) {
            // Recherche de la position de l'article dans le tableau
            $positionProduit = array_search($NomPrd, $_SESSION['panier']['NomPrd']);

            // Si l'article est trouvé
            if ($positionProduit !== false) {
                // Mise à jour de la quantité
                $_SESSION['panier']['Quantite'][$positionProduit] += $Quantite;
            } else {
                // Ajout de l'article
                array_push($_SESSION['panier']['NomPrd'], $NomPrd);
                array_push($_SESSION['panier']['Quantite'], $Quantite);
                array_push($_SESSION['panier']['PrixPrd'], $PrixPrd);
            }
        } else {
            // Initialisation du panier
            $_SESSION['panier'] = array(
                'NomPrd' => array($NomPrd),
                'Quantite' => array($Quantite),
                'PrixPrd' => array($PrixPrd)
            );
        }
    } else {
        echo "Erreur: $_SESSION[panier] Le tableau n’est pas correctement initialisé ou rempli.";
    }
}
function supprimerArticle($NomPrd)
{
    if (creationPanier() && !isVerrouille()) {
        // Recherche de la position de l'article dans le tableau
        $positionProduit = array_search($NomPrd, $_SESSION['panier']['NomPrd']);

        // Si l'article est trouvé
        if ($positionProduit !== false) {
            // Suppression de l'article du tableau en utilisant array_splice()
            array_splice($_SESSION['panier']['NomPrd'], $positionProduit, 1);
            array_splice($_SESSION['panier']['Quantite'], $positionProduit, 1);
            array_splice($_SESSION['panier']['PrixPrd'], $positionProduit, 1);
        }
    } else {
        echo "Erreur: $_SESSION[panier] Le tableau n’est pas correctement initialisé ou rempli.";
    }
}
function modifierQTeArticle($NomPrd, $Quantite)
{
    if (creationPanier() && !isVerrouille()) {
        // Si la quantité est un nombre on modifie sinon on ne fait rien
        if (is_numeric($Quantite)) {
            // Convertir $Quantite en un nombre entier avant de l'utiliser dans des opérations arithmétiques
            $Quantite = intval($Quantite);

            // Si la quantité est positive on modifie, sinon on supprime l'article
            if ($Quantite > 0) {
                // Recherche du produit dans le panier
                $positionProduit = array_search($NomPrd, $_SESSION['panier']['NomPrd']);

                if ($positionProduit !== false) {
                    $_SESSION['panier']['Quantite'][$positionProduit] = $Quantite;
                }
            } else {
                supprimerArticle($NomPrd);
            }
        }
    } else {
        echo "Erreur: $_SESSION[panier] Le tableau n’est pas correctement initialisé ou rempli.";
    }
}
function MontantGlobal()
{
    $total = 0;
    for ($i = 0; $i < compterArticles(); $i++) {
        if (isset($_SESSION['panier']['Quantite'][$i]) && isset($_SESSION['panier']['PrixPrd'][$i])) {
            $total += $_SESSION['panier']['Quantite'][$i] * floatval($_SESSION['panier']['PrixPrd'][$i]);
        }
    }
    return $total;
}
function supprimePanier()
{
    unset($_SESSION['panier']);
}
function isVerrouille()
{
    if (isset($_SESSION['panier']) && isset($_SESSION['panier']['verrou']) && $_SESSION['panier']['verrou'])
        return true;
    else
        return false;
}
creationPanier();
$nbArticles = compterArticles();
function compterArticles()
{
    $nbArticles = 0;
    if (isset($_SESSION['panier']['NomPrd'])) {
        $nbArticles = count($_SESSION['panier']['NomPrd']);
    }
    return $nbArticles;
}
