<?php
require "../../config/db.php";
session_start();

$idUser= $_GET['id'];

$queryString= "SELECT * FROM Articles WHERE userID=". $idUser;
$query= $pdo->prepare($queryString);
$query->execute();
$articles = $query->fetchAll();
foreach ($articles as $article){
    $queryString= "DELETE FROM Comments WHERE postID=". $article['id'];
    $query= $pdo->prepare($queryString);
    $query->execute();

    $queryString= "DELETE FROM Articles WHERE id=". $article['id'];
    $query= $pdo->prepare($queryString);
    $query->execute();
}

$queryString= "DELETE FROM Favs WHERE userID=". $idUser;
$query= $pdo->prepare($queryString);
$query->execute();

$queryString= "DELETE FROM Users WHERE id=". $idUser;
$query= $pdo->prepare($queryString);
$query->execute();

if (isset($_SESSION['LastPage'])){
    $destination = $_SESSION['LastPage'];
    unset($_SESISON['LastPage']);
    header('Location: http://localhost:8080/'.$destination);
}else{
    header('Location: http://localhost:8080/home.php');
}
exit();