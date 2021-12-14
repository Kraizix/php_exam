<?php
$dsn = "mysql:host=localhost:3306;dbname=forum_php";
$pdo = new pdo($dsn, "root", ""); // Connexion à la db "php_exam"
// si vous avez une erreur ici, remplacez le deuxième "root" par une string vide

$result = $pdo->query("SELECT * FROM users"); // On utilise l'instance créée pour faire une requête bidon
echo print_r($result);
?>