
<?php

//Fichier qui traite des éléments non visibles

//https://www.php.net/manual/fr/intro.session.php

    session_start();
    

    if(isset($_GET['action'])){
        // on vérifie qu'on a bien une ACTION
                      
        switch($_GET['action']){ //on compare aux différentes actions pour déclencher la fonction correspondante
            
 //FONCTIONNALITE AJOUT DE PRODUIT
case 'add':
    if (isset($_POST['submit'])) {
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

        if ($name && $price && $qtt) {
            $product = [
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price*$qtt,
            ];
            $_SESSION['products'][]=$product;
            
            $_SESSION['message']="Le produit a bien été ajouté";
            header("location:index.php");
            die;
        }
            else {
            $_SESSION['message']="Echec";
            header("location:index.php");
            die;    
            }

    }

    if (isset($_POST['add'])) {
        // Récupérer les détails du nouveau produit à partir des données soumises par l'utilisateur
        $new_product_name = $_POST['new_product_name'];
        $new_product_price = $_POST['new_product_price'];
        $new_product_quantity = $_POST['new_product_quantity'];
    
        // Créer le nouvel objet $newProduct
        $newProduct = [
            "name" => $new_product_name,
            "price" => $new_product_price,
            "qtt" => $new_product_quantity,
            "total" => $new_product_price * $new_product_quantity
        ];
    
    }
    
    //ajouter un produit existant à un produit de même nom et de même prix

// Parcourir les produits dans le panier
$productExists = false;
foreach ($_SESSION['products'] as $index => $product) {
    // Vérifier si un produit identique (même nom et même prix) existe déjà dans le panier
    if ($product['name'] === $newProduct['name'] && $product['price'] === $newProduct['price']) {
        // Mettre à jour la quantité du produit existant
        $_SESSION['products'][$index]['qtt'] += $newProduct['qtt'];
        $_SESSION['products'][$index]['total'] += $newProduct['total'];
        $productExists = true;
        break;
    }
}

// Si le produit n'existe pas encore dans le panier, l'ajouter
if (!$productExists) {
    $_SESSION['products'][] = $newProduct;
}

    

  //FONCTIONNALITE SUPPRESSION DE PRODUIT              

            case 'delete':
                //Vérifier qu'on a bien une "id" dans l'URL et on la déclare $...
                if(isset($_GET['id'])) {    
                    $productIdToDelete = $_GET['id'];
                                // Parcourir le panier pour trouver l'index de l'article à supprimer
                                foreach($_SESSION['products'] as $index => $product) {
                                    if($index == $productIdToDelete) {
                                        // Supprimer l'article du panier
                                        unset($_SESSION['products'][$index]);

                                        $_SESSION['message'] = "L'article a été supprimé du panier.";
                                        header("location:recap.php");
                                        die; // Terminer le script après la redirection
                                    }
                                }
                }
            break;
  //FONCTIONNALITE SUPPRESSION DE TOUS LES PRODUITS               
            case 'clear' : 
                unset($_SESSION["products"]);

                $_SESSION['message'] = "Le panier est vide.";
                header("location:index.php");
                die;
            break;


// FONCTIONNALITE MODIFICATION QUANTITE +
case 'up_qtt':
    if (isset($_GET['id'])) {
        $productIdToUpdate = $_GET['id'];
        foreach ($_SESSION['products'] as $index => $product) {
            if ($index == $productIdToUpdate) {
                $_SESSION['products'][$index]['qtt']++;
                $_SESSION['message'] = "La quantité a été augmentée.";
                header("location:recap.php");
                die; // Fin du script après redirection
            }
        }
    }
    break;
// FONCTIONNALITE MODIFICATION QUANTITE -
case 'down_qtt':
    if (isset($_GET['id'])) {
        $productIdToUpdate = $_GET['id'];
        foreach ($_SESSION['products'] as $index => $product) {
            if ($index == $productIdToUpdate && $_SESSION['products'][$index]['qtt'] > 1) {
                $_SESSION['products'][$index]['qtt']--;
                $_SESSION['message'] = "La quantité a été diminuée.";
                header("location:recap.php");
                die; 
            }
        }
    }
    break;
}        
        }

        if (isset($_POST['update_quantities'])) {
            // Parcourir les produits dans le panier
            foreach ($_SESSION['products'] as $index => $product) {
                // Vérifier si la quantité a été modifiée pour ce produit
                if (isset($_POST['quantity_' . $index])) {
                    $new_quantity = intval($_POST['quantity_' . $index]);
                    // Mettre à jour la quantité du produit dans le panier
                    $_SESSION['products'][$index]['qtt'] = $new_quantity;
                    // Mettre à jour la valeur totale du produit
                    $_SESSION['products'][$index]['total'] = $new_quantity * $product['price'];
                }
            }
            
            // Recalculer la quantité totale dans le panier
            $total_quantity = array_sum(array_column($_SESSION['products'], 'qtt'));
            $_SESSION['totalQtt'] = $total_quantity;
        
            // Recalculer la valeur totale du panier
            $total_price = array_sum(array_column($_SESSION['products'], 'total'));
            $_SESSION['totalGeneral'] = $total_price;
        
            $_SESSION['message'] = "Les modifications ont été enregistrées.";
            header("location: recap.php");
            die; // Terminer le script après la redirection
        }
        