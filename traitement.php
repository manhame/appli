<?php
    session_start();

    if(isset($_POST['submit'])) { /*on vérifie si les variables stockées dans le tableau "$_POST" sont du type attendu*/

        $name=filter_input(INPUT_POST,"name",FILTER_SANITIZE_STRING);
        $price=filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
        $qtt=filter_input(INPUT_POST,"qtt",FILTER_VALIDATE_INT);

        if($name&&$price&&$qtt) {
           
            $product=[                /*on déclare la var $product qui est un tableau de type clés=>valeurs*/
                "name"=>$name,
                "price"=>$price,
                "qtt"=>$qtt,
                "total"=>$price*$qtt, /*on ajoute la valeur supplémentaire du cahier des charges*/
            ];
            $_SESSION['products'][]=$product; /*on enregistre la var $product, un tableau, dans la session, 
            un autre tableau contenant des "products" au pluriel*/
            $_SESSION['message'] = "Le produit a bien été ajouté";
        }
    }

    header("location:index.php"); /*si les conditions ne sont pas remplies -false, null, 0- redirection sur le fichier d'origine*/