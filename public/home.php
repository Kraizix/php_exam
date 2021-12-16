
<?php view('header', ['title' => 'New']);
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

$queryString="SELECT * FROM Articles";
$results = $pdo->prepare($query);
$results->execute();
$posts=$results->fetchAll();

foreach ($posts as $post){
    ?>

    <?php
}
?>
<body>

</body>    
<?php view('footer') ?>
