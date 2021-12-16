
<?php view('header', ['title' => 'New']);
include '../Config/db.php';

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
