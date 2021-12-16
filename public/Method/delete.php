<?php
require "../../config/db.php";
session_start();

$idPost= $_GET['id'];

$queryString= "DELETE FROM Articles WHERE id=". $idPost;
$query= $pdo->prepare($queryString);
$query->execute();

header('Location: http://localhost:8080');
exit();