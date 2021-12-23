<?php 
require __DIR__.'/../src/bootstrap.php';
include '../src/inc/common.php';
require_once __DIR__ .'./Method/editprofile.php';
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/account.css" />
    <title>Account</title>
</head>
<body>
<?php 
if (isset($_SESSION['user'])){
    $id = isset($_GET["id"]) ? $_GET["id"] : $_SESSION["id"];
    if(isset($_FILES['image'])&& isset($_POST['username'])){
        updateUser($_SESSION['id'],$_FILES['image'], $_POST['username'], $_POST['description'],$_POST['email'],$_POST['password'],$pdo);
    }
?>
        <?php
        $queryString = "SELECT * FROM Users WHERE id = '" .$id."'";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        $date = new DateTime($user['joinDate']);
        ?>
            <div id="info"class="container2">
                <div class="Posts">
                    <h1>Posts :</h1>
                    <div class="postscontent ">
                <?php
                $queryString="SELECT * FROM Articles WHERE userId= '".$id."'";
                $results = $pdo->prepare($queryString);
                $results->execute();
                $posts=$results->fetchAll();
                foreach ($posts as $post){
                ?>
                <a class="ui card centered" href="details.php?id=<?= $post["id"] ?>">
                <div class="ui raised link card centered">
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
                            By User_<?= $post["userID"] ?> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                        </div>
                    </div>
                </a>
                    <?php } ?>
                </div>
                </div>
                <div class="Favs">
                    <h1> Favs : </h1>
                    <div class="favscontent">
                    <?php
                    $queryString="SELECT * FROM Favs WHERE userID= '".$id."'";
                    $results = $pdo->prepare($queryString);
                    $results->execute();
                    $favs=$results->fetchAll();
                    foreach ($favs as $fav){
                        $queryString="SELECT * FROM Articles WHERE id= '".$fav['postID']."'";
                        $results = $pdo->prepare($queryString);
                        $results->execute();
                        $post=$results->fetchAll()[0];
                    ?>
                    
                    <a class="ui card centered" href="details.php?id=<?= $post["id"] ?>">
                        <div class="ui raised link card centered">
                            <div class="content">
                                <div class="header"><?= $post['title']  ?></div>
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
                                By User_<?= $post["userID"] ?> -- <?= $post["pinned"] == 1 ? "Pinned" : "Not Pinned" ?>
                            </div>
                        </div>
                    </a>
                        <?php } ?>
                                </div>

                </div>
                <div class="User">
                    <div>
                        <h1><?= $user['username']?></h1>
                        <a>Inscrit depuis le <?= $date->format('d/m/Y')?></a>
                        <h2><?= $user['description']?></h2>
                        <img src="<?= $user['image']?>" alt="<?= $user['image']?>">
                    </div>
                    <?php
                    if ($id == $_SESSION['id']) { ?>
                    <button type="button" onclick="show('edit','info')">Edit</button>
                    <?php }?>
                </div>
            </div>
        <?php
        if ($id == $_SESSION['id']) { ?>
        <div id="edit" style="display:none">
            <form action="account.php" method="POST" enctype="multipart/form-data">
                <div>
                    <label for="username">Username : </label>
                    <input type="text" name="username" id="username" placeholder="username ... ">
                </div>
                <div>
                    <label for="descrition">Descrition : </label>
                    <input type="text" name="description" id="description" placeholder="description ... ">
                </div>
                <div>
                    <label for="email">Email : </label>
                    <input type="email" name="email" id="email" placeholder="email ... ">
                </div>
                <div>
                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" placeholder="password ... ">
                </div>
                <div>
                    <label for="image">Profile Picture : </label>
                    <input type="file" id="image" name="image">
                </div>
                <button type="submit">Confirm</button><br>
                
            </form>
            <button type="button" onclick="show('info','edit')">Cancel</button>
        </div>
        <?php } ?>
<?php
} else {
        ?>
        <div>  
        <h1 class="Message">You are not connected</h1>
        <input  type="submit" name = "answer" value="Register" class="lonelyBtn"/>  
        <input  type="submit" name = "answer" value="Login" class="lonelyBtn"/>
        </div>
        <?php
    }?>
    <script>
        function show(shown,hidden){
            if (shown == "info"){
                document.getElementById(shown).style.display="grid";
            } else {
                document.getElementById(shown).style.display="block";
            }
            document.getElementById(hidden).style.display="none";
        }
    </script>
</body>
</html>