<?php 
session_start();

include_once("Fonctions-Panier.php");

try 
{
	$mysqlClient = new PDO('mysql:host=localhost:3306;dbname=le_monde_est_vache;charset=utf8', 'root', '');
	$mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
} catch (Exception $e)
{
	die('Erreur  : ' . $e->getMessage());
}
// Vérifiez si le formulaire a été soumis
if (isset($_POST['ajouter'])) {
    // Obtenez les détails du produit à partir du formulaire
    $NomPrd = $_POST['l'];
    $PrixPrd = $_POST['p'];
    $Quantite= $_POST['q'];

    // Ajouter le produit au panier
    for ($i = 0; $i < count($NomPrd); $i++) {
        ajouterArticle($NomPrd[$i], $Quantite[$i], $PrixPrd[$i]);
    }

    // Rediriger vers la page Accueil-E.php
    header('Location: Accueil-E.php');
    exit;
}

// Reste du code pour afficher le panier
include_once("Fonctions-Panier.php");

$erreur = false;

$action = (isset($_POST['action'])? $_POST['action']:  (isset($_GET['action'])? $_GET['action']:null )) ;
if($action !== null)
{
   if(!in_array($action,array('ajout', 'suppression', 'refresh')))
   $erreur=true;

   //récupération des variables en POST ou GET
   $l = (isset($_POST['l'])? $_POST['l']:  (isset($_GET['l'])? $_GET['l']:'' )) ;
   $p = (isset($_POST['p'])? $_POST['p']:  (isset($_GET['p'])? $_GET['p']:null )) ;
   $q = (isset($_POST['q'])? $_POST['q']:  (isset($_GET['q'])? $_GET['q']:null )) ;

   //Suppression des espaces verticaux
   $l = preg_replace('#\v#', '',$l);
   //On vérifie que $p est un float
   $p = floatval($p);

   //On traite $q qui peut être un entier simple ou un tableau d'entiers
    
   if (is_array($q)){
      $QteArticle = array();
      $i=0;
      foreach ($q as $contenu){
         $QteArticle[$i++] = intval($contenu);
      }
   }
   else
   $q = intval($q);
    
}

if (!$erreur){
   switch($action){
      Case "ajout":
         ajouterArticle($l,$q,$p);
         break;

      Case "suppression":
         supprimerArticle($l);
         break;

      Case "refresh" :
         for ($i = 0 ; $i < count($QteArticle) ; $i++)
         {
            modifierQTeArticle($_SESSION['panier']['NomPrd'][$i],round($QteArticle[$i]));
         }
         break;

      Default:
         break;
   }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
	    <meta charset="utf-8">
	    <title>Panier-E</title>
	    <link rel="stylesheet" type="text/css" href="Panier-E.css"/>
    </head>
    <body>
        <form method="post" action="Panier-E.php">
            <table style="width: 400px">
            <tr>
                <td colspan="4">Votre panier</td>
            </tr>
            <tr>
                <td>Libellé</td>
                <td>Quantité</td>
                <td>Prix Unitaire</td>
            </tr>
            <?php
            if (creationPanier())
            {
                $nbArticles=count($_SESSION['panier']['NomPrd']);
                if ($nbArticles <= 0)
                echo "<tr><td>Votre panier est vide </ td></tr>";
                else
                {
                    for ($i=0 ;$i < $nbArticles ; $i++)
                    {
                        echo "<tr>";
                        echo "<td>".htmlspecialchars($_SESSION['panier']['NomPrd'][$i])."</ td>";
                        echo "<td><input type=\"text\" size=\"4\" name=\"q[]\" value=\"".htmlspecialchars($_SESSION['panier']['Quantite'][$i])."\"/></td>";
                        echo "<td>".htmlspecialchars($_SESSION['panier']['PrixPrd'][$i])."</td>";
                        echo "<td><a href=\"".htmlspecialchars("Panier-E.php?action=suppression&l=".rawurlencode($_SESSION['panier']['NomPrd'][$i]))."\">XX</a></td>";
                        echo "</tr>";
                    }

                echo "<tr><td colspan=\"2\"> </td>";
                echo "<td colspan=\"2\">";
                echo "Total : ".MontantGlobal();
                echo "</td></tr>";

                echo "<tr><td colspan=\"4\">";
                echo "<input type=\"submit\" value=\"Rafraichir\"/>";
                echo "<input type=\"hidden\" name=\"action\" value=\"refresh\"/>";

                echo "</td></tr>";
                }
            }
            ?>
            </table>
        </form>
    </body>
</html>