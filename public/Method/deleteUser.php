<?php
require "../../config/db.php";
session_start();

$idUser= $_GET['id'];

if ($_SESSION['admin']){
    $queryString= "SELECT * FROM Articles WHERE userID=". $idUser;
    $query= $pdo->prepare($queryString);
    $query->execute();
    $articles = $query->fetchAll();

    $queryString= "DELETE FROM Favs WHERE userID=". $idUser;
    $query= $pdo->prepare($queryString);
    $query->execute();
    
    foreach ($articles as $article){
        try{
            deleteTree("../content/posts/".$article['id']);
        } catch(PDOException $e){
            
        }
        $queryString= "DELETE FROM Comments WHERE postID=". $article['id'];
        $query= $pdo->prepare($queryString);
        $query->execute();

        $queryString= "DELETE FROM Comments WHERE userID=". $idUser;
        $query= $pdo->prepare($queryString);
        $query->execute();

        $queryString= "DELETE FROM Articles WHERE id=". $article['id'];
        $query= $pdo->prepare($queryString);
        $query->execute();
    }


    $queryString= "DELETE FROM Users WHERE id=". $idUser;
    $query= $pdo->prepare($queryString);
    $query->execute();

    if ($idUser == $_SESSION['id']){
        unset($_SESSION['id']);
        unset($_SESSION['user']);
        unset($_SESSION['admin']);
        unset($_SESSION['LastPage']);
    }
    try{
        deleteTree("../content/users/".$idUser);
    } catch(Exception $e){}
    
    if (isset($_SESSION['LastPage'])){
        $destination = $_SESSION['LastPage'];
        unset($_SESSION['LastPage']);
        header('Location: ../'.$destination);
    }else{
        header('Location: ../home.php');
    }
    exit();
}else{
    header('Location: ../home.php');
}

function deleteTree($dir){
    foreach(glob($dir . "/*") as $element) {
        if(is_dir($element)){
            deleteTree($element); // On rappel la fonction deleteTree           
            rmdir($element); // Une fois le dossier courant vidé, on le supprime
        } else { // Sinon c'est un fichier, on le supprime
            unlink($element);
        }
    }
    rmdir($dir);
}
