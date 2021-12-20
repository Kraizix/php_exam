<?php
require __DIR__.'/../src/bootstrap.php';
include '../config/db.php';
if (!isset($_SESSION['user'])){
    header("Location: http://localhost:8080/login.php");
}else if (!$_SESSION['admin']){
    ?>
        <h1>Vous n'avez rien à faire ici, SORTEZ !</h1>
        <input  type="button" onclick="document.location='./login.php'" value="Login" class="lonelyBtn"/>
    <?php
}else{
    ?>
    <h1>Bienvenu cher Admin !</h1>
<?php
}