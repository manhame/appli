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
            header("location:index.php");
            die;
        
        }
        else {
            $_SESSION['message'] = "Echec, veuillez réessayer";
            header("location:index.php"); /*si les conditions ne sont pas remplies -false, null, 0- redirection sur le fichier d'origine*/
            die;
        }
    }

    if(isset($_GET['action'])){
        // on vérifie qu'on a bien une ACTION
                      
        switch($_GET['action']){
            
            case "add" : addProduct($_SESSION[$product]["name"],[$product]["qtt"],[$product]["id"]);

            if(isset($_POST['submit'])) { /*on vérifie si les variables stockées dans le tableau "$_POST" sont du type attendu*/

                $name=filter_input(INPUT_POST,"name",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $price=filter_input(INPUT_POST,"price",FILTER_VALIDATE_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
                $qtt=filter_input(INPUT_POST,"qtt",FILTER_VALIDATE_INT);
                $description=filter_input(INPUT_POST,"description",FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
                if($name&&$price&&$qtt&&description) {
                   
                    $product=[                /*on déclare la var $product qui est un tableau de type clés=>valeurs*/
                        "name"=>$name,
                        "price"=>$price,
                        "qtt"=>$qtt,
                        "description"=>$description, /*on ajoute une description qui contiendra le message retour*/
                        "total"=>$price*$qtt, /*on ajoute la valeur supplémentaire du cahier des charges*/
                    ];
                    clear($_SESSION['products']); /*on vide le panier avant , au bon endroit ?*/
                    $_SESSION['products'][]=$product; /*on enregistre la var $product, un tableau, dans la session, 
                    un autre tableau contenant des "products" au pluriel*/
                    $_SESSION['message'] = "Le produit a bien été ajouté";
                    header("location:index.php");
                    die;
                
                }
                else {
                    $_SESSION['message'] = "Echec, veuillez réessayer";
                    header("location:index.php"); /*si les conditions ne sont pas remplies -false, null, 0- redirection sur le fichier d'origine*/
                    die;
                }    
            }
                break;

            case "delete" : deleteProduct($_SESSION)[$product]["index"];

                    $_SESSION['message'] = "Le produit a été supprimé";
                break;

            case "clear" : clear($_SESSION)["products"];
                    $_SESSION['message'] = "Votre panier est vide";
                break;

        //Plus un
            case "up_qtt" : up_qtt($_SESSION[$product_index]['qtt']++);
                break;
                    
        //Moins un
            case "down_qtt" :dow_qtt($_SESSION[$product_index]['qtt']--);
                break;         
        }
    }
                  