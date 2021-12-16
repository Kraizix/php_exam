<?php

include '../config/db.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (isset($_POST['answer'])){
    $answer = $_POST['answer'];
    echo $answer;
    switch($answer){
        case 'Logout':
            header("Location:./Method/logout.php");
            break;
        case 'Login':
            header("Location:./login.php");
            break;
        case 'Register':
            header("Location:./register.php");
            break;
    }
}
?>
<form method="post">
    <?php
    if (isset($_SESSION['user'])){
        ?>
        <h2>Welcome <strong><?= $_SESSION['user'] ?></strong> !</h2>
        <input type="submit" name="answer" value="Logout"/> 
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
</form>
