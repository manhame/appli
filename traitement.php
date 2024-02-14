<?php
    SESSION_start();
    

    if(isset($_GET['action'])){
        // on vérifie qu'on a bien une ACTION
                      
        switch($_GET['action']){ //on compare aux différentes actions pour déclencher la fonction correspondante
            
 //FONCTIONNALITE AJOUT DE PRODUIT
case 'add':
    if (isset($_POST['submit'])) {
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, "price", FILTER_VALIDATE_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $qtt = filter_input(INPUT_POST, "qtt", FILTER_VALIDATE_INT);

        if ($name && $price && $qtt) {
            $product = [
                "name" => $name,
                "price" => $price,
                "qtt" => $qtt,
                "total" => $price * $qtt,
            ];

            if (!isset($_SESSION['products'])) {
                $_SESSION['products'] = [];
            }

            // Vérifie si le produit existe déjà dans le panier
            $productExists = false;
            foreach ($_SESSION['products'] as $index => $product) {
                if ($product['name'] === $name) {
                    $_SESSION['products']['qtt'] += $qtt;
                    $_SESSION['products']['total'] += $product['total'];
                    $productExists = true;
                    break;
                }
            }

            if (!$productExists) {
                $_SESSION['products'][] = $product;
            }

            $_SESSION['message'] = "Le produit a bien été ajouté";
        } else {
            $_SESSION['message'] = "Echec, veuillez réessayer";
        }
        header("location:index.php");
        die;
    }
    break;

  //FONCTIONNALITE SUPPRESSION DE PRODUIT              

            case 'delete':
                //Vérifier qu'on a bien une "id" dans l'URL et on la déclare $...
                if(isset($_GET['id'])) {    
                    $productIdToDelete = $_GET['id'];
                                // Parcourir le panier pour trouver l'index de l'article à supprimer
                                foreach($_SESSION['products'] as $index => $product) {
                                    if($product['id'] == $productIdToDelete) {
                                        // Supprimer l'article du panier
                                        unset($_SESSION[$product]["id"]);

                                        $_SESSION['message'] = "L'article a été supprimé du panier.";
                                        header("location:index.php");
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
//FONCTIONNALITE MODIFICATION QUANTITE +
            case 'up_qtt' : up_qtt($_SESSION[$product]['qtt']++);
            break;
// FONCTIONNALITE MODIFICATION QUANTITE -
            case 'down_qtt' :down_qtt($_SESSION[$product]['qtt']--);
            break;         
        }
    }
                  