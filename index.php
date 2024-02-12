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
     $totalQtt = 0;
     foreach($_SESSION['products'] as $index=>$product) {
         $totalQtt+=$product['qtt'];
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


    <h1>Ajouter un produit</h1>
    <form action="traitement.php" method="post">
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
        <p>
            <label for="exampleInputNumber1"class="form_label">
                Quantité de produits :
                </label>    
                <input type="number" class="form-control" name="qtt" value="1">
           
        </p>
        <p>
            <input type="submit" class="btn btn-primary" name="submit" value="Ajouter un produit">
            
        </p>
<?php
if(!isset($_SESSION['products']) || empty($_SESSION['products'])) {
    echo "<div class='alert alert-warning' role='alert'>
        aucun produit en session 
        </div>";
}
    else {
        echo "<div class='alert alert-warning' role='alert'>
        sucessfull ! 
        </div>";    
    }
       
?>        
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>