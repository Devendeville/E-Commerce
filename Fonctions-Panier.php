<?php
function creationPanier()
{
    if (!isset($_SESSION['panier']))
    {
        $_SESSION['panier']=array();
        $_SESSION['panier']['NomPrd']= array();
        $_SESSION['panier']['Quantite']= array();
        $_SESSION['panier']['PrixPrd']= array();
        $_SESSION['panier']['verrou']= false;
    }
    return true;
}
function ajouterArticle($NomPrd,$Quantite,$PrixPrd){
    //Si le panier existe
    if (creationPanier() && !isVerrouille()){
        //Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($NomPrd,  $_SESSION['panier']['NomPrd']);
        if ($positionProduit !== false)
        {
            $_SESSION['panier']['Quantite'][$positionProduit] += $Quantite ;
        }
        else
        {
           //Sinon on ajoute le produit
           array_push( $_SESSION['panier']['NomPrd'],$NomPrd);
           array_push( $_SESSION['panier']['Quantite'],$Quantite);
           array_push( $_SESSION['panier']['PrixPrd'],$PrixPrd);
        }
    }
    else
    echo "Un problème est survenue veuillez contacter l'administrateur du site.";
}
function supprimerArticle($NomPrd){
    //Si le panier existe
    if (creationPanier() && !isVerrouille())
    {
        // Recherche de la position de l'article dans le tableau
        $positionProduit = array_search($NomPrd,  $_SESSION['panier']['NomPrd']);

        // Si l'article est trouvé
        if ($positionProduit !== false)
        {
            // Suppression de l'article du tableau en utilisant array_splice()
            array_splice($_SESSION['panier']['NomPrd'], $positionProduit, 1);
            array_splice($_SESSION['panier']['Quantite'], $positionProduit, 1);
            array_splice($_SESSION['panier']['PrixPrd'], $positionProduit, 1);
        }
    }
    else
    {
        echo "Un problème est survenue veuillez contacter l'administrateur du site.";
    }
}
function modifierQTeArticle($NomPrd,$Quantite){
    //Si le panier existe
    if (creationPanier() && !isVerrouille())
    {
        //Si la quantité est un nombre on modifie sinon on ne fait rien
        if (is_numeric($Quantite))
        {
            //Si la quantité est positive on modifie sinon on supprime l'article
            if ($Quantite > 0)
            {
                //Recherche du produit dans le panier
                $positionProduit = array_search($NomPrd,  $_SESSION['panier']['NomPrd']);

                if ($positionProduit !== false)
                {
                    $_SESSION['panier']['Quantite'][$positionProduit] = $Quantite ;
                }
            }
            else
            {
                supprimerArticle($NomPrd);
            }
        }
    }
    else
    {
        echo "Erreur: $_SESSION[panier] Le tableau n’est pas correctement initialisé ou rempli.";
    }
}
function MontantGlobal()
{
    $total = 0; // Initialize total to 0
    for($i = 0; $i < count($_SESSION['panier']['NomPrd']); $i++)
    {
        // Check if the quantity and price are numbers
        if (is_numeric($_SESSION['panier']['Quantite'][$i]) && is_numeric($_SESSION['panier']['PrixPrd'][$i]))
        {
            $total += $_SESSION['panier']['Quantite'][$i] * $_SESSION['panier']['PrixPrd'][$i];
        }
    }
    return $total;
}
function supprimePanier(){
    unset($_SESSION['panier']);
}
function isVerrouille(){
    if (isset($_SESSION['panier']) && $_SESSION['panier']['verrou'])
    return true;
    else
    return false;
}
function compterArticles()
{
    if (isset($_SESSION['panier']))
    return count($_SESSION['panier']['NomPrd']);
    else
    return 0;
}
?>