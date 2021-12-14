<?php
    
?>
<?php view('header', ['title' => 'NEw']) 
$queryString="SELECT * FROM ARTICLES"
$results = $pdo->prepare($query);
$results->execute();
$posts=$results->fetchAll();
foreach $posts as 
?>
<body>

</body>    
<?php view('footer') ?>isse
