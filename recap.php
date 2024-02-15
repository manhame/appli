
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    
 
</head>
<body>

<form method="post" action="traitement.php">

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
                        "<td>",
            // Boutons pour augmenter et diminuer la quantité
                        "<input type='number' name='quantity_" . $index . "' min='1' value='" . $product['qtt'] . "'>",
                      /*  "<button type='submit' name='up_quantity' value='<?php echo $index; ?>'>+</button>",*/
                       /* "<button type='submit' name='down_quantity' value='<?php echo $index; ?>'>-</button>",*/
        
                        "</td>",
                        "<td>".number_format($product['total'], 2, ",", "&nbsp;")."&nbsp;€ </td>",
                        "<td><i><a class='fa-solid fa-trash-can' href='traitement.php?action=delete&id=".$index."'></a></i></td>",
                    "</tr>";
                $totalGeneral+=$product['total'];
                $totalQtt+=$product['qtt'];
            }   
                echo "<tr>",
                        "<td colspan=4>Total général : </td>",
                        "<td><strong>".number_format($totalGeneral, 2, ",", "&nbsp;")."&nbsp;€</strong></td>",
                        "<td><a href='traitement.php?action=clear'>Supprimer tous les produits</a></td>",

                    "</tr>",

                    "<tr>",
                        "<td colspan=6>
                        <button type='submit' name='update_quantities'>Valider les modifications</button>
                        </td>",
                    "</tr>";

                  /*  TENTATIVE DE LIER avec "traitement.php" DANS LE CAS D'AJOUT D'UN PRODUIT IDENTIQUE POUR NE PAS CREER DE LIGNE SUP
                  "<tr>";
                    "<td colspan=6>
                        <h3>Ajouter un nouveau produit</h3>";
                        "<input type='text' name='new_product_name' placeholder='Nom du produit'>";
                        "<input type='text' name='new_product_price' placeholder='Prix du produit'>";
                        "<input type='text' name='new_product_quantity' placeholder='Quantité'>";
                        "<button type='submit' name='add'>Ajouter</button>";
                    "</td>";
                    "</tr>";
                   */ 
                    // Affichage des messages de la session
                    if (isset($_SESSION["message"])) {
                    echo "<tr><td colspan='6'>" . $_SESSION["message"] . "</td></tr>";
                    unset($_SESSION["message"]); // Supprimer le message de la session après l'avoir affiché
}
                    
                "</tbody>";
                
                "</table>";
            }
                           
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</form>
     
</body>
</html>