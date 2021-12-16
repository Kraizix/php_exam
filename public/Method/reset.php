<?php
    session_start();
    unset($_SESSION["user"]);
    header("Location: http://localhost/php_exam/index.php");
    die();
?>
