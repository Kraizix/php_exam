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
            $queryString="UPDATE Articles";
            $queryString.=' SET title="'.$_POST["title"].'", content="'.$_POST["content"].'" ';
            if (isset($_POST['image'])){
                $queryString.=', image="'.$_POST["image"].'" ';
            }
            $queryString.=', category="'.$_POST["category"].'" ';
            $queryString.=" WHERE id = " . $idPost;
            $query= $pdo->prepare($queryString);
            $query->execute();
            header("Location:http://localhost:8080/details.php?id=$idPost");
            break;
        case 'cancel':
            header("Location:http://localhost:8080/details.php?id=$idPost");
            break;
        case 'delete':
            echo "delete";
            header("Location:http://localhost:8080/Method/delete.php?id=$idPost");
            break;
        case 'back':
            echo "here";
            header("Location:http://localhost:8080/details.php?id=$idPost");
            break;

    }
}

?>
<!DOCTYPE html>
<?php view('header', ['title' => 'Edit']) ?>
    <body>
        <?php
        if(isset($post['id'])){
            echo $_SESSION['id'];
            echo $post['userID'];
                ?>
    
                <form method="POST">
                <?php
                if ($_SESSION['id']==$post['userID']){
                ?>
                    <div>
                        <button type="submit" name="sub" value="cancel">Cancel</button>
                    </div>
                    
                    <input type="text" name="title" value="<?=$post['title']?>"/>
                    <div>
                        <textarea name="content"><?=$post['content']?></textarea>
                    </div>
                    <div>
                        <select name="category" id="category">
                            <option value="<?=$post['category']?>">--<?=strtoupper($post['category'])?>--</option>
                            <option value="informatique">Informatique</option>
                            <option value="new">New</option>
                            <option value="anime">Animé</option>
                            <option value="event">Evènement</option>
                        </select>
                    </div>
                    
                    <button type="submit" name="sub" value="send">SEND</button>
                    <button type="submit" name="sub" value="delete">Delete</button>

                    <?php
                    }else{
                        ?>
                        <div>  
                            <h1 class="Message">MDR t'es qui en fait ? T'as cru pouvoir modifier un truc qui n'est pas à toi?</h1>
                            <h1  class="Message">Allez la racaille ça dégage !!</h1> 
                            <button type="submit" name="sub" value="back" >BACK</button>
                        </div>
                        <?php 
                    }
                    ?>
                </form>
            <?php
        }else{
            echo "Sorry ce post n'existe pas";
        }
        ?>
    </body>
<?php view('footer') ?>