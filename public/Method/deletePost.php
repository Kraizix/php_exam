<?php
require "../../config/db.php";
session_start();

$idPost= $_GET['id'];

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
    unset($_SESISON['LastPage']);
    header('Location: http://localhost:8080/'.$destination);
}else{
    header('Location: http://localhost:8080/home.php');
}
exit();