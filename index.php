<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <title>Ajout produit</title>
</head>
<body>
    <?php 
    session_start();

    //on garde ce code ici car on utilise la var $totalQtt juste après...
    // >>>>>>>>>> On vérifie d'abord s'il y a des produits en session <<<<<<<<<<<<<<< 
    if(isset($_SESSION['products'])) {
    $totalQtt = 0;
        foreach($_SESSION['products'] as $index=>$product) {
            $totalQtt+=$product['qtt'];
        }
    }       
    ?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark d-flex justify-content-between pe-3 py-3">
<ul class="navbar-nav ">
          <li class="nav-item"><a class="nav-link" href="index.php">index.php</a></li>
          <li class="nav-item"><a class="nav-link" href="recap.php">recap.php</a></li>
    </ul>
          <a href="recap.php"><button type="button" class="btn btn-primary position-relative">
              Panier
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $totalQtt ?>
                </button></a>
            </nav>        


    <h1>Commande</h1>
    <form action="traitement.php?action=add" method="post">
        <p>
            <label for="exampleInputText1"class="form_label">
                Nom du produit :
                </label>   
                <input type="text" class="form-control" name="name">
                
        </p>
        <p>
            <label for="exampleInputNumber1"class="form_label">
                Prix du produit :
                </label>
                <input type="number" class="form-control" step="any" name="price">
            
        </p>
            <label for="exampleInputNumber2"class="form_label">
                Quantité :
                </label>
                <input type="number" class="form-control" step="any" name="qtt">
        
        <p>
            <input type="submit" class="btn btn-primary" name="submit" value="Valider">
            
        </p>

        <label for="input-group"class="form_label">
                    Quantité de produits :
        </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <button id="decrease" class="btn btn-outline-secondary" type="button">-</button>
            </div>
      
            <input id="quantity" type="submit" class="btn btn-outline-secondary" value="1">
            
            <div class="input-group-append">
                <button id="increase" class="btn btn-outline-secondary" type="button">+</button>
            </div>
        </div>


<!-- script js pour "actionner" les boutons "Bootstrap" pas nécessaire; input type number préférables-->

<script>
    //on "écoute" le click du boutton représenté par "id increase"
    document.getElementById('increase').addEventListener('click', function() {
        //on déclare var "quantity" à modifier
        let quantity = document.getElementById('quantity');
        //on affecte à la valeur de cette var la fonction qui ajoute quantité 1 par 1
        quantity.value = parseInt(quantity.value) + 1;
    });
    //idem pour le bouton "id decrease"
    document.getElementById('decrease-btn').addEventListener('click', function() {
        let quantity = document.getElementById('quantity');
            //on vérifie que "quantity" est supérieure à 1 pour ne pas avoir de valeur négative
            if (parseInt(quantity.value) > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
    });
</script>


<?php

if (isset($_SESSION["message"])){
    echo $_SESSION["message"];
}
     

?>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>