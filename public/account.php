<?php 
require __DIR__.'/../src/bootstrap.php';
require_once __DIR__ .'/../config/editprofile.php';
include '../config/db.php';
view('header', ['title' => 'New']);
?>
<?php 
if (isset($_SESSION['user'])){
    if(isset($_FILES['image'])&& isset($_POST['username'])){
        updateUser($_SESSION['id'],$_FILES['image'], $_POST['username'], $_POST['description'],$_POST['email'],$_POST['password'],$pdo);
    }
?>
    <?php if (isset($_GET['id'])){
        $queryString = "SELECT * FROM users WHERE id = '" . $_GET['id']."'";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        $date = new DateTime($user['joinDate']);
        ?>
        <div id="info">
            <h1><?= $user['username']?></h1>
            <a>Inscrit de puis le <?= $date->format('d/m/Y')?></a>
            <h2><?= $user['description']?></h2>
            <img src="<?= $user['image']?>" alt="<?= $user['image']?>" >
        </div>
    <?php } else {
        $queryString = "SELECT * FROM users WHERE username = '" . $_SESSION['user']."'";
        $query = $pdo->prepare($queryString);
        $query->execute();
        $user=$query->fetch();
        $date = new DateTime($user['joinDate']);
        ?>
        <div id="info">
            <div>
                <h1><?= $user['username']?></h1>
                <a>Inscrit de puis le <?= $date->format('d/m/Y')?></a>
                <h2><?= $user['description']?></h2>
                <img src="<?= $user['image']?>" alt="<?= $user['image']?>" >
            </div>
            <button type="button" onclick="show('edit','info')">Edit</button>
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
            <button type="button" onclick="show('info','edit')">Cancel</button>
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
        }
    </script>
<?php view('footer') ?>