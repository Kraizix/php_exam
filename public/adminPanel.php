<?php
require __DIR__.'/../src/bootstrap.php';
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
            <h3><?= $article["title"]?></h3>
            <h4><?php
                $catArray = unserialize($article["category"]);
                foreach ($catArray as $category) {
                    echo $category . " ";
                }
            ?></h4>
            <p><?= $article["content"]?></p>
            <h4>By <?= $article["userID"]?> <i> Ajouter le join pour le username plus tard !</i></h4>
            <h4><?= $article["pinned"] == 1 ? "Pinned" : "Not Pinned" ?></h4>
            <div>           
                <button type="submit" name="deletePost" value="<?=$article["id"]?>">Delete</button>
                <button type="submit" name="modifPost" value="<?=$article["id"]?>">Edit</button>
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
            <h3><?= $user["username"]?></h3>
            <img src="<?= $user["image"]?>" style="width : 15%; height : 25%;">
            <p><?= $user["description"] ?> </p>
            <h4>join us on <?= $user["joinDate"]?></h4>
            <p>-----------------------</p>
            |---<button type="submit" name="deleteUser" value="<?=$user["id"]?>">Kill him/her</button>---|
            <p>-----------------------</p>
            <?php
        }
        ?>
    </form>
    <?php
}