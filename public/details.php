<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';
include_once '../src/inc/common.php';  
view('header', ['title' => 'Details'])
?>


<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="./css/details.css" />
    </head>
    <body>
        <?php
        
        $idPost = $_GET['id'];

        $queryString = "SELECT Articles.id, title, content, Articles.image AS postImage, category, date, Articles.userID, pinned, Users.image AS avatar, Users.username FROM Articles
        INNER JOIN Users ON Articles.userID=Users.id WHERE Articles.id = " . $idPost;
        $query = $pdo->prepare($queryString);
        $query->execute();
        $post=$query->fetch();

        $commentText = "Express your self";
        if (isset($_POST['sub'])){
            if (isset($_POST['comment'])){
                $commentText = $_POST['comment'];
                if ($commentText ==""){
                    header("Location:details.php?id=$idPost");
                    exit;
                }
            }
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
                    $_SESSION['LastPage'] = "home.php";
                    header("Location:Method/deletePost.php?id=$idPost");
                    break;
                case 'edit':
                    echo "Edit";
                    $_SESSION['LastPage']="details.php?id=$idPost";
                    header("Location:edit.php?id=$idPost");
                    break;
                case 'back':
                    echo "here";
                    header("Location:home.php");
                    break;
                case "reply":
                    echo "Reply";
                    $data = [
                        "content" => $commentText,
                        "date" => date("Y-m-d H:i:s"),
                        "postID" => $idPost,
                        "userID" => $_SESSION['id'],
                    ];
                    $queryString = "INSERT INTO Comments (content, date, postID, userID) VALUES (:content, :date, :postID, :userID)";
                    $query = $pdo->prepare($queryString);
                    $query->execute($data);

                    $commentText = "Express your self";

            }
        }

        if (isset($_SESSION['user'])){

            ?>

            <form method="POST">
                <div class="Post">
                    <div class="ui card centered Post" style="transform:scale(1.2); margin-top:10%;">
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
                                <div><img style="max-width: 100px; max-height: 100px" src="<?= $post["postImage"]?>"/></div>
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
                </div>
                                
                <div class="Comments">
                        <div class="ui threaded Comments " >
                        <h3 class="ui dividing header">Comments</h3>
                            <div class="field">
                                <textarea name="comment" placeholder="<?= $commentText?>" maxlength="100"></textarea>
                                <button type="submit" name="sub" value="reply" class="ui blue labeled submit icon button">
                                    <i class="icon edit"></i> Add Reply
                                </button>
                            </div>
                        <?php 
                            $queryString = "SELECT * FROM Comments WHERE postID = ". $idPost;
                            $query = $pdo->prepare($queryString);
                            $query->execute();
                            $comments=$query->fetchAll();
                            foreach ($comments as $comment){
                                $queryString = "SELECT username, image FROM Users WHERE id = ".$comment['userID'];
                                $query = $pdo->prepare($queryString);
                                $query->execute();
                                $commentUser = $query->fetch();

                                $originalDate = date("Y-m-d H:i:s");
                                $timestamp = strtotime($originalDate); 
                                $hour = date("H:i", $timestamp );
                                $day = date("d/m/Y", $timestamp);
                                ?>

                                <div class="comment">  
                                    <div class="content">
                                        <img class="ui avatar image" src="<?= $commentUser['image'] ?>">
                                        <a class="author" href="/account.php?id=<?=$comment['userID']?>"><?= $commentUser['username'] ?></a>
                                        
                                            <span class="date"><?= "At ".$hour." on the ".$day?></span>
                                    </div>
                                        
                                        <div class="text">
                                            <?= $comment['content'] ?>
                                        </div>
                                </div>
                                <?php
                            }
                        ?>
                            
                    </div>
                    <div>
                        <button type="submit" name="sub" value="back" >BACK</button>
                    </div>
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