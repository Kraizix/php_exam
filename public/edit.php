<?php
require __DIR__.'/../src/bootstrap.php';
include '../Config/db.php';
include_once '../src/inc/common.php';  

$idPost = $_GET['id'];

var_dump($_SESSION['LastPage']);
if (isset($_POST['sub'])){
    echo "here";
    switch ($_POST['sub']){
        case 'send':
            echo "SEND";
            
            //serialize category array to insert in db
            $catArray = $_POST['category'];
            $category = serialize($catArray);

            $queryString= 'UPDATE Articles SET title="'.$_POST['title'].'", content="'.$_POST['content'].'"'.", category='".$category."' WHERE id =".$idPost;
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
                unset($_SESSION['LastPage']);
                header('Location: http://localhost:8080/'.$destination);
            }else{
                header('Location: http://localhost:8080/details.php?id='.$idPost);
            }
            break;
        case 'cancel':
            if (isset($_SESSION['LastPage'])){
                $destination = $_SESSION['LastPage'];
                unset($_SESSION['LastPage']);
                header('Location: http://localhost:8080/'.$destination);
            }else{
                header('Location: http://localhost:8080/details.php?id='.$idPost);
            }
            break;
        case 'delete':
            echo "delete";
            $_SESSION['LastPage'] = "home.php";
            header("Location:http://localhost:8080/Method/deletePost.php?id=$idPost");
            exit();
            break;
        case 'back':
            echo "here";
            header("Location:http://localhost:8080/home.php");
            break;

    }
}


$queryString = "SELECT * FROM Articles WHERE id = " . $idPost;
$query = $pdo->prepare($queryString);
$query->execute();
$post=$query->fetch();

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
                        <div class="ui card centered" style="transform:scale(1.5); margin-top:10%;">
                            <div class="content">
                                <div class="header">
                                    <input type="text" name="title" value="<?=$post['title']?>"/>
                                </div>
                                <div class="meta">
                                    <?php
                                    $catArray = unserialize($post["category"]);
                                    var_dump($post["category"]);
                                    ?>
                                    <select name="category[]" class="ui selection dropdown" multiple="" id="multi-select">
                                        <option value="">Categories</option>    
                                        <option value="informatique" <?php if(in_array("informatique",$catArray)){?> selected="selected"<?php }?>>Informatique</option>
                                        <option value="new" <?php if(in_array("new",$catArray)){?> selected="selected"<?php }?>>New</option>
                                        <option value="anime" <?php if(in_array("anime",$catArray)){?> selected="selected"<?php }?>>Anime</option>
                                        <option value="event" <?php if(in_array("event",$catArray)){?> selected="selected"<?php }?>>Event</option>
                                        <option value="test" <?php if(in_array("test",$catArray)){?> selected="selected"<?php }?>>Test</option>
                                    </select>
                                </div>
                                <div class="description">
                                    <textarea name="content"><?=$post['content']?></textarea>
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="ui three buttons">
                                    <button class="ui basic orange button" type="submit" name="sub" value="cancel">Cancel</button>
                                    <button class="ui basic red button" type="submit" name="sub" value="delete">Delete</button>
                                    <button class="ui basic green button" type="submit" name="sub" value="send">SEND</button>
                                    
                                </div>
                            </div>
                        </div>

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