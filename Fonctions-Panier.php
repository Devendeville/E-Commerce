<?php
function creationPanier()
{
    if (!isset($_SESSION['panier']))
    {
        $_SESSION['panier']=array();
        $_SESSION['panier']['libelleProduit']= array();
        $_SESSION['panier']['qteProfuit']= array();
        $_SESSION['panier']['prixProduit']= array();
        $_SESSION['panier']['verrou']= false;
    }
    return true;
}
function ajouterArticle($libelleProduit,$qteProduit,$prixProduit){
    //Si le panier existe
    if (creationPanier() && !isVerrouille()){
        //Si le produit existe déjà on ajoute seulement la quantité
        $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);
        if ($positionProduit !== false)
        {
            $_SESSION['panier']['qteProduit'][$positionProduit] += $qteProduit ;
        }
        else
        {
           //Sinon on ajoute le produit
           array_push( $_SESSION['panier']['libelleProduit'],$libelleProduit);
           array_push( $_SESSION['panier']['qteProduit'],$qteProduit);
           array_push( $_SESSION['panier']['prixProduit'],$prixProduit);
        }
    }
    else
    echo "Un problème est survenue veuillez contacter l'administrateur du site.";
}
function supprimerArticle($libelleProduit){
    //Si le panier existe
    if (creationPanier() && !isVerrouille())
    {
        // Recherche de la position de l'article dans le tableau
        $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);

        // Si l'article est trouvé
        if ($positionProduit !== false)
        {
            // Suppression de l'article du tableau en utilisant array_splice()
            array_splice($_SESSION['panier']['libelleProduit'], $positionProduit, 1);
            array_splice($_SESSION['panier']['qteProduit'], $positionProduit, 1);
            array_splice($_SESSION['panier']['prixProduit'], $positionProduit, 1);
        }
    }
    else
    {
        echo "Un problème est survenue veuillez contacter l'administrateur du site.";
    }
}
function modifierQTeArticle($libelleProduit,$qteProduit){
    //Si le panier existe
    if (creationPanier() && !isVerrouille())
    {
        //Si la quantité est positive on modifie sinon on supprime l'article
        if ($qteProduit > 0)
        {
            //Recherche du produit dans le panier
            $positionProduit = array_search($libelleProduit,  $_SESSION['panier']['libelleProduit']);
         
            if ($positionProduit !== false)
            {
                $_SESSION['panier']['qteProduit'][$positionProduit] = $qteProduit ;
            }
        }
        else
        supprimerArticle($libelleProduit);
    }
    else
    echo "Un problème est survenu veuillez contacter l'administrateur du site.";
}
function MontantGlobal(){
    $total=0;
    for($i = 0; $i < count($_SESSION['panier']['libelleProduit']); $i++)
    {
        $total += $_SESSION['panier']['qteProduit'][$i] * $_SESSION['panier']['prixProduit'][$i];
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
    return count($_SESSION['panier']['libelleProduit']);
    else
    return 0;
}

?>