<?php /*ce fichier doit permettre de lister tous les $product en session et le total obtenu*/
    session_start(); /* on rappelle la session ouverte par l'utilisateur*/
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
</head>
<body>
    <?php var_dump($_SESSION);?> <!--on s'assure que le tableau "SESSION" contient des données
permet aussi de voir si le fichier "traitement.php" fonctionne bien et de visualiser comment
nous allons pouvoir appeler notre récap-->
    
    <?php 

    if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        echo "<p>aucun produit en session....</p>";
    } /*on vérifie que soit il n'existe pas de clé produit dans la session ou qu'elle est vide
    pour en informer l'utilisateur*/
        else{
            echo "<table>",     /*on initialise un tableau avec ligne d'entête <thead>*/
                    "<thead>",
                        "<tr>",
                            "<th>#</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th>Quantité</th>",
                            "<th>Total</th>",
                        "</tr>",
                    "<thead>",
                    "</tbody>";
            $totalGeneral = 0;
            foreach($_SESSION['products'] as $index=>$product) {
                echo"<tr>",
                        "<td>".$index."</td>",
                        "<td>".$product['name']."</td",
                        "<td>".number_format($product['price'],2,",","&nbsp;")."&nbsp;€</td",
                        "<td>".$product['qtt']."</td",
                        "<td>".number_format($product['total'],2,",","&nbsp;")."&nbsp;€</td",
                    "</tr>";
                $totalGeneral+=$product['total'];
            }   
                echo "<tr>",
                        "<td colspan=4>,Total général : </td>",
                        "<td><strong>".number_format($totalGeneral,2,",","&nbsp;")."&nbsp;€</strong></td>",
                      "</tr>",
                    "</tbody",
                
                   "</table>";
                    
            }


          ?>
</body>
</html>