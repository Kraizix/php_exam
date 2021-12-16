<?php
require __DIR__.'/../src/bootstrap.php';
include '../Config/db.php';

$idPost = $_GET['id'];

$queryString = "SELECT * FROM Articles WHERE id = " . $idPost;
$query = $pdo->prepare($queryString);
$query->execute();
$post=$query->fetch();

if (isset($_POST['sub'])){
    switch ($_POST['sub']){
        case 'send':
            echo "SEND";
            $queryString="UPDATE Articles SET title=:title, content=:content,";
            break;
        case 'cancel':
            echo "Cancel";
            break;
    }
}

?>
<!DOCTYPE html>
<?php view('header', ['title' => 'Edit']) ?>
    <body>
        <?php
        if (isset($_SESSION['id'])==$post['userID']){
            ?>

            <form method="POST">
                
                <h1><?=$post['title']?></h1>
                <?php
                if (isset($_SESSION['id'])==$post['userID']){
                ?>
                    <button type="submit" name="sub" value="delete">Delete</button>
                <?php
                }
                ?>
                <div>
                    <textarea ><?=$post['content']?></textarea>
                </div>
                <div>
                    <select name="category" id="category">
                        <option value="">--<?=strtoupper($post['category'])?>--</option>
                        <option value="informatique">Informatique</option>
                        <option value="new">New</option>
                        <option value="anime">Animé</option>
                        <option value="event">Evènement</option>
                    </select>
                </div>
                
                <button type="submit" name="sub" value="send">SEND</button>
                <button type="submit" name="sub" value="cancel">Cancel</button>
            </form>
        <?php
        }else{
            ?>
            <div>  
                <h1 class="Message">MDR t'es qui en fait ? T'as cru pouvoir modifier un truc qui n'est pas à toi?</h1>
                <h1  class="Message">Allez la racaille ça dégage !!</h1>  
                <input  type="button" onclick="document.location='./index.php'" value="cancel" class="lonelyBtn"/>
            </div>
            <?php 
        }
        ?>
    </body>
<?php view('footer') ?>