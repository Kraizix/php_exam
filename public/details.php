<?php
require __DIR__.'/../src/bootstrap.php';
include '../Config/db.php';

?>
<!DOCTYPE html>
<?php view('header', ['title' => 'Details']) ?>
    <body>
        <?php
        
        $idPost = $_GET['id'];

        if (isset($_POST['sub'])){
            switch ($_POST['sub']){ 
                case 'like':
                    echo "Like";
                    break;
                case 'favori':
                    echo "Favori";
                    break;
                case 'delete':
                    echo "Delete";
                    break;
                case 'edit':
                    echo "Edit";
                    header("Location:http://localhost:8080/edit.php/?id=$idPost");
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
                    <?=$post['category']?>
                </div>
                
                <button type="submit" name="sub" value="like">Like</button>
                <button type="submit" name="sub" value="favori">Favori</button>
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