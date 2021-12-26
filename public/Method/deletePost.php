<?php
require "../../config/db.php";
session_start();

$idPost= $_GET['id'];

$queryString= "SELECT userID FROM Articles WHERE id=". $idPost;
$query= $pdo->prepare($queryString);
$query->execute();
$post=$query->fetch();

$userID=$post['userID'];

if ($_SESSION['admin'] || ($_SESSION['id']==$userID)){
    $queryString= "DELETE FROM Articles WHERE id=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

    $queryString= "DELETE FROM Favs WHERE postID=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

    $queryString= "DELETE FROM Comments WHERE postID=". $idPost;
    $query= $pdo->prepare($queryString);
    $query->execute();

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