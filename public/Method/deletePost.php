<?php
require "../../config/db.php";
session_start();
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

$idPost= $_GET['id'];

$queryString= "SELECT userID FROM Articles WHERE id=". $idPost;
$query= $pdo->prepare($queryString);
$query->execute();
$post=$query->fetch();

$userID=$post['userID'];

if ($_SESSION['admin'] || ($_SESSION['id']==$userID)){
    $queryString= "DELETE FROM Favs WHERE postID=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

    $queryString= "DELETE FROM Comments WHERE postID=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

    $queryString= "DELETE FROM Articles WHERE id=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

    try {
        deleteTree("../content/posts/".$idPost);
    } catch (PDOException $e) {}
    if (isset($_SESSION['LastPage'])){
        $destination = $_SESSION['LastPage'];
        unset($_SESSSON['LastPage']);
        header('Location: ../'.$destination);
        exit();
    }else{
        header('Location: ../home.php');
        exit();
    }
}else{
    echo "Eh... T'es qui en fait?";
}

exit();