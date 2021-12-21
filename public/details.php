<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';
include_once '../src/inc/common.php';  
view('header', ['title' => 'Details'])
?>

<!DOCTYPE html>
    <body>
        <?php
        
        $idPost = $_GET['id'];

        if (isset($_POST['sub'])){
            switch ($_POST['sub']){ 
                case 'favori-add':
                    echo "This post is now amoung your Favorites";
                    $queryString = "INSERT INTO Favs (postID, userID) VALUES (:idPost,:idUser)";
                    $data = [
                        "idPost" => $idPost,
                        "idUser" => $_SESSION['id']
                    ];
                    $query = $pdo->prepare($queryString);
                    $query->execute($data);
                    break;
                case 'favori-del':
                    echo "This post is no longer among your favorites";
                    $queryString = "DELETE FROM Favs  WHERE postID = :idPost AND userID = :idUser";
                    $data = [
                        "idPost" => $idPost,
                        "idUser" => $_SESSION['id']
                    ];
                    $query = $pdo->prepare($queryString);
                    $query->execute($data);
                    break;
                case 'delete':
                    echo "Delete";
                    header("Location:http://localhost:8080/Method/deletePost.php?id=$idPost");
                    break;
                case 'edit':
                    echo "Edit";
                    header("Location:http://localhost:8080/edit.php?id=$idPost");
                    break;
                case 'back':
                    echo "here";
                    header("Location:http://localhost:8080/home.php");
                    break;
            }
        }

        if (isset($_SESSION['user'])){
            $queryString = "SELECT * FROM Articles WHERE id = " . $idPost;
            $query = $pdo->prepare($queryString);
            $query->execute();
            $post=$query->fetch();
            ?>

            <form method="POST">
                <div>
                    <button type="submit" name="sub" value="back" >BACK</button>
                </div>
                <h1><?=$post['title']?></h1>
                <?php
                if (isset($_SESSION['id'])==$post['userID']){
                ?>
                    <button type="submit" name="sub" value="edit">Edit</button>
                    <button type="submit" name="sub" value="delete">Delete</button>
                <?php
                }
                ?>
                <div>
                    <?=$post['content']?>
                </div>
                <div>
                    <?php
                    $carArray = unserialize($post['category']);
                    foreach($carArray as $category) {
                        echo $category." ";
                    }
                    ?>
                </div>
                <?php
                    // requête sql dans favs, je cherche le post ID 
                    $queryString="SELECT * FROM Favs WHERE postID = '".$idPost."'";
                    $query = $pdo->prepare($queryString);
                    $query->execute();
                    $res=$query->fetchAll();
                    // pour chaque resultats:
                    $ok = false;
                    foreach($res as $row) {
                        // Vérifier si le userID est celui du user actuel
                        if ($row['userID'] == $_SESSION['id']){
                            // si c'est le cas, var = tru; break;
                            $ok = true;
                            break;
                        }    
                    }    
                    //si le post est déjà favori (var == true);
                    if ($ok){?>
                        <button type="submit" name="sub" value="favori-del">Delete Favori</button>
                    <?php
                    }else if (!$ok){?>
                        <button type="submit" name="sub" value="favori-add">Add Favori</button>
                    <?php
                    }
                ?>
            </form>
        <?php
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