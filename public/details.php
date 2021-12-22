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
                <div class="ui card centered" style="transform:scale(1.5); margin-top:10%;">
                    <div class="content">
                        <div class="header"><?= $post['title'] ?></div>
                        <div class="meta">
                            <?php
                    $catArray = unserialize($post["category"]);
                    foreach ($catArray as $category) { ?>
                            <div class="ui label"><?= $category ?></div>
                            <?php } ?>
                        </div>
                        <div class="description">
                            <p><?= $post["content"]?></p>
                        </div>
                    </div>
                    <div class="extra content">
                        <img class="ui avatar image" src="<?= $post["avatar"] ?>"> By <?= $post["username"] ?> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                    </div>
                    <div class="extra content">
                        <div class="ui three buttons">
                            <?php
                                if ($post["userID"]==$_SESSION["id"]){?>
                                    <button class="ui basic green button" type="submit" name="sub" value="edit">Edit</button>
                                    <button class="ui basic red button" type="submit" name="sub" value="delete">Delete</button>
                                <?php }else {?>
                                    <button class="ui basic green button disabled" type="submit" name="sub" value="edit">Edit</button>
                                    <button class="ui basic red button disabled" type="submit" name="sub" value="delete">Delete</button>
                                <?php
                                }
                            ?>
                            
                            
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
                                    <button class="ui basic blue button" type="submit" name="sub" value="favori-del">Delete Favori</button>
                                <?php
                                }else if (!$ok){?>
                                    <button class="ui basic blue button" type="submit" name="sub" value="favori-add">Add Favori</button>
                                <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
                

                <div>
                    <button type="submit" name="sub" value="back" >BACK</button>
                </div>
                
                
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