<?php
$dbName = "forum_php";

$dsn = "mysql:host=localhost:3306;dbname=" . $dbName;
$username = "root";
$password = "";

try{
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e){
    echo "ERROR";
    echo $e->getMessage();
die();
}

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (isset($_SESSION['user'])){
    echo "Welcome ".$_SESSION['user'];
} else {
    echo "Welcome";
}
?>