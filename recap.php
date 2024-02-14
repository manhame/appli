
<?php /*ce fichier doit permettre de lister tous les $product en session et le total obtenu*/
    session_start(); /* on rappelle la session ouverte par l'utilisateur*/
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif des produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    
 
</head>
<body>
    <?php  var_dump($_SESSION);?> <!--on s'assure que le tableau "SESSION" contient des données
permet aussi de voir si le fichier "traitement.php" fonctionne bien et de visualiser comment
nous allons pouvoir appeler notre récap-->
    
    <?php 
        $totalQtt = 0;

        foreach ($_SESSION['products'] as $index => $product) {
            
            $totalQtt+=$product['qtt'];
        }   
  echo  "<nav class='navbar navbar-expand-md navbar-dark bg-dark d-flex justify-content-between pe-3 py-3'>",
           "<ul class='navbar-nav'>",
                "<li class='nav-item'><a class='nav-link' href='index.php'>index.php</a></li>",
                "<li class='nav-item'><a class='nav-link' href='recap.php'>recap.php</a></li>",
             "</ul>",
             "<href='recap.php'>", 
            "<button type='button' class='btn btn-primary position-relative'>
            Panier
                <span class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger'>
                $totalQtt
            </button>",
        "</nav>" ;     

    if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
        echo "<p>aucun produit en session....</p>";
    } /*on vérifie que soit il n'existe pas de clé produit dans la session ou qu'elle est vide
    pour en informer l'utilisateur*/
        else{
            echo "<table class='table table-dark table-striped-columns'>",     /*on initialise un tableau avec ligne d'entête <thead>*/
                    "<thead class='table-primary'>",
                        "<tr>",
                            "<th>#</th>",
                            "<th>Nom</th>",
                            "<th>Prix</th>",
                            "<th>Quantité</th>",
                            "<th>Total</th>",
                        "</tr>",
                    "</thead>",
                    "<tbody>";
                   
            $totalGeneral = 0;
            $totalQtt = 0;
            foreach($_SESSION['products'] as $index=>$product) {
                echo "<tr>",
                        "<td>".$index."</td>",
                        "<td>".$product['name']."</td>",
                        "<td>".number_format($product['price'], 2, ",", "&nbsp;")."&nbsp;€ </td>",
                        "<td>".$product['qtt']." </td>",
                        "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€ </td>",
                    "</tr>";
                $totalGeneral+=$product['total'];
                $totalQtt+=$product['qtt'];
            }   
              
                echo "<tr>",
                        "<td colspan=4>Total général : </td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
                    "</tr>",
                    
//Lien pour supprimer un article du panier
           //     "<a href=traitement.php?action=delete&id=['product']['index'] class='btn btn-danger'>Supprimer cet article</a>",
                    
//Lien pour vider le panier
            //    "<a href=traitement.php?action=clear class='btn btn-danger'>Vider le panier</a>",

    "</tbody>";
                
    "</table>";
               
            }
                           
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>