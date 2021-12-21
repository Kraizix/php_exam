<?php
require __DIR__.'/../src/bootstrap.php';
include '../Config/db.php';
include_once '../src/inc/common.php';  

$idPost = $_GET['id'];

$queryString = "SELECT * FROM Articles WHERE id = " . $idPost;
$query = $pdo->prepare($queryString);
$query->execute();
$post=$query->fetch();

$categories= unserialize($post['category']);
if (isset($_POST['sub'])){
    switch ($_POST['sub']){
        case 'send':
            echo "SEND";
            
            //serialize category array to insert in db
            $catArray = explode(',', $_POST['category']);
            $category = serialize($catArray);

            $queryString= 'UPDATE Articles SET title="'.$_POST['title'].'", content="'.$_POST['content'].'"'.", category='".$category."' WHERE id =".$idPost;

            var_dump($data);
            $query= $pdo->prepare($queryString);
            $query->execute();

            if (isset($_POST['image'])){
                $queryString= "UPDATE Articles SET image=\':image\' WHERE id = :postID";
                $data = [
                    "image" => $_POST['image']
                ];
                $query= $pdo->prepare($queryString);
                $query->execute($data);
            }
            
            if (isset($_SESSION['LastPage'])){
                $destination = $_SESSION['LastPage'];
                unset($_SESISON['LastPage']);
                header('Location: http://localhost:8080/'.$destination);
            }else{
                header('Location: http://localhost:8080/details.php?id='.$idPost);
            }
            break;
        case 'cancel':
            if (isset($_SESSION['LastPage'])){
                $destination = $_SESSION['LastPage'];
                unset($_SESISON['LastPage']);
                header('Location: http://localhost:8080/'.$destination);
            }else{
                header('Location: http://localhost:8080/details.php?id='.$idPost);
            }
            break;
        case 'delete':
            echo "delete";
            header("Location:http://localhost:8080/Method/deletePost.php?id=$idPost");
            break;
        case 'back':
            echo "here";
            header("Location:http://localhost:8080/home.php");
            break;

    }
}

?>
<!DOCTYPE html>

<?php include_once '../src/inc/common.php';   ?>
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
                        Current categories : <?php foreach($categories as $category){ echo $category; } ?>
                        <select name="category" id="category">
                            <option value="<?=$category?>">--Category--</option>
                            <option value="informatique">Informatique</option>
                            <option value="new">New</option>
                            <option value="anime">Animé</option>
                            <option value="event">Evènement</option>
                            <option value="test">TEST</option>
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