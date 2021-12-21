<?php
require __DIR__.'/../src/bootstrap.php';
include_once '../src/inc/common.php';  
include '../config/db.php';

if (isset($_POST)){
    
    $_SESSION['LastPage']="adminPanel.php";
    if (isset($_POST['deletePost'])){
        header("Location:http://localhost:8080/Method/deletePost.php?id=".$_POST['deletePost']);
    }else if (isset($_POST['deleteUser'])){
        header("Location:http://localhost:8080/Method/deleteUser.php?id=".$_POST['deleteUser']);
    }else if (isset($_POST['modifPost'])){
        header("Location:http://localhost:8080/edit.php?id=".$_POST['modifPost']);
    }
}


if (!isset($_SESSION['user'])){
    header("Location: http://localhost:8080/login.php");
}else if (!$_SESSION['admin']){
    ?>
        <h1>Vous n'avez rien à faire ici, SORTEZ !</h1>
        <input  type="button" onclick="document.location
        ='./login.php'" value="Login" class="lonelyBtn"/>
    <?php
}else{
    ?>
    <h1>Bienvenu cher Admin !</h1>

    <form method="post">
        <h2>All Articles</h2>
        <?php
        // query all articles
        $queryString="SELECT * FROM articles ORDER BY date ASC";
        $query= $pdo->prepare($queryString);
        $query->execute();
        $articles = $query->fetchAll();
        foreach($articles as $article){
            ?>
            <div class="ui raised link card">
                <div class="content">
                    <div class="header"><?= $article['title'] ?></div>
                    <div class="meta">
                        <?php
                        $catArray = unserialize($article["category"]);
                        foreach ($catArray as $category) { ?>
                        <div class="ui label"><?= $category ?></div>
                        <?php } ?>
                    </div>
                    <div class="description">
                        <p><?= $article["content"]?></p>
                    </div>
                </div>
                <div class="extra content">
                    By User_<?= $article["userID"] ?> -- <?= $article["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                </div>
                <div>           
                    <button type="submit" name="deletePost" value="<?=$article["id"]?>">Delete</button>
                    <button type="submit" name="modifPost" value="<?=$article["id"]?>">Edit</button>
                </div>
            </div>
            

            <?php
        }
        ?>
        <hr>

        <h2>All Users</h2>
        <?php
        //query all users
        $queryString="SELECT * FROM users ORDER BY joinDate ASC";
        $query= $pdo->prepare($queryString);
        $query->execute();
        $users = $query->fetchAll();
        foreach($users as $user){
    ?>
            <div class="ui special cards">
                <div class="card">
                    <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                        <div class="center">
                            <button class="ui inverted button" type="submit" name="deleteUser" value="<?=$user["id"]?>">Kill him/her</button>
                        </div>
                        </div>
                    </div>
                    <img src="<?= $user["image"]?>">
                    </div>
                    <div class="content">
                    <a class="header"><?= $user["username"]?></a>
                    <div class="meta">
                        <span class="date">Join us on <?= $user["joinDate"]?></span>
                    </div>
                    </div>
                    <div class="extra content">
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </form>
    <?php
}?>
<script>
$('.special.cards .image').dimmer({
  on: 'hover'
});
</script>