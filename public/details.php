<?php
require __DIR__.'/../src/bootstrap.php';

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

?>
<!DOCTYPE html>
<?php view('header', ['title' => 'Details']) ?>
    <body>
        <?php
        if (isset($_SESSION['user'])){
            $idPost = $_GET['id'];
            $queryString = "SELECT * FROM Articles WHERE id = " . $idPost;
            $query = $pdo->prepare($queryString);
            $query->execute();
            $post=$query->fetch();
            ?>

            <form action="" method="POST">
                <h1><?=$post['title']?></h1>
                <div>
                    <?=$post['content']?>
                </div>
                <div>
                    <?=$post['category']?>
                </div>
                <button type="submit" name="like">Like</button>
                <button type="submit" name="favori">Favori</button>
            </form>
            <?php
                $error=false;
                if (isset($_POST['like']) || isset($_POST['favori'])) {
                    echo "HEre";
                }
        }else{
            ?>
            <div>  
                <h1 class="Message">You are not connected</h1>
                <input  type="button" onclick="document.location='./register.php'" value="Register" class="lonelyBtn"/>  
                <input  type="button" onclick="document.location='./login.php'" value="Login" class="lonelyBtn"/>
            </div>
            <?php 
        }
        ?>
    </body>
<?php view('footer') ?>