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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
        integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"
        integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Account</title>
</head>
<body>
<?php 
if (isset($_SESSION['user'])){
    if(isset($_FILES['image'])&& isset($_POST['username'])){
        updateUser($_SESSION['id'],$_FILES['image'], $_POST['username'], $_POST['description'],$_POST['email'],$_POST['password'],$pdo);
    }
?>

    <?php if (isset($_GET['id'])){
        $queryString = "SELECT * FROM Users WHERE id = '" . $_GET['id']."'";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        $date = new DateTime($user['joinDate']);
        ?>
            <div class="container">  
            <div class="Posts">
            <?php
                $queryString="SELECT * FROM Articles WHERE UserId= '".$_SESSION['id']."'";
                $results = $pdo->prepare($queryString);
                $results->execute();
                $posts=$results->fetchAll();
                foreach ($posts as $post){
                ?>
                <div class="ui raised link card">
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
                <?php } ?>
            </div>
            <div class="Favs">La y'a les favs mais tkt c'est bientot la</div>
            <div class="User">
                <div>
                    <h1><?= $user['username']?></h1>
                    <a>Inscrit depuis le <?= $date->format('d/m/Y')?></a>
                    <h2><?= $user['description']?></h2>
                    <img src="<?= $user['image']?>" alt="<?= $user['image']?>" height = "450px" width = "450px">
                </div>
            </div>
    <?php } else {
        $queryString = "SELECT * FROM Users WHERE username = '" . $_SESSION['user']."'";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        $date = new DateTime($user['joinDate']);
        ?>
            <div class="container">  
                <div class="Posts">
                <?php
                $queryString="SELECT * FROM Articles WHERE UserId= '".$_SESSION['id']."'";
                $results = $pdo->prepare($queryString);
                $results->execute();
                $posts=$results->fetchAll();
                foreach ($posts as $post){
                ?>
                <div class="ui raised link card">
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
                    <?php } ?>
                </div>
                <div class="Favs">La y'a les favs mais tkt c'est bientot la</div>
                <div class="User">
                    <div>
                        <h1><?= $user['username']?></h1>
                        <a>Inscrit depuis le <?= $date->format('d/m/Y')?></a>
                        <h2><?= $user['description']?></h2>
                        <img src="<?= $user['image']?>" alt="<?= $user['image']?>" height = "450px" width = "450px">
                    </div>
                    <button type="button" onclick="show('edit','container')">Edit</button>
                </div>
            </div>
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
            <button type="button" onClick="show('container','edit')">Cancel</button>
        </div>
    <?php }?>
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
            document.getElementById(shown).style.display="block";
            document.getElementById(hidden).style.display="none";
            document.getElementById(hidden).hidden=false;
        }
    </script>
</body>
</html>